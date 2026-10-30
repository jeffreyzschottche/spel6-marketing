<?php

namespace App\Http\Controllers\Spel6;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * The questions the Spel6 app loads next to its bundled ones. Only active cards with an active
 * text in the requested language; there is no fallback to another language.
 */
class QuestionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lang' => ['nullable', Rule::in(config('spel6.languages'))],
            'language' => ['nullable', Rule::in(config('spel6.languages'))],
            'gamemode' => ['nullable', Rule::in(config('spel6.gamemodes'))],
            'gamemodes' => ['nullable', 'string', 'max:200'],
        ]);
        $language = $data['lang'] ?? $data['language'] ?? 'nl';
        $modes = array_values(array_filter(array_map('trim', explode(',', (string) ($data['gamemodes'] ?? '')))));

        $questions = Question::query()
            ->where('enabled', true)
            ->when($data['gamemode'] ?? null, fn (Builder $query, string $mode) => $query->where('gamemode', $mode))
            ->when($modes, fn (Builder $query) => $query->whereIn('gamemode', $modes))
            ->whereHas('translations', fn (Builder $query) => $query->where('language', $language)->where('enabled', true))
            ->with(['translations' => fn ($query) => $query->where('language', $language)])
            ->orderBy('id')
            ->get();

        return response()->json([
            'data' => $questions->map(fn (Question $question) => $question->toAppPayload($question->translations->first()))->values(),
            'updated_at' => QuestionTranslation::max('updated_at') ?? Question::max('updated_at'),
        ])->header('Cache-Control', 'public, max-age=300');
    }
}
