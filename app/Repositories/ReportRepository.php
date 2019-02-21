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

    public function getList($rep, $user_id)
    {
        return $rep->builder(["user_id"=>$user_id])->orderBy("record_at", "DESC")->get();
    }
}