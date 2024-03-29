<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssertionController;
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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EngagementApprovalController;
use App\Http\Controllers\EngagementController;
use App\Http\Controllers\EngagementInviteController;
use App\Http\Controllers\EngagementNoteController;
use App\Http\Controllers\EngagementTeamRolesController;
use App\Http\Controllers\ExecutionController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\MaterialityController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TrialBalanceController;
use App\Http\Controllers\UsersController;

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
    Route::patch('forgot-password/{token}', [ForgotPasswordController::class, 'storeNewPassword']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::patch('reset-password', ResetPasswordController::class);
    Route::get('users/invite/{token}', [UserInvitationController::class, 'getInvitationInfo']);
    Route::post('users/invite', [UserInvitationController::class, 'sendInvite']);
    Route::post('users/register/{token}', [UserInvitationController::class, 'registerInvitedUser']);
});


// Client

Route::get('audit-messages/{clientToken}', [MessageController::class, 'allMessagesByClient']);
Route::post('audit-messages/{clientToken}', [MessageController::class, 'sendMessageByClient']);


Route::group(['middleware' => ['role:admin']], function () {

    //Roles
    Route::get('roles', [RoleController::class, 'index']);
    Route::post('roles/{roleId}', [RoleController::class, 'update']);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'delete']);

    // Users
    Route::get('users/invitations/pending', [UserInvitationController::class, 'getPendingInvites']);
    Route::get('users/invitations', [UserInvitationController::class, 'getInvitedUsers']);
    Route::get('users', [UsersController::class, 'getAllUsers']);

    //Permission management
    Route::get('users-role', [UserRoleController::class, 'companyUsersRole']);
    Route::post('assign-role', [UserRoleController::class, 'assignRoleToUser']);
    Route::post('remove-role', [UserRoleController::class, 'removeRoleFromUser']);

    //    Subscription
    Route::get('subscriptions/packages', SubscriptionPackageController::class);
    Route::get('subscriptions', SubscriptionRecordController::class);
    Route::post('subscriptions', SubscriptionController::class);

    Route::get('company', [CompanyController::class, 'profile']);
    Route::post('register/company', [RegisterController::class, 'company']);
    Route::post('company', [CompanyController::class, 'update']);

    // DashBoard
    Route::get('/admin/dashboard', [DashboardController::class, 'admin']);

    // Log
    Route::match(['post', 'get'], '/activity-logs', [ActivityLogController::class, 'logs']);

    //Engagement Roles
    Route::get('engagement-roles', [EngagementTeamRolesController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'api']], function () {
    //Permission management
    Route::post('user', [UserRoleController::class, 'userRole']);
    //User
    Route::get('user', [UserController::class, 'profile']);
    //User
    Route::post('user', [UserController::class, 'update']);

    // Client
    Route::get('clients/{client_id}/messages', [MessageController::class, 'allMessagesByCompany']);
    Route::post('clients/{client_id}/messages', [MessageController::class, 'sendMessageByCompany']);
    Route::get('clients/{client_id}/message-link', [MessageController::class, 'clientMessagingLink']);
    Route::resource('clients', ClientController::class);

    // Messages
    Route::get('/messages/{message_id}', [MessageController::class, 'getMessage']);


    // Engagement Note
    Route::resource('engagements/{engagementId}/notes', EngagementNoteController::class);

    // Planning
    Route::resource('engagements/{engagementId}/plannings', PlanningController::class);
    Route::post('plannings/{planningId}/materialities', [MaterialityController::class, 'store']);

    // Execution
    Route::post('procedures', [ExecutionController::class, 'majorProcedure']);
    Route::post('engagements/{engagementId}/executions', [ExecutionController::class, 'minorProcedure']);

    // Conclusions
    Route::resource('engagements/{engagementId}/conclusions', ConclusionController::class);

    // Approve Engagement Stages
    Route::get('engagements/{engagementId}/approve', [EngagementApprovalController::class, 'approve']);

    // Engagement Invite
    Route::post('engagements/{engagementId}/send-invite', [EngagementInviteController::class, 'send']);

    // Engagement
    Route::resource('engagements', EngagementController::class);


    // Planning
    Route::resource('plannings', PlanningController::class);

    Route::get('/index', IndexController::class);

    // Upload Document
    Route::post('upload', FileUploadController::class);


    Route::get('engagements/accept-invite/{token}', [EngagementInviteController::class, 'accept']);
    Route::get('engagements/decline-invite/{token}', [EngagementInviteController::class, 'decline']);

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/read', [NotificationController::class, 'read']);
        Route::get('/read-all', [NotificationController::class, 'readAll']);
    });

    Route::post('/trial-balance', [TrialBalanceController::class, 'upload']);

    Route::get('/assertions', [AssertionController::class, 'index']);

});

Route::group(['middleware' => ['auth', 'role:staff|managing_partner']], function () {
    // DashBoard
    Route::get('/staff/dashboard', [DashboardController::class, 'staff']);
});
