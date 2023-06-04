<?php

namespace App\Services\Concretes;

use App\Actions\CreateAdmin;
use App\Http\Resources\UserResource;
use App\Jobs\CompanyRegistrationJob;
use App\Jobs\CompanyRegistrationJobAdmin;
use App\Jobs\ManagingPartnerInvitationJob;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserInvitation;
use App\Services\Interfaces\RegistrationInterface;
use App\Traits\HashId;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class Registration implements RegistrationInterface
{
    use HashId;

    protected $createAdmin;

    public function __construct(CreateAdmin $createAdmin)
    {
        $this->createAdmin = $createAdmin;
    }

    public function admin($request): array
    {
        $admin = $this->createAdmin->__invoke($request);
        $role = Role::where('name', 'admin')->first();
        $admin->assignRole($role->name);
        // RegistrationJob::dispatch($admin)->onQueue('audit_queue');
        // RegistrationJobAdmin::dispatch($admin, 'admin@techmozzo.com')->onQueue('audit_queue');
        RegistrationJob::dispatch($admin);
        RegistrationJobAdmin::dispatch($admin, env('ADMIN_EMAIL'));
        return [
            'access_token' => auth()->guard()->login($admin),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($admin),
            'roles' => $admin->getRoleNames(),
            'permissions' => $admin->getAllPermissions(),
        ];
    }


    public function company($request)
    {
        $user = auth()->user();
        if ($user->company_id !== null) {
            throw new HttpResponseException(response()->error(Response::HTTP_UNAUTHORIZED, 'You are not allowed to register more that one company with same email.'));
        }
        $company = $this->createCompany($request);
        // CompanyRegistrationJob::dispatch($user, $company)->onQueue('audit_queue');
        // CompanyRegistrationJobAdmin::dispatch($user, $company, 'admin@techmozzo.com')->onQueue('audit_queue');

        CompanyRegistrationJob::dispatch($user, $company);
        CompanyRegistrationJobAdmin::dispatch($user, $company, env('ADMIN_EMAIL'));
        $user->update(['company_id' => $company->id]);
        $this->inviteManagingPartner($company, $request);
        return ['company' => $company, 'user' => new UserResource($user)];
    }


    protected function createCompany($request): object
    {
        $company = new Company();
        $company->name = $request['company_name'];
        $company->email = $request['company_email'];
        $company->phone = $request['company_phone'];
        $company->techmozzo_id = 'TM' . rand(100, 999) . rand(1000, 9999) . 'AT';
        $company->save();
        return $company;
    }


    protected function inviteManagingPartner($company, $request): void
    {
        if (auth()->user()->email !== $request['managing_partner_email']) {
            $invitedUser = UserInvitation::create([
                'name' => $request['managing_partner_name'],
                'email' => $request['managing_partner_email'],
                'company_id' => $company->id,
                'role_id' => Role::where('name', 'managing_partner')->first()->id
            ]);
            $token = $this->encrypt($invitedUser->id)['data_token'];
            // ManagingPartnerInvitationJob::dispatch($request, 'Managing Partner', $token)->onQueue('audit_queue');
            ManagingPartnerInvitationJob::dispatch($request, 'Managing Partner', $token);
        }
    }
}
