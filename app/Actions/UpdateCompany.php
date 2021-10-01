<?php

namespace App\Actions;

class UpdateCompany{
    public function __invoke($request, $company, $storeImageToCloud)
    {
        $url = [];
        if(isset($request->dp)) $url['dp'] = $storeImageToCloud($request->dp);
        $company->update($request->except(['dp']) + $url);
    }
}
