<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Controllers\Client\VotesController;
use App\Http\Controllers\CampaignParticipantController;
use App\Http\Controllers\GovernmentProjectController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\DonationController;


use App\Http\Controllers\RatesController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\Volunteer\VolunteerProfileController;
use App\Http\Controllers\WorkflowController;
use App\Services\Notifications\FirebaseNotificationService;
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
        Route::get('show/{projectId}' , 'show')->middleware('auth:sanctum');

        Route::get('/myProjects' , 'getMyProjects')->middleware('auth:sanctum');

        Route::delete('/delete/{projectId}',  'destroy')->middleware('auth:sanctum');

        // Recommendations
        Route::post('/recommends' , 'recommendations')->middleware('auth:sanctum');
        //promoted projects
        Route::get('/promoted' , 'getPromoted');
    });



//Join To project campaign , And Handle joined
Route::prefix('/project')
    ->controller(CampaignParticipantController::class)
    ->group(function (){
        Route::get('/join/{projectId}' , 'joinToProject')->middleware('auth:sanctum');

        Route::get('/myJoined' , 'myJoinedProjects')->middleware('auth:sanctum');
    });


// Voting التصويت على المبادرات
Route::prefix('client/project')
    ->controller(VotesController::class)
    ->group(function() {
        Route::post('/vote/{projectId}' , 'vote')->middleware('auth:sanctum');
    });

// Ratings
// إضافة تقييم على مشروع منجز (حملة رسمية)
Route::middleware('auth:sanctum')->post('/ratings', [RatesController::class,'addRateToProject']);

//------------------------------- complaint -------------------------------

Route::prefix('client/complaint')
->middleware(['role:client'])
->middleware('auth:sanctum')
->controller(ComplaintsController::class)
->group(function () {
    Route::post('/create', 'store');
    Route::post('/all' , 'filterComplaintsClient');
    Route::get('/ByID/{id}' , 'complaintsByID');    //get complaints by id
    Route::get('/category/all', 'getAllCategories');
    Route::post('/update/{id}', 'update');
    Route::get('allRegions', 'getAllRegions');

});

Route::get('noToken/allRegions' , [ComplaintsController::class , 'getAllRegions']);


//------------------------------- Volunteer -------------------------------

Route::prefix('volunteer')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('register', 'registerVolunteer');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });

//Profile Volunteer
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/volunteer/profile/{userID}', [VolunteerProfileController::class, 'update']);
    Route::delete('/volunteer/profile/{userID}', [VolunteerProfileController::class, 'destroy']);
    Route::get('/volunteer/show/profile' ,[VolunteerProfileController::class, 'showProfile']);

    Route::get('/volunteer/profile/all' ,[VolunteerProfileController::class, 'getAllVolunteersProfiles']);

});


Route::middleware(['auth:sanctum'])->prefix('project')->controller(CampaignParticipantController::class)
    ->group(function () {
    Route::get('/pending-joins', 'getPendingJoins');
    Route::post('/approve-join/{participantId}',  'approveJoinRequest');
});



//------------------------------- governorator admin -------------------------------

Route::prefix('admin/complaint')
->middleware(['role:government_admin'])
->middleware('auth:sanctum')
->controller(ComplaintsController::class)
->group(function () {

    Route::post('/all' , 'filterComplaintsAdmin');

    Route::get('/ByID/{id}' , 'complaintsByID');

    Route::post('/{id}/updateStatus', 'updateStatus');
    Route::get('/formalbook/{id}', 'getFormalBook');
    Route::get('/download/formalbook/{id}', 'downloadFormalBook');

    /////category
    Route::get('/category/all', 'getAllCategories');
    Route::post('/category/create', 'createCategory')->name('createCategory');
    Route::post('/category/update/{id}', 'updateCategory');
    Route::delete('/category/delete/{id}', 'deleteCategory');
});

// تحديث حالة الحملة الرسمية الى منجزة
Route::middleware('auth:sanctum')
    ->post('/volunteer/{projectId}/promote'  , [GovernmentProjectController::class , 'assignAsCompleted']);






//------------------------------- Admin -------------------------------

Route::middleware('auth:sanctum')
    ->prefix('government/projects')
    ->controller(GovernmentProjectController::class)
    ->group(function () {
    Route::get('/initiatives','index');
    Route::post('/{projectId}/promote',  'promote');
});


Route::prefix('categories')->group(function () {
    Route::post('/', [CategoryController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/', [CategoryController::class, 'index']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('statistics')->controller(StatisticsController::class)->group(function () {
    Route::get('basic-counts',  'basicCounts');
    Route::get('top-rated-projects', 'topRatedProjects');
    Route::get('most-participated-projects', 'mostParticipatedProjects');
    Route::get('projects-by-category',  'projectsByCategory');
    Route::get('votes-summary', 'votesSummary');

    Route::get('user-role-distribution', 'userRoleDistribution');
    Route::get('weekly-participation',  'weeklyParticipation');

    Route::get('/official-campaigns', [StatisticsController::class, 'getOfficialCampaigns']);
    Route::get('/initiatives', [StatisticsController::class, 'getInitiatives']);
    Route::get('/complaints/locations', [StatisticsController::class, 'complaintsByLocation']);
    Route::get('/complaints', [StatisticsController::class, 'getComplaintStats']);

    Route::get('/monthly', [StatisticsController::class, 'getMonthlyStatistics']);

    Route::get('/status', [StatisticsController::class, 'getNumberProjectsStatus']);


    Route::get('/low-engagement', [StatisticsController::class, 'getLowEngagementCampaigns']);
    Route::post('campaigns/{id}/promote', [StatisticsController::class, 'promoteCampaign'])->middleware('auth:sanctum')->middleware(['role:government_admin']);
    Route::post('campaigns/{id}/archive', [StatisticsController::class, 'archiveCampaign'])->middleware('auth:sanctum')->middleware(['role:government_admin']);
    Route::get('/complaints', 'getComplaintStatistics');
    Route::get('/payment ', 'getPaymentStatistics');
    Route::get('/pointSystem ', 'getPointSystemStatistics');




});

Route::middleware(['role:client'])
->middleware('auth:sanctum')
->prefix('Donation')->controller(DonationController::class)
->group(function () {
    Route::post('/donate',  'donate');
});



Route::prefix('Donation')
    ->controller(DonationController::class)
    ->group(function () {
        Route::post('/stripe/webhook', 'handle');
        Route::get('/monitoring', 'monitoring')->middleware('auth:sanctum')->middleware(['role:government_admin']);
        Route::get('myDonations' , 'myDonations')->middleware('auth:sanctum');
});

// Notifications
Route::middleware('auth:sanctum')->get('/notifications', [NotificationController::class, 'index']);


// Workflow

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/complaints', [WorkflowController::class, 'index']);
    Route::get('/complaints/{id}', [WorkflowController::class, 'show']);
    Route::get('/complaints/{id}/logs', [WorkflowController::class, 'logs']);
    Route::post('/complaints/{id}/status', [WorkflowController::class, 'changeStatus']);
    Route::post('/complaints/{id}/assign', [WorkflowController::class, 'assignToFieldAgent']);
});
