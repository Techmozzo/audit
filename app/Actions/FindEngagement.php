<?php

namespace App\Actions;

use App\Models\Engagement;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FindEngagement{
    public function __invoke($engagementId){
        $engagement = Engagement::with('client', 'planning', 'execution', 'conclusion')->where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if($engagement == null){
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist'));
        }else{
            return $engagement;
        }
    }
}
