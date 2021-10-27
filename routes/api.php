<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserInvitationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\SubscriptionRecordController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConclusionController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\EngagementInviteController;
use App\Http\Controllers\EngagementNoteController;
use App\Http\Controllers\ExecutionController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\MaterialityController;
use App\Http\Controllers\TransactionTestController;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', LoginController::class);
    Route::post('logout', LogoutController::class);
    Route::post('register/admin', [RegisterController::class, 'admin']);
    Route::post('register/company', [RegisterController::class, 'company'])->middleware('admin');
    Route::patch('forgot-password/{token}', [ForgotPasswordController::class, 'storeNewPassword']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::patch('reset-password', ResetPasswordController::class);
    Route::post('users/invite', [UserInvitationController::class, 'sendInvite']);
    Route::post('users/register/{token}', [UserInvitationController::class, 'registerInvitedUser']);
});


Route::group(['middleware' => 'admin'], function () {
    //Roles
    Route::get('roles', [RoleController::class, 'index']);

    //Permission management
    Route::get('users-role', [UserRoleController::class, 'companyUsersRole']);
    Route::post('assign-role', [UserRoleController::class, 'assignRoleToUser']);
    Route::post('remove-role', [UserRoleController::class, 'removeRoleFromUser']);

    //    Subscription
    Route::get('subscriptions/packages', SubscriptionPackageController::class);
    Route::get('subscriptions', SubscriptionRecordController::class);
    Route::post('subscriptions', SubscriptionController::class);

    Route::get('company', [CompanyController::class, 'profile']);
    Route::post('company', [CompanyController::class, 'update']);
});

Route::group(['middleware' => 'user'], function () {
    //Permission management
    Route::post('user', [UserRoleController::class, 'userRole']);
    //User
    Route::get('user', [UserController::class, 'profile']);
    //User
    Route::post('user', [UserController::class, 'update']);
    // Client
    Route::resource('clients', ClientController::class);

    // Engagement Note
    Route::resource('engagements/{engagementId}/notes', EngagementNoteController::class);

    // Planning
    Route::resource('engagements/{engagementId}/plannings', PlanningController::class);
    Route::post('plannings/{planningId}/materialities', [MaterialityController::class, 'store']);
    Route::post('transaction-classes/{classId}/tests', [TransactionTestController::class, 'store']);


    // Execution
    Route::resource('engagements/{engagementId}/executions', ExecutionController::class);

    // Conclusions
    Route::resource('engagements/{engagementId}/conclusions', ConclusionController::class);


    // Engagement Invite
    Route::post('engagements/send-invite', [EngagementInviteController::class, 'send']);
    Route::get('engagements/accept-invite/{token}', [EngagementInviteController::class, 'accept']);
    Route::get('engagements/decline-invite/{token}', [EngagementInviteController::class, 'decline']);

    // Engagement
    Route::resource('engagements', EngagementController::class);


    // Planning
    Route::resource('plannings', PlanningController::class);
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
