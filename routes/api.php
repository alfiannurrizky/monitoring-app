<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShuffleWebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/soar/wazuh-alert', [ShuffleWebhookController::class, 'handle'])
    ->name('api.soar.alert');
