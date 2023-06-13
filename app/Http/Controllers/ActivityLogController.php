<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogController extends Controller
{
    public function logs(Request $request)
    {
        $company_id = session('company')->id ?? auth()->user()->company_id;

        $logs = ActivityLog::with('causer','causee')->where('company_id', $company_id);

        if (isset($request->action) && $request->action != 'All') {
            $log_action = str_replace("__", " ", $request->action);
            $logs = $logs->where('name', $log_action);
        }

        if (isset($request->daterange)) {
            $daterange = dateRange($request->daterange);
            $logs = $logs->whereBetween('created_at', [$daterange['start_date'], $daterange['end_date']]);
        }

        if (isset($request->causer) && $request->causer != 'All') {
            $name = explode('__', $request->causer);
            $first_name = (isset($name[0]) && !is_null($name[0])) ? $name[0] : NULL;
            $last_name = (isset($name[1]) && !is_null($name[1])) ? $name[1] : NULL;
            $logs = $logs->whereHas('causer', function ($query) use ($first_name, $last_name) {
                $query->where('first_name', $first_name)
                    ->where('last_name', $last_name);
            });
        }
        if (isset($request->subject) && $request->subject != 'All') {
            $name = explode('__', $request->subject);
            $first_name = (isset($name[0]) && !is_null($name[0])) ? $name[0] : NULL;
            $last_name = (isset($name[1]) && !is_null($name[1])) ? $name[1] : NULL;
            $logs = $logs->whereHas('causee', function ($query) use ($first_name, $last_name) {
                $query->where('first_name', $first_name)
                    ->where('last_name', $last_name);
            });
        }

        $logs = $logs->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->success(Response::HTTP_OK, 'Request Successful', ['logs' => $logs]);
    }
}
