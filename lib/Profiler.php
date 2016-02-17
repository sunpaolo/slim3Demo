<?php
namespace Lib;

class Profiler
{
    /*
     * 内存使用量转换成相应格式
     */
    private static function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}