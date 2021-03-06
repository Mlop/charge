<?php
/**
 * 全局可调用函数，比如格式化日期，金额
 * User: Vera.Zhang
 * Date: 2020/4/7
 * Time: 16:51
 */
namespace App;

class MyFunction
{
    /**
     * >万，返回2.3万
     * >千万，返回3千万
     * >亿，返回54亿
     * @param $cash 格式化的金额
     * @return float
     */

    public function formatCash($cash)
    {
        if ($cash < 10000) {
            return $cash;
        }
        $cashWan = floor($cash / 1000) / 10;
        $cashQWan = floor($cashWan / 100) / 10;
        $cashYi = $cashQWan / 10;
        if ($cashYi > 1) {
            $formatCash = $cashYi . "亿";
        } else if ($cashQWan > 1) {
            $formatCash = $cashQWan . "千万";
        }else {
            $formatCash = $cashWan . "万";
        }
        return $formatCash;
    }

    /**
     * 根据日期字符串格式化为日期格式，比如：2020-04-02 11:12:23格式化为：2020-04-02
     * @param $timeStr 要格式的字符串
     * @return string 日期字符串
     */
    public function getDateStr($timeStr)
    {
        $datetime = new \DateTime($timeStr);
        return $datetime->format('Y-m-d');
    }

    /**
     * 当前时间字符串
     * @return false|string
     */
    public function now()
    {
        return date('Y-m-d H:i:s');
    }
}
