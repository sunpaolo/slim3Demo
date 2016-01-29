<?php
namespace Lib\Util;

class DateUtil
{
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