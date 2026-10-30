<?php

return [
    // Server-only key for Zschot CMS (/api/v1/cms/*). At least 32 characters: `openssl rand -hex 32`.
    // Never put it in the app, the marketing site or a repository.
    'cms_token' => env('SPEL6_CMS_TOKEN', ''),

    // The values the Spel6 app understands (spel6/composables/useFiltersContent.ts and data/questions).
    'languages' => ['nl', 'en', 'de', 'es'],
    'gamemodes' => ['knowme', 'chaos', 'songbird', 'quiz', 'dilemma', 'likely'],
    'vibes' => ['party', 'friends', 'colleagues', 'date'],
    'filters' => ['normal', 'deep', 'spicy', '18plus', 'random_penalty'],
    'answer_logics' => [
        'majority_wins_loser_picked', 'most_voted_gets_penalty', 'match_target_answer', 'both_match_target',
        'anyone_guesses_correct', 'multi_choice_with_answer', 'group_task_with_loser', 'fastest_correct_guess',
        'duo_guess_match', 'single_guess_match',
    ],
];
