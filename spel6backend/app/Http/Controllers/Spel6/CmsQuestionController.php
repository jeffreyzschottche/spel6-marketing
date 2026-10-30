<?php

namespace App\Http\Controllers\Spel6;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Question management for Zschot CMS (bearer SPEL6_CMS_TOKEN). Every question comes with all its
 * languages and their enabled state, including switched-off cards.
 */
class CmsQuestionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate(['gamemode' => ['nullable', Rule::in(config('spel6.gamemodes'))]]);

        $questions = Question::query()
            ->with('translations')
            ->when($data['gamemode'] ?? null, fn ($query, $mode) => $query->where('gamemode', $mode))
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $questions->map(fn (Question $question) => $this->payload($question))->values(),
            'languages' => config('spel6.languages'),
            'updated_at' => $questions->max('updated_at')?->toIso8601String(),
        ]);
    }

    public function show(Question $question): JsonResponse
    {
        return response()->json(['data' => $this->payload($question->load('translations'))]);
    }

    public function store(Request $request): JsonResponse
    {
        $card = $this->validatedCard($request, creating: true);
        $translations = $this->validatedTranslations($request, required: true);
        if (! isset($translations['nl']['question'])) {
            throw ValidationException::withMessages(['translations.nl.question' => 'De Nederlandse vraag is verplicht.']);
        }

        $question = DB::transaction(function () use ($card, $translations) {
            $question = Question::create($card);
            $this->syncTranslations($question, $translations);

            return $question;
        });

        return response()->json(['data' => $this->payload($question->fresh('translations'))], 201);
    }

    public function update(Request $request, Question $question): JsonResponse
    {
        $card = $this->validatedCard($request, creating: false);
        $translations = $this->validatedTranslations($request, required: false);
        if ($card === [] && $translations === []) {
            throw ValidationException::withMessages(['question' => 'Geen wijzigingen meegegeven.']);
        }

        DB::transaction(function () use ($question, $card, $translations) {
            $question->update($card);
            $this->syncTranslations($question, $translations);
            $question->touch();
        });

        return response()->json(['data' => $this->payload($question->fresh('translations'))]);
    }

    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json(['deleted' => $question->id]);
    }

    private function payload(Question $question): array
    {
        return [
            'id' => $question->id,
            'gamemode' => $question->gamemode,
            'vibe' => $question->vibe ?? [],
            'filters' => $question->filters ?? [],
            'answerLogic' => $question->answer_logic,
            'resultLogic' => $question->result_logic,
            'actors' => $question->actors,
            'targets' => $question->targets,
            'enabled' => (bool) $question->enabled,
            'translations' => $question->translations->keyBy('language')->map(fn ($t) => array_filter([
                'question' => $t->question,
                'condition' => $t->condition,
                'options' => $t->options,
                'answer' => $t->answer,
                'enabled' => (bool) $t->enabled,
            ], fn ($value) => $value !== null))->sortKeys()->all(),
            'updated_at' => $question->updated_at?->toIso8601String(),
        ];
    }

    private function validatedCard(Request $request, bool $creating): array
    {
        $required = $creating ? 'required' : 'sometimes';
        $data = $request->validate([
            'gamemode' => [$required, Rule::in(config('spel6.gamemodes'))],
            'vibe' => [$required, 'array', 'min:1'],
            'vibe.*' => ['distinct', Rule::in(config('spel6.vibes'))],
            'filters' => [$required, 'array', 'min:1'],
            'filters.*' => ['distinct', Rule::in(config('spel6.filters'))],
            'answerLogic' => ['sometimes', 'nullable', Rule::in(config('spel6.answer_logics'))],
            'resultLogic' => ['sometimes', 'nullable', 'array'],
            'actors' => ['sometimes', 'nullable', 'array'],
            'actors.*' => ['string'],
            'targets' => ['sometimes', 'nullable', 'array'],
            'targets.*' => ['string'],
            'enabled' => ['sometimes', 'boolean'],
        ]);

        foreach (['answerLogic' => 'answer_logic', 'resultLogic' => 'result_logic'] as $from => $to) {
            if (array_key_exists($from, $data)) {
                $data[$to] = $data[$from];
                unset($data[$from]);
            }
        }
        foreach (['vibe', 'filters'] as $key) {
            if (isset($data[$key])) {
                $data[$key] = array_values($data[$key]);
            }
        }

        return $data;
    }

    /** @return array<string, array> Keyed by language; only the keys that were sent. */
    private function validatedTranslations(Request $request, bool $required): array
    {
        $request->validate([
            'translations' => [$required ? 'required' : 'sometimes', 'array'],
            'translations.*' => ['array'],
            'translations.*.question' => ['sometimes', 'string', 'max:2000'],
            'translations.*.condition' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'translations.*.options' => ['sometimes', 'nullable', 'array'],
            'translations.*.answer' => ['sometimes', 'nullable'],
            'translations.*.enabled' => ['sometimes', 'boolean'],
        ]);

        $translations = (array) $request->input('translations', []);
        $unknown = array_diff(array_keys($translations), config('spel6.languages'));
        if ($unknown) {
            throw ValidationException::withMessages(['translations' => 'Onbekende taal: '.implode(', ', $unknown).'.']);
        }

        return collect($translations)->map(fn ($text) => collect($text)
            ->only(['question', 'condition', 'options', 'answer', 'enabled'])
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all())->all();
    }

    /** Creates or merges translations; a new one needs a question, and Dutch cannot be switched off. */
    private function syncTranslations(Question $question, array $translations): void
    {
        foreach ($translations as $language => $text) {
            $existing = $question->translations()->where('language', $language)->first();
            if (! $existing && empty($text['question'])) {
                throw ValidationException::withMessages(["translations.{$language}.question" => "Een nieuwe vertaling ({$language}) heeft een vraag nodig."]);
            }
            if (array_key_exists('question', $text) && $text['question'] === '') {
                throw ValidationException::withMessages(["translations.{$language}.question" => 'De vraag mag niet leeg zijn.']);
            }
            if ($language === 'nl' && ($text['enabled'] ?? true) === false) {
                throw ValidationException::withMessages(['translations.nl.enabled' => 'Nederlands kan niet uit; zet de hele vraag uit.']);
            }

            $values = $text + ($existing ? [] : ['enabled' => true]);
            if (array_key_exists('condition', $values) && $values['condition'] === '') {
                $values['condition'] = null;
            }
            $existing ? $existing->update($values) : $question->translations()->create($values + ['language' => $language]);
        }
    }
}
