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
    Route::post('login', LoginController::class );
    Route::post('logout', LogoutController::class);
    Route::post('register', RegisterController::class);
    Route::patch('forgot-password/{token}', [ForgotPasswordController::class, 'storeNewPassword']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::patch('reset-password', ResetPasswordController::class);
    Route::post('users/invite', [UserInvitationController::class, 'sendInvite']);
    Route::post('users/register/{token}', [UserInvitationController::class, 'registerInvitedUser']);
});


Route::group(['middleware' => 'admin'], function (){
    //Roles
    Route::get('roles', [RoleController::class, 'index']);

    //Permission management
    Route::get('users-role', [UserRoleController::class, 'companyUsersRole']);
    Route::post('assign-role', [UserRoleController::class, 'assignRoleToUser']);
    Route::post('remove-role', [UserRoleController::class, 'removeRoleFromUser']);
});

//Permission management
Route::get('user-role', [UserRoleController::class, 'userRole']);


Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
