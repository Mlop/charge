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

	public function getDetailAll($user_id)
	{
		$sql = "SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'out' as type FROM outgo WHERE `user_id` = {$user_id}
				UNION
				SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'in' as type FROM income WHERE `user_id` = {$user_id}
				UNION
				SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'loan' as type FROM loan WHERE `user_id` = {$user_id}";
		return $sql;
	}
	public function getDetaiGroup($user_id)
	{
		$sql = "SELECT t1.*,cat.title,ym FROM
                 (
                    ".$this->getDetailAll($user_id)."
                )t1
				JOIN category cat ON t1.category_id=cat.id";
		return $sql;
	}
    public function lastestRecord($user_id, $top = 4)
    {
		$sql = $this->getDetaiGroup($user_id).
				" ORDER BY record_at DESC
                LIMIT {$top}";
//         $sql = "SELECT t1.*,cat.title,ym FROM
//                  (
//                     SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'out' as type FROM outgo WHERE `user_id` = {$user_id}
//                     UNION
//                     SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'in' as type FROM income WHERE `user_id` = {$user_id}
//                     UNION
//                     SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym,'loan' as type FROM loan WHERE `user_id` = {$user_id}
//                 )t1
// 				JOIN category cat ON t1.category_id=cat.id
//                 ORDER BY record_at DESC
//                 LIMIT {$top}";

        return DB::select($sql);
    }

    public function getSummaryByMonth($user_id)
    {
        /*switch ($type) {
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
        $sql = "SELECT ym,sum(cash) as total FROM (
                  SELECT *,DATE_FORMAT(record_at,'%Y-%m') ym FROM {$table} WHERE `user_id` = {$user_id}
                )t1
                GROUP BY ym
                ORDER BY ym DESC";*/
		$sql = "SELECT ym,sum(cash) as total FROM (
					".$this->getDetailAll($user_id)."
                )t1
                GROUP BY ym
                ORDER BY ym DESC";
        $result = DB::select($sql);
		$data = [];
		foreach ($result as $row) {
			// dd($row->ym);
			$sql = "SELECT ym,sum(cash) as total,type FROM (
						".$this->getDetailAll($user_id)."
			        )t1
					WHERE ym='".$row->ym."'
			        GROUP BY ym,type
			        ORDER BY ym DESC";//echo ($sql);exit;
			$row->item = DB::select($sql);
			$data[] = $row;
		}
		
		
		// $result = DB::select($sql);
		return $data;
    }
    public function getMonthList($user_id, $ym)
    {
		$sql = $this->getDetaiGroup($user_id)." WHERE ym='{$ym}' ORDER BY record_at DESC";
		return DB::select($sql);
//         return $rep->builder(["user_id"=>$user_id])
//                     ->whereRaw("DATE_FORMAT(record_at,'%Y-%m')='{$ym}'")
//                     ->orderBy("record_at", "DESC")
//                     ->get();
    }
}