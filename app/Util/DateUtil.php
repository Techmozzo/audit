<?php


namespace App\Util;

use Illuminate\Support\Facades\Date;

class DateUtil extends Date
{
    public static function dateRange($date)
    {
        $arr = explode("-", $date);
        $start_date = date("Y-m-d", strtotime($arr[0])) . " 00:00:00";
        $end_date = date("Y-m-d", strtotime($arr[1])) . " 23:59:59";

        return ['start_date' => $start_date, 'end_date' => $end_date];
    }
}
