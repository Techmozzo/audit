<?php

namespace App\Http\Controllers;

use App\Models\EngagementTeamRole;
use Symfony\Component\HttpFoundation\Response;

class EngagementTeamRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = EngagementTeamRole::select('id', 'name')->get();
        return response()->success(Response::HTTP_OK, 'Request successful', ['roles' => $roles]);
    }

}
