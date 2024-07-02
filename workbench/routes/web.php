<?php

use Illuminate\Support\Facades\Route;
use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('stream', function () {
    $response = OpenAI::chat()->stream(function (string $newChunk, string $message) {
        echo $newChunk;
    })->create(
        model: 'gpt-3.5-turbo',
        messages: (new Messages)->system('You are a helpful assistant.')->user('Write me a poem with 8 rows.'),
    );
    dump($response);

    $response = OpenAI::chat()->create(
        model: 'gpt-3.5-turbo',
        messages: (new Messages)->system('You are a helpful assistant.')->user('Write me a poem with 8 rows.'),
    );
    dump($response);
});
