<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionTranslation extends Model
{
    protected $fillable = ['question_id', 'language', 'question', 'condition', 'options', 'answer', 'enabled'];

    protected $casts = [
        'options' => 'array',
        'answer' => 'json',
        'enabled' => 'boolean',
    ];

    public function card(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
