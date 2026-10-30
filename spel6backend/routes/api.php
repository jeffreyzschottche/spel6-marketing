<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Spel6\CmsQuestionController;
use App\Http\Controllers\Spel6\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/greet', function () {
    // Gebruik de helper 'response()->json()'
    return response()->json(['name' => 'hi']);

    // OF retourneer direct een array; Laravel converteert dit automatisch naar JSON
    // Mits de 'Accept: application/json' header wordt meegestuurd
    // return ['name' => 'hi'];
});

Route::get('/pages/{page}/content', [ContentController::class, 'show']);
Route::post('/contact', ContactController::class);

// Spel6 app: questions it loads next to its bundled ones.
Route::get('/v1/questions', [QuestionController::class, 'index'])->middleware('throttle:120,1');

// Zschot CMS, with the server-only SPEL6_CMS_TOKEN.
Route::prefix('v1/cms')->middleware(['throttle:120,1', 'spel6.cms'])->group(function () {
    Route::get('/questions', [CmsQuestionController::class, 'index']);
    Route::post('/questions', [CmsQuestionController::class, 'store']);
    Route::get('/questions/{question}', [CmsQuestionController::class, 'show']);
    Route::patch('/questions/{question}', [CmsQuestionController::class, 'update']);
    Route::delete('/questions/{question}', [CmsQuestionController::class, 'destroy']);
});
