<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;
use App\Http\Middleware\ValidParenthesesToken;

Route::prefix('v1')->group(function () {
    Route::post('short-urls', [UrlShortenerController::class, 'store'])
        ->middleware(ValidParenthesesToken::class)
        ->name('store-short-urls');
});
