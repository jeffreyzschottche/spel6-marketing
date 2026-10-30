<?php

namespace Tests\Feature;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Spel6QuestionsApiTest extends TestCase
{
    use RefreshDatabase;

    private const TOKEN = 'test-cms-token-0123456789abcdef0123456789';

    protected function setUp(): void
    {
        parent::setUp();
        config(['spel6.cms_token' => self::TOKEN]);
    }

    private function cms(): static
    {
        return $this->withToken(self::TOKEN);
    }

    private function quiz(array $overrides = []): array
    {
        return array_replace_recursive([
            'gamemode' => 'quiz',
            'vibe' => ['party', 'friends'],
            'filters' => ['normal'],
            'answerLogic' => 'multi_choice_with_answer',
            'resultLogic' => ['onCorrect' => ['penalty' => 'none', 'reward' => 'correctActors']],
            'translations' => [
                'nl' => ['question' => 'Hoofdstad van Frankrijk?', 'options' => ['A' => 'Parijs', 'B' => 'Lyon'], 'answer' => 'A'],
                'en' => ['question' => 'Capital of France?', 'options' => ['A' => 'Paris', 'B' => 'Lyon'], 'answer' => 'A'],
            ],
        ], $overrides);
    }

    public function test_cms_token_is_required_and_failures_are_rate_limited(): void
    {
        config(['spel6.cms_token' => 'too-short']);
        $this->getJson('/api/v1/cms/questions')->assertStatus(503)->assertJsonPath('message', 'cms_not_configured');

        config(['spel6.cms_token' => self::TOKEN]);
        $this->getJson('/api/v1/cms/questions')->assertUnauthorized();
        for ($i = 0; $i < 4; $i++) {
            $this->withToken('wrong-token')->getJson('/api/v1/cms/questions')->assertUnauthorized();
        }
        $this->cms()->getJson('/api/v1/cms/questions')->assertStatus(429)->assertHeader('Retry-After');
    }

    public function test_the_app_endpoint_is_public_and_never_writable(): void
    {
        $this->getJson('/api/v1/questions')->assertOk()->assertJsonPath('data', []);
        $this->postJson('/api/v1/questions', $this->quiz())->assertStatus(405);
    }

    public function test_store_creates_the_card_and_the_app_gets_it_per_language(): void
    {
        $id = $this->cms()->postJson('/api/v1/cms/questions', $this->quiz())->assertCreated()
            ->assertJsonPath('data.translations.nl.question', 'Hoofdstad van Frankrijk?')
            ->assertJsonPath('data.translations.en.enabled', true)
            ->json('data.id');

        $this->getJson('/api/v1/questions?lang=en&gamemodes=quiz,dilemma')->assertOk()
            ->assertJsonPath('data.0.id', $id)
            ->assertJsonPath('data.0.question', 'Capital of France?')
            ->assertJsonPath('data.0.language', 'en')
            ->assertJsonPath('data.0.answer', 'A')
            ->assertJsonPath('data.0.options.A', 'Paris')
            ->assertJsonPath('data.0.answerLogic', 'multi_choice_with_answer')
            ->assertJsonPath('data.0.resultLogic.onCorrect.reward', 'correctActors');
        $this->getJson('/api/v1/questions?lang=de')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/v1/questions?lang=nl&gamemodes=chaos')->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_index_lists_disabled_questions_with_all_languages(): void
    {
        $this->cms()->postJson('/api/v1/cms/questions', $this->quiz());
        $this->cms()->postJson('/api/v1/cms/questions', $this->quiz(['gamemode' => 'chaos', 'answerLogic' => 'group_task_with_loser', 'enabled' => false]));

        $this->cms()->getJson('/api/v1/cms/questions')->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.gamemode', 'chaos')
            ->assertJsonPath('data.0.enabled', false)
            ->assertJsonPath('data.0.translations.en.question', 'Capital of France?')
            ->assertJsonPath('languages', ['nl', 'en', 'de', 'es']);
        $this->cms()->getJson('/api/v1/cms/questions?gamemode=quiz')->assertOk()->assertJsonCount(1, 'data');
        $this->getJson('/api/v1/questions?lang=nl')->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_update_merges_translations_and_switches_cards_off(): void
    {
        $id = $this->cms()->postJson('/api/v1/cms/questions', $this->quiz())->json('data.id');

        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", [
            'filters' => ['normal', 'deep'],
            'translations' => [
                'nl' => ['question' => 'Wat is de hoofdstad van Frankrijk?', 'condition' => 'Lees alle opties voor.'],
                'de' => ['question' => 'Hauptstadt von Frankreich?', 'options' => ['A' => 'Paris', 'B' => 'Lyon'], 'answer' => 'A'],
                'en' => ['enabled' => false],
            ],
        ])->assertOk()
            ->assertJsonPath('data.filters', ['normal', 'deep'])
            ->assertJsonPath('data.translations.nl.options.A', 'Parijs')
            ->assertJsonPath('data.translations.en.question', 'Capital of France?')
            ->assertJsonPath('data.translations.en.enabled', false);

        $this->getJson('/api/v1/questions?lang=nl')->assertJsonPath('data.0.condition', 'Lees alle opties voor.');
        $this->getJson('/api/v1/questions?lang=de')->assertJsonPath('data.0.question', 'Hauptstadt von Frankreich?');
        $this->getJson('/api/v1/questions?lang=en')->assertJsonCount(0, 'data');

        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", ['translations' => ['nl' => ['condition' => null]]])->assertOk();
        $this->getJson('/api/v1/questions?lang=nl')->assertJsonMissingPath('data.0.condition');

        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", ['enabled' => false])->assertOk()->assertJsonPath('data.enabled', false);
        $this->getJson('/api/v1/questions?lang=nl')->assertJsonCount(0, 'data');
    }

