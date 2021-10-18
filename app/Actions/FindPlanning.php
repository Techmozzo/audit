<?php

namespace App\Actions;

use App\Models\Planning;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FindPlanning{
    public function __invoke($planningId){
        $planning = Planning::where([['id', $planningId], ['company_id', auth()->user()->company_id]])->first();
        if($planning == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Planning does not exist'));
        }else{
            return $planning;
        }
    }
}
