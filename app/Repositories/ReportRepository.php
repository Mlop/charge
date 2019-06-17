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

	public function getDetailAll($user_id, $fields = "")
	{
		$fields = $fields ? ",".$fields : "";
		$sql = "SELECT acc.*, DATE_FORMAT(record_at, '%Y-%m') ym, DATE_FORMAT(record_at, '%Y') y, DATE_FORMAT(record_at, '%m') m{$fields}
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
				ORDER BY record_at DESC,t1.id DESC
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
	public function getYearSummary($user_id, $top = 2)
	{
		$sql = "SELECT y 
				FROM (".$this->getDetailAll($user_id).") t1
				GROUP BY y
				ORDER BY y DESC
				LIMIT {$top}";
		$result = DB::select($sql);	
		$sortField = "case type when 'outgo' then 1 when 'income' then 2 when 'loan' then 3 end as sort";
		$data = [];
		foreach ($result as $row) {
			$sql = "SELECT y,type,sum(cash) total,sort
					FROM (".$this->getDetailAll($user_id, $sortField).") t1
					WHERE y='{$row->y}'
					GROUP BY type,y,sort
					UNION 
					SELECT y,'balance' as type,sum(a) total,4 as sort 
					FROM(
						SELECT sort, y,type,sum(cash) t,if(type='outgo',-1*sum(cash), sum(cash)) a 
						FROM (".$this->getDetailAll($user_id, $sortField).") t1
						WHERE y='{$row->y}'
						AND type in('".CategoryRepository::TYPE_OUT."', '".CategoryRepository::TYPE_IN."')
						GROUP BY type,y,sort
					) t2
					GROUP BY y
					ORDER BY sort ASC";
			$data[] = ['year'=>$row->y, 'items'=>DB::select($sql)];
		}
		return $data;
	}
}