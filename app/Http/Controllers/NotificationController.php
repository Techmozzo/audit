<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Interfaces\NotificationStatus;
use App\Util\DateUtil;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource
     * @return Response
     */
    public function index(Request $request)
    {
        if (is_null($request->filter)) {
            $filterValue = NotificationStatus::UNREAD_NOTIFICATION;
        } else {
            $filterValue = ($request->filter == NotificationStatus::ALL) ? null : $request->filter;
        }

        $datesearch = $request->has('datesearch') && $request->datesearch==1 ? true : false;
        $filter_action = $request->has('filteraction') ? $request->filteraction : '';

        if ($request->has('daterange')) {
            $daterange = $request->daterange;
        } else {
            $daterange = date('M d, Y - ', strtotime('- 1 week')) . date('M d, Y');
        }
        $notifications = getallNotifications(auth()->user()->id, $filterValue, $filter_action, $request->has('daterange') && $datesearch ? DateUtil::dateRange($daterange) : []);
        $model_filters = getNotificationTypeFilters(auth()->user()->id);

        return response()->success(Response::HTTP_OK, 'Request successful',[ 'filterValue' => $filterValue, 'notifications' => $notifications, 'daterange' => $daterange, 'model_filters' => $model_filters , 'filter_action' => $filter_action]);
    }

    public function read(Request $request)
    {
        $notification = $request->user()->notifications()->where('id', $request->id)->whereNull('read_at')->first();
        if ($notification) {
            $notification->markAsRead();

            $log_action['name'] = "Read notification";
            $log_action['description'] = "Read notification: " . ucwords($notification->data['title']);
            $log_action['properties'] = $notification->id;
            $log_action['causer_id'] = auth()->user()->id;
            logAction($log_action);
        }
        return response()->success(Response::HTTP_OK, 'Request successful');
    }

    /**
     * readAll make all notifications as read
     * @return array json response
     */
    public function readAll()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        
        $log_action['name'] = "Marked all notifications as read";
        $log_action['description'] = "Marked all notifications as read";
        $log_action['causer_id'] = auth()->user()->id;

        logAction($log_action);
        return response()->success(Response::HTTP_OK, 'Notifications marked as read');
    }
}
