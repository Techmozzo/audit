<?php


namespace App\Actions;


use App\Jobs\ManagingPartnerInvitationJob;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;
use App\Models\Company;
use App\Models\Role;
use App\Models\UserInvitation;
use App\Traits\HashId;

class Registration
{
    use HashId;

    public function __invoke($request, $createUser): object
    {
        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
            'phone' => $request->company_phone,
            'techmozzo_id' => 'TM' . rand(100, 999) . rand(1000, 9999) . 'AC'
        ]);

        $role = Role::where('name', 'admin')->first();
        $user = $createUser($company->id, $request->all());
        $user->role()->attach($role->id, ['created_at' => now(), 'updated_at' => now()]);

        RegistrationJob::dispatch($user)->onQueue('audit_queue');
        RegistrationJobAdmin::dispatch($user, 'admin@techmozzo.com')->onQueue('audit_queue');
        if($request->email !== $request->managing_partner_email){
            $invitedUser = UserInvitation::create([
                'name' => $request->managing_partner_name,
                'email' => $request->managing_partner_email,
                'company_id' => $company->id,
                'role_id' => Role::where('name', 'managing_partner')->first()->id
            ]);
            $token = $this->encrypt($invitedUser->id)['data_token'];
            ManagingPartnerInvitationJob::dispatch($request->all(), 'Managing Partner', $token)->onQueue('audit_queue');
        }
        return $user;
    }
}
