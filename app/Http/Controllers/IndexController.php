<?php

namespace App\Http\Controllers;

use App\Models\EngagementNoteFlag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function __invoke()
    {
        $engagementNoteFlags = EngagementNoteFlag::get(['id', 'name']);
        return response()->success(Response::HTTP_OK, 'Request Successful', ['engagementNoteFlags' => $engagementNoteFlags]);
    }
}
