<?php

namespace App\Actions;

class UpdateUser{
    public function __invoke($request, $user, $storeImageToCloud)
    {
        $url = [];
        if(isset($request->dp)) $url['dp'] = $storeImageToCloud($request->dp);
        $user->update($request->except(['dp','is_verified','email', 'company_id']) + $url);
    }
}
