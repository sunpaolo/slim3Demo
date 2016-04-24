<?php
namespace Lib\Util;

class DateUtil
{
    // Second amounts for various time increments
    const YEAR   = 31556926;
    const MONTH  = 2629744;
    const WEEK   = 604800;
    const DAY    = 86400;
    const HOUR   = 3600;
    const MINUTE = 60;

    /*
     * 检测是不是当天的时间戳
     */
    public static function isToday($time)
    {
        return date('Y-m-d') == date('Y-m-d', $time);
    }

    /*
     * 返回两个时间相差的天数
     */
    public static function diffDays($aTime, $bTime)
    {
        $dayTimeA = strtotime(date('Y-m-d', $aTime));
        $dayTimeB = strtotime(date('Y-m-d', $bTime));
        $offsetTime = abs($dayTimeA - $dayTimeB);
        return intval($offsetTime / 86400);
    }
}