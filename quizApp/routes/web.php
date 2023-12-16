<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\participantOperation;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');


Route::prefix('admin')->middleware('theme:dashboard')->name('admin.')->group(function(){
   
        
       
        Route::middleware(['auth:admin'])->group(function(){

            Route::get('/dashboard',[AdminController::class,'index']);
            Route::get('/manage_quiz',[AdminController::class,'manage_quiz']);
            Route::get('/quiz_status/{id}',[AdminController::class,'quiz_status']);
            Route::get('/delete_quiz/{id}',[AdminController::class,'delete_quiz']);
            Route::get('/edit_quiz/{id}',[AdminController::class,'edit_quiz']);
            Route::get('/edit_participants/{id}',[AdminController::class,'edit_participants']);
            Route::get('/manage_participants',[AdminController::class,'manage_participants']);
            Route::get('/participant_status/{id}',[AdminController::class,'participant_status']);
            Route::get('/delete_participants/{id}',[AdminController::class,'delete_participants']);
            Route::get('/add_questions/{id}',[AdminController::class,'add_questions']);
            Route::get('/question_status/{id}',[AdminController::class,'question_status']);
            Route::get('/delete_question/{id}',[AdminController::class,'delete_question']);
            Route::get('/update_question/{id}',[AdminController::class,'update_question']);
            Route::get('/registered_participants',[AdminController::class,'registered_participants']);
            Route::get('/delete_registered_participants/{id}',[AdminController::class,'delete_registered_participants']);
            Route::get('/apply_quiz/{id}',[AdminController::class,'apply_quiz']);
            Route::get('/admin_view_result/{id}',[AdminController::class,'admin_view_result']);
    
            Route::post('/edit_question_inner',[AdminController::class,'edit_question_inner']);
            Route::post('/add_new_question',[AdminController::class,'add_new_question']);
            Route::post('/edit_participants_final',[AdminController::class,'edit_participants_final']);
            Route::post('/add_new_quiz',[AdminController::class,'add_new_quiz']);
            Route::post('/add_new_category',[AdminController::class,'add_new_category']);
            Route::post('/edit_new_category',[AdminController::class,'edit_new_category']);
            Route::post('/edit_quiz_sub',[AdminController::class,'edit_quiz_sub']);
            Route::post('/add_new_participants',[AdminController::class,'add_new_participants']);
        
        });
        

       
});



/* participant section routes */
Route::prefix('participant')->middleware('theme:dashboard')->name('participant.')->group(function(){
    

    Route::middleware(['auth:web'])->group(function(){    
        Route::get('/dashboard',[participantOperation::class,'dashboard']);
   
        Route::get('/quiz',[participantOperation::class,'quiz']);
        Route::get('/join_quiz/{id}',[participantOperation::class,'join_quiz']);
        Route::post('/submit_questions',[participantOperation::class,'submit_questions']);
        Route::get('/show_result/{id}',[participantOperation::class,'show_result']);
        Route::get('/apply_quiz/{id}',[participantOperation::class,'apply_quiz']);
        Route::get('/view_result/{id}',[participantOperation::class,'view_result']);
        Route::get('/view_answer/{id}',[participantOperation::class,'view_answer']);



        Route::get('/logout',[AuthenticatedSessionController::class,'destroy']);
    });

    
});



require __DIR__.'/auth.php';
require __DIR__.'/admin.php';