<?php
/**
 * 报表统计
 * User: Vera
 * Date: 2019/2/21
 * Time: 15:22
 */

namespace App\Repositories;

use Carbon\Carbon;
use DB;

class ReportRepository
{
    public function getTotalInMonth($rep, $user_id)
    {
        $today = Carbon::today();
        $firstDay = $today->firstOfMonth();
        $today = Carbon::today();
        $endDay =$today->endOfMonth();
        return $rep->builder(["user_id"=>$user_id])
            ->where("record_at", ">=", $firstDay)
            ->where("record_at", "<=", $endDay)
            ->sum("cash");
    }

    public function lastestRecord($user_id, $top = 4)
    {
        $sql = "SELECT * FROM
                 (
                    SELECT *,'out' FROM outgo WHERE `user_id` = {$user_id}
                    UNION
                    SELECT *,'in' FROM income WHERE `user_id` = {$user_id}
                    UNION
                    SELECT *,'loan' FROM loan WHERE `user_id` = {$user_id}
                )t1
                ORDER BY record_at DESC
                LIMIT {$top}";

        return DB::select($sql);
    }

    public function getSummaryByMonth($type, $user_id)
    {
        switch ($type) {
            case 'out':
                $table = "outgo";
                break;
            case "in":
                $table = "income";
                break;
            case "loan":
                $table = "loan";
                break;
            default:
                $table = "outgo";
                break;
        }
        $sql = "SELECT ym,sum(cash) FROM (
                  SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym FROM {$table} WHERE `user_id` = {$user_id}
                )t1
                GROUP BY ym
                ORDER BY ym DESC";
        return DB::select($sql);
    }

    public function getMonthList($rep, $user_id, $ym)
    {
        return $rep->builder(["user_id"=>$user_id])
                    ->whereRaw("DATE_FORMAT(record_at,'%Y-%m')", $ym)
                    ->orderBy("record_at", "DESC")
                    ->get();
    }
}