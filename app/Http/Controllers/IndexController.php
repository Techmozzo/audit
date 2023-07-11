<?php

namespace App\Http\Controllers;

use App\Models\EngagementNoteFlag;
use App\Models\MaterialityLevel;
use App\Models\MaterialityRange;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function __invoke()
    {
        $engagementNoteFlags = EngagementNoteFlag::get(['id', 'name']);
        $materialLevels = MaterialityLevel::get(['id', 'name', 'upper_limit', 'lower_limit']);
        $materialRange = MaterialityRange::get(['id', 'name', 'upper_limit', 'lower_limit']);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['engagementNoteFlags' => $engagementNoteFlags, 'materialLevels' => $materialLevels, 'materialRange' => $materialRange]);
    }
}
