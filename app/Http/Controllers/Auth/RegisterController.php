<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;
use App\Jobs\TestJob;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegistrationRequest $request){

        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
            'phone' => $request->company_phone,
            'techmozzo_id' => 'TM' . rand(100, 999) . rand(1000, 9999) . 'AC'
        ]);

        $role = Role::where('name', 'admin')->first();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'company_id' => $company->id,
            'role_id' => $role->id,
            'designation' => $request->designation
        ]);

        RegistrationJob::dispatch($user)->onQueue('audit_queue');
        RegistrationJobAdmin::dispatch($user, 'admin@techmozzo.com')->onQueue('audit_queue');

        $data = [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
        return response()->success(Response::HTTP_CREATED, 'Registration Successful', $data);
    }
}
