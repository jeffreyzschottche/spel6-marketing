<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
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
