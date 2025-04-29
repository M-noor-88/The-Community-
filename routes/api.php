<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Controllers\Client\VotesController;
use App\Http\Controllers\CampaignParticipantController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//------------------------------- Client -------------------------------

Route::prefix('client')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('initiate_registration','initiate_registration');
        Route::post('confirm_registration', 'confirm_registration');
        Route::post('resend_code', 'resend_code');
        Route::post('reset_password', 'reset_password');
        Route::post('confirm_reset_password','confirm_reset_password');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });

// Profile Client
Route::prefix('client')
    ->controller(ClientProfileController::class)
    ->group(function () {
        Route::get('/profile/show/{id}', 'show');
        Route::get('/profile/show', 'show')->middleware('auth:sanctum');
        Route::post('/profile/update', 'update')->middleware('auth:sanctum');
    });


// Project Creation and Handling
Route::prefix('client/project')
    ->controller(ProjectController::class)
    ->group(function () {
        Route::post('/create', 'store')->middleware('auth:sanctum');

        // جميع المبادرات التي تحتاج الى تصويت ( من المستخدمين)
        Route::post('/all' , 'getProjects');

        // جميع المشاريع , المبادرات أو الحملات الرسمية حسب التصنيف
        Route::post('/all/{category_id}' , 'getProjectsByCategory');
        // جميع المشاريع , المبادرات أو الحملات الرسمية حسب التصنيف القريبة من موقع المستخدم
        Route::post('/nearby','getNearbyProjects')->middleware('auth:sanctum');

        // حملة رسمية فقط  show specific
        Route::get('show/{projectId}' , 'show');
    });



//Join To project campaign , And Handle joined
Route::prefix('/project')
    ->controller(CampaignParticipantController::class)
    ->group(function (){
        Route::get('/join/{projectId}' , 'joinToProject')->middleware('auth:sanctum');
    });


// Voting التصويت على المبادرات
Route::prefix('client/project')
    ->controller(VotesController::class)
    ->group(function() {
        Route::post('/vote/{projectId}' , 'vote')->middleware('auth:sanctum');
    });






//------------------------------- Volunteer -------------------------------

Route::prefix('volunteer')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('register', 'registerVolunteer');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });


Route::middleware(['auth:sanctum'])->prefix('project')->controller(CampaignParticipantController::class)
    ->group(function () {
    Route::get('/pending-joins', 'getPendingJoins');
    Route::post('/approve-join/{participantId}',  'approveJoinRequest');
});
