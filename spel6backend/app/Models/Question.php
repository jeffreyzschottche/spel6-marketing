<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** A Spel6 question card; its texts live per language in QuestionTranslation. */
class Question extends Model
{
    protected $fillable = ['gamemode', 'vibe', 'filters', 'answer_logic', 'result_logic', 'actors', 'targets', 'enabled'];

    protected $casts = [
        'vibe' => 'array',
        'filters' => 'array',
        'result_logic' => 'array',
        'actors' => 'array',
        'targets' => 'array',
        'enabled' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(QuestionTranslation::class);
    }

    /** The shape the app reads (spel6/services/questionService.ts), for one language. */
    public function toAppPayload(QuestionTranslation $text): array
    {
        return array_filter([
            'id' => $this->id,
            'question' => $text->question,
            'condition' => $text->condition,
            'language' => $text->language,
            'gamemode' => $this->gamemode,
            'vibe' => $this->vibe ?? [],
            'filters' => $this->filters ?? [],
            'actors' => $this->actors,
            'targets' => $this->targets,
            'answerLogic' => $this->answer_logic,
            'resultLogic' => $this->result_logic,
            'options' => $text->options,
            'answer' => $text->answer,
        ], fn ($value) => $value !== null);
    }
}
