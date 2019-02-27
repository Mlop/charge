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
    public function getTotalInMonth($user_id, $type = 'outgo')
    {
        $today = Carbon::today();
        $firstDay = $today->firstOfMonth();
        $today = Carbon::today();
        $endDay =$today->endOfMonth();
		$rep = new AccountRepository();
        return $rep->builder(["user_id"=>$user_id, "type"=>$type])
            ->where("record_at", ">=", $firstDay)
            ->where("record_at", "<=", $endDay)
            ->sum("cash");
    }

	public function getDetailAll($user_id)
	{
		$sql = "SELECT acc.*, DATE_FORMAT(record_at, '%Y-%m') ym
							FROM account acc
							WHERE acc.`user_id` = {$user_id}";
		return $sql;
	}
	public function getDetaiGroup($user_id)
	{
		$sql = "SELECT t1.*,cat.title,ym,DATE_FORMAT(record_at,'%d') days FROM
                 (
                    ".$this->getDetailAll($user_id)."
                )t1
				JOIN category cat ON t1.category_id=cat.id";
		return $sql;
	}
    public function lastestRecord($user_id, $top = 4)
    {
		$sql = "SELECT t1.*,cat.title,ym,DATE_FORMAT(record_at,'%d') days FROM
                 (
                    ".$this->getDetailAll($user_id)."
                )t1
				JOIN category cat ON t1.category_id=cat.id
				ORDER BY record_at DESC
				LIMIT {$top}";
        return DB::select($sql);
    }

    public function getSummaryByMonth($user_id, $type)
    {
		$sql = "SELECT ym,sum(cash) AS total
				FROM
					(
						".$this->getDetailAll($user_id)."
					) t1
				GROUP BY ym
				ORDER BY ym DESC";
		$result = DB::select($sql);
		$data = [];
		foreach ($result as $row) {
			$sql = "SELECT ym,sum(cash) as total,type
					FROM
						(
							".$this->getDetailAll($user_id)."
						) t1
					WHERE ym='".$row->ym."'
					GROUP BY ym,type
					ORDER BY ym DESC";
			$row->item = DB::select($sql);
			$data[] = $row;
		}
		return $data;
    }
    public function getMonthList($user_id, $ym)
    {
		$sql = $this->getDetaiGroup($user_id)." WHERE ym='{$ym}' ORDER BY record_at DESC";
		return DB::select($sql);
    }
}