<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'auth'], function (){
    Route::group(["middleware" => ["role:admin"]], function(){
        Route::apiResource('users', UserController::class);
        Route::apiResource('tasks', TaskController::class);
    Route::apiResource('quizzes', QuizController::class);
    Route::apiResource('questions', QuestionController::class);
    });    
    
    Route::group(["middleware"=>["role:member"]], function(){
       Route::get('user/quizzes', [UserController::class, 'getQuizzes']); 
       Route::get('user/questions', [UserController::class, 'getQuestions']);
       Route::post('user/answer/question/{question}', [UserController::class, 'answerQuestion']);
    });

});


Route::post('login', [AuthController::class,'login']);
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::post('me', 'AuthController@me');