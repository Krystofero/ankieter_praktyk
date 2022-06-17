<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ModeratorQuestionnaireController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/users/list', [UsersController::class, 'index'])->middleware('auth');  #->middleware('auth')  -wymagane jest wcześniejsze zalogowanie się
Route::middleware(['auth', 'verified'])->group(function() { #grupa zalogowanych użytkowników
    Route::middleware(['can:isAdmin'])->group(function() { #grupa Administrator
        Route::resource('users', UsersController::class)->only([
            'index', 'edit', 'update', 'destroy'
        ]);  # ->middleware('auth')  -wymagane jest wcześniejsze zalogowanie się 

    });

    Route::middleware(['can:isModer'])->group(function() { #grupa Moderator

        Route::get('/questionnairesModerator/create', [ModeratorQuestionnaireController::class, 'create']);
        Route::get('/questionnairesModerator/{questionnaire}', [ModeratorQuestionnaireController::class, 'show']);
        Route::get('/questionnairesModerator/stats/{questionnaire}', [ModeratorQuestionnaireController::class, 'stats']);
        Route::get('/questionnairesModerator/{questionnaire}/questions/create', [QuestionController::class, 'create']);
        Route::post('/questionnairesModerator/{questionnaire}/questions', [QuestionController::class, 'store']);
        Route::delete('/questionnairesModerator/{questionnaire}/questions/{question}', [QuestionController::class, 'destroy']);
        Route::delete('/questionnairesModerator/{questionnaire}', [ModeratorQuestionnaireController::class, 'destroy']);

        Route::get('/questionnairesModerator/downloadPDF/{questionnaire}', [ModeratorQuestionnaireController::class, 'downloadPDF']);

        Route::resource('questionnairesModerator', ModeratorQuestionnaireController::class)->only([ //ankiety moderatora
            'index', 'store', 'edit', 'create', 'update', 'show', 'destroy'
        ]); 
        Route::resource('question', QuestionController::class)->only([ //pytania
            'create'
        ]); 
    });

    Route::middleware(['can:isStudent'])->group(function() { #grupa Student
        Route::get('/questionnaires/{questionnaire}', [QuestionnaireController::class, 'show']);
        Route::post('/surveys/{questionnaire}', [QuestionnaireController::class, 'store']);

        Route::resource('questionnaires', QuestionnaireController::class)->only([
            'index', 'show', 'store'
        ]); 
    });
  
});

Auth::routes();  // Klasa Auth ma ukryty routing i endpointy które kierują do kontrolerów (wszystkie routes)

