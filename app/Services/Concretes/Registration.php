<?php

namespace App\Services\Concretes;

use App\Actions\CreateUser;
use App\Http\Resources\UserResource;
use App\Jobs\ManagingPartnerInvitationJob;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserInvitation;
use App\Services\Interfaces\RegistrationInterface;
use App\Traits\HashId;

class Registration implements RegistrationInterface
{
    use HashId;

    public function execute($request): array
    {
        $user = $this->register(new CreateUser(), $request);
        return [
            'access_token' => auth()->guard()->login($user),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserResource($user)
        ];
    }


    public function register($createUser, $request): object
    {
        $company = $this->createCompany($request);
        $user = $createUser($company->id, $request);
        $role = Role::where('name', 'admin')->first();
        $user->role()->attach($role->id, ['created_at' => now(), 'updated_at' => now()]);
        RegistrationJob::dispatch($user)->onQueue('audit_queue');
        RegistrationJobAdmin::dispatch($user, 'admin@techmozzo.com')->onQueue('audit_queue');
        $this->inviteManagingPartner($company, $request);
        return $user;
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
        if ($request['email'] !== $request['managing_partner_email']) {
            $invitedUser = UserInvitation::create([
                'name' => $request['managing_partner_name'],
                'email' => $request['managing_partner_email'],
                'company_id' => $company->id,
                'role_id' => Role::where('name', 'managing_partner')->first()->id
            ]);
            $token = $this->encrypt($invitedUser->id)['data_token'];
            ManagingPartnerInvitationJob::dispatch($request, 'Managing Partner', $token)->onQueue('audit_queue');
        }
    }
}