    public function test_invalid_input_is_rejected_without_changes(): void
    {
        $this->cms()->postJson('/api/v1/cms/questions', $this->quiz(['filters' => ['wild']]))->assertUnprocessable()->assertJsonValidationErrors('filters.0');
        $this->cms()->postJson('/api/v1/cms/questions', $this->quiz(['gamemode' => 'bogus']))->assertUnprocessable()->assertJsonValidationErrors('gamemode');
        $this->cms()->postJson('/api/v1/cms/questions', ['gamemode' => 'chaos', 'vibe' => ['party'], 'filters' => ['normal'], 'translations' => ['en' => ['question' => 'Only English']]])
            ->assertUnprocessable()->assertJsonValidationErrors('translations.nl.question');
        $this->cms()->postJson('/api/v1/cms/questions', $this->quiz(['translations' => ['fr' => ['question' => 'Capitale?']]]))
            ->assertUnprocessable()->assertJsonValidationErrors('translations');
        $this->assertSame(0, Question::count());

        $id = $this->cms()->postJson('/api/v1/cms/questions', $this->quiz())->json('data.id');
        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", [])->assertUnprocessable();
        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", ['filters' => ['deep'], 'translations' => ['es' => ['enabled' => true]]])
            ->assertUnprocessable()->assertJsonValidationErrors('translations.es.question');
        $this->cms()->patchJson("/api/v1/cms/questions/{$id}", ['translations' => ['nl' => ['enabled' => false]]])
            ->assertUnprocessable()->assertJsonValidationErrors('translations.nl.enabled');
        $this->assertSame(['normal'], Question::find($id)->filters);
        $this->assertSame(2, Question::find($id)->translations()->count());
    }

    public function test_show_and_destroy(): void
    {
        $id = $this->cms()->postJson('/api/v1/cms/questions', $this->quiz())->json('data.id');
        $this->cms()->getJson("/api/v1/cms/questions/{$id}")->assertOk()->assertJsonPath('data.id', $id);
        $this->cms()->deleteJson("/api/v1/cms/questions/{$id}")->assertOk()->assertJsonPath('deleted', $id);
        $this->cms()->getJson("/api/v1/cms/questions/{$id}")->assertNotFound();
        $this->assertDatabaseCount('question_translations', 0);
    }

    public function test_the_capacitor_app_may_read_the_questions(): void
    {
        foreach (['capacitor://localhost', 'https://localhost'] as $origin) {
            $this->withHeaders(['Origin' => $origin])->getJson('/api/v1/questions')->assertOk()
                ->assertHeader('Access-Control-Allow-Origin', $origin);
        }
    }
}
