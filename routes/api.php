<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\SubscriptionsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Get all topics
Route::get('/topics', [TopicsController::class , 'retrieveTopics'])->name("retrieveTopics");


// Create New Topic
Route::post('/topics', [TopicsController::class , 'createTopic'])->name("createTopic");

//Create a subscription POST /subscribe/{topic}
Route::post('/subscribe/{topic}', [SubscriptionsController::class , 'subscribe'])->name("subscribe");

//Publish topic POST /publish/{topic}
Route::post('/publish/{topic}', [SubscriptionsController::class , 'publish'])->name("publish");