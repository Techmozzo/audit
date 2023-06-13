<?php

use Illuminate\Support\Collection;
use App\Models\User;
use App\Interfaces\NotificationStatus;
use App\Models\Notification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use App\Models\ActivityLog;

/**
 * Retrieve the notifications and notification counts for a given User
 *
 * @param int $User_id The ID of an User
 *
 * @return array
 */
if (!function_exists('getNotifications')) {
    function getNotifications(int $User_id)
    {
        $notifications = [];
        $unreadCount = 0;

        $e = User::find($User_id);

        $take = config('constants.notifications.NOTIFICATION_COUNT');

        $notifications = $e->unreadNotifications()->take($take)->get();
        $unreadCountButton = $e->unreadNotifications()->where('notification_clicked', 0)->count();
        $unreadCount = $e->unreadNotifications()->count();

        return ['unreadCount' => $unreadCount, 'unreadCountButton' => $unreadCountButton, 'notifications' => $notifications];
    }
}
/**
 * Retrieve the notifications for a given User
 *
 * @param int $User_id The ID of an User
 * @param String $filterValue The read/unread filter
 * @param String $filterAction A module action filter
 * @param array $filterDate The daterange filter
 *
 * @return array
 */

if (!function_exists('getAllNotifications')) {

    function getAllNotifications(int $User_id, $filterValue = null, $filterAction = null, array $filterDate = []): object
    {
        $notifications = collect([]);

        $UserObject = User::find($User_id);

        $filterValue = $filterValue ?? '';
        $filterAction = $filterAction ?? '';

        $notifications = getNoticationsBasedOnFilter($UserObject, $filterValue, $filterAction, $filterDate);
        return $notifications;
    }
}


/**
 * Retrieve the notifications for a given User based on some filters
 *
 * @param User $UserObject The object of an User
 * @param String $filterValue The read/unread filter
 * @param String $filterAction A module action filter
 * @param array $filterDate The daterange filter
 *
 * @return DatabaseNotificationCollection
 */

if (!function_exists('getNoticationsBasedOnFilter')) {

    function getNoticationsBasedOnFilter(User $UserObject, string $filterValue, string $filterAction, array $filterDate = []): Collection
    {
        $types = getNotificationTypeFilters($UserObject->id);
        $notification_type = isset($types["$filterAction"]) ? array_values($types["$filterAction"]) : [];
        //   $notification_type = $types["$filterAction"] ?? [];

        switch ($filterValue) {
            case NotificationStatus::READ_NOTIFICATION:
                $notificationsCollection = $UserObject->readNotifications;
                break;
            case NotificationStatus::UNREAD_NOTIFICATION:
                $notificationsCollection = $UserObject->unreadNotifications;
                break;
            default:
                $notificationsCollection = $UserObject->notifications;
        }

        if (count($filterDate)) {
            $notificationsCollection = $notificationsCollection
                ->where('created_at', '>=', $filterDate['start_date'])
                ->where('created_at', '<=', $filterDate['end_date']);
        }
        if (count($notification_type)) {
            $notificationsCollection = $notificationsCollection
                ->whereIn('type', $notification_type);
        }

        return $notificationsCollection;
    }
}

/**
 * Get a multidimensional array of the packages notifications
 *
 * @param int $User_id The ID of an User
 *
 * @return array
 */

if (!function_exists('getNotificationTypeFilters')) {

    function getNotificationTypeFilters(int $user_id)
    {
        $user = User::find($user_id);
        $notifications = Notification::where('notifiable_id', $user->id)->select('type')->groupBy('type')->get();
        $type_filter = [];
        foreach ($notifications as $notif) {
            $e = explode('\\', $notif->type);
            $type_strings = preg_split('/(?=[A-Z])/', end($e));
            unset($type_strings[count($type_strings) - 1]);
            $notification_type = implode(' ', $type_strings);
            if (!isset($type_filter["$notification_type"])) {
                $type_filter[trim($notification_type)] =  $notif->type;
            }
        }
        return $type_filter;
    }
}


if (!function_exists('logAction')) {

    function logAction($logAction)
    {
        if (isset(session('company')->id)) {
            $company_id = session('company')->id;
        } else {
            if (isset(auth()->user()->company_id)) {
                $company_id = auth()->user()->company_id;
            } else {
                $company_id = getCompanyId($logAction['causer_id']);
            }
        }

        $log_action = [
            'name'          => @$logAction['name'],
            'description'   => @$logAction['description'],
            'action_type'   => @$logAction['action_type'],
            'causee_id'     => @$logAction['causee_id'],
            'causee_type'   => @$logAction['causee_type'],
            'causer_id'     => isset($logAction['causer_id']) ? $logAction['causer_id'] : auth()->user()->id,
            'causer_role'   => getCauserRole(),
            'causer_type'   => @$logAction['causer_type'],
            'company_id'    => $company_id,
            'ip'            =>  getClientIp(),
        ];

        if (!empty($log_action)) {
            ActivityLog::create($log_action);
        }
    }
}


if (!function_exists('getClientIp')) {

    function getClientIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}


if (!function_exists('getCauserRole')) {

    function getCauserRole()
    {
        $role = 'Not Logged In';
        if(auth()->check()){
            $roles =  auth()->user()->roles->pluck('name')->toArray();
            $role = implode(', ', $roles);
        }
        return $role;
    }
}


if (!function_exists('getCompanyId')) {

    function getCompanyId($employee_id = null)
    {
        if (is_null($employee_id)) {
            $company_id = is_null(session('company')) ? optional(auth()->user())->company_id : session('company')->id;
        } else {
            $company_id = User::where('id', $employee_id)->first()->company_id;
        }
        return $company_id;
    }
}

if (!function_exists('dateRange')) {

    function dateRange($date)
    {
        $arr = explode("-", $date);
        $start_date = date("Y-m-d", strtotime($arr[0])) . " 00:00:00";
        $end_date = date("Y-m-d", strtotime($arr[1])) . " 23:59:59";
        return ['start_date' => $start_date, 'end_date' => $end_date];
    }
}
