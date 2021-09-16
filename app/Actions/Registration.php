<?php


namespace App\Actions;


use App\Http\Resources\UserResource;
use App\Jobs\InvitationJob;
use App\Jobs\RegistrationJob;
use App\Jobs\RegistrationJobAdmin;
use App\Models\Company;
use App\Models\Role;

class Registration
{
    public function __invoke($request, $createUser):array{

        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
            'phone' => $request->company_phone,
            'techmozzo_id' => 'TM' . rand(100, 999) . rand(1000, 9999) . 'AC'
        ]);

        $role = Role::where('name', 'admin')->first();

        $user = $createUser($company->id, $request, $role->id);

        RegistrationJob::dispatch($user)->onQueue('audit_queue');
        RegistrationJobAdmin::dispatch($user, 'admin@techmozzo.com')->onQueue('audit_queue');
        InvitationJob::dispatchIf($request->email !== $request->managing_partner_email, $request->all(), 'Managing Partner')->onQueue('audit_queue');

        return $user;
    }
}
