<?php

namespace App\Actions;

use App\Models\Conclusion;

class CreateConclusion{
    public function __invoke($request, $engagmentId)
    {
        return Conclusion::updateOrCreate(['engagement_id' => $engagmentId, 'company_id' => auth()->user()->company_id], $request->all());
    }
}
