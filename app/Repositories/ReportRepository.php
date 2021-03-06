<?php
/**
 * 报表统计
 * User: Vera
 * Date: 2019/2/21
 * Time: 15:22
 */

namespace App\Repositories;

use App\Models\Account;
use Carbon\Carbon;
use DB;
use App\Facades\MyFun;

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
        $pureCash = "if(acc.type='income', acc.cash, -1*acc.cash) pure_cash";
		$sql = "SELECT ym,sum(pure_cash) AS total
				FROM
					(
						".$this->getDetailAll($user_id, $pureCash)."
					) t1
				GROUP BY ym
				ORDER BY ym DESC";
		$result = DB::select($sql);
		$data = [];
		foreach ($result as $row) {
			$sql = "SELECT ym,sum(pure_cash) as total,type
					FROM
						(
							".$this->getDetailAll($user_id, $pureCash)."
						) t1
					WHERE ym='".$row->ym."'
					GROUP BY ym,type
					ORDER BY ym DESC";
            $item = DB::select($sql);
			foreach ($item as &$it) {
                $it->total = MyFun::formatCash($it->total);
            }
			$row->item = $item;
			$row->total = MyFun::formatCash($row->total);
			$data[] = $row;
		}
		return $data;
    }
    public function getMonthList($user_id, $ym)
    {
		$sql = $this->getDetaiGroup($user_id)." WHERE ym='{$ym}' ORDER BY record_at DESC";
		$result = DB::select($sql);
		foreach ($result as &$row) {
		    $row->cash = MyFun::formatCash($row->cash);
		    $row->items = json_decode($row->items);
        }
        return $result;
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

    /**
     * 按账本统计总额
     */
    public function getBookSummary($user_id, $top = 2)
    {
        $sql = "SELECT b.id,b.title,sum(if(a.type='".Account::TYPE_INCOME."', cash, -1*cash)) total FROM account a JOIN book b ON a.book_id=b.id
                WHERE b.user_id={$user_id}
                GROUP BY b.id,b.title
                ORDER BY total DESC
				LIMIT {$top}";
        $result = DB::select($sql);
        $data = [];
        foreach ($result as $row) {
            $row->total = MyFun::formatCash($row->total);
            $data[] = $row;
        }
        return $data;
	}

    /**
     * 某账本所有账目
     * @param $book_id
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getBookDetail($book_id, $page, $pageSize)
    {
        $result = Account::where("book_id", $book_id)
            ->select("account.*",DB::Raw("(select cat.title from category as cat where cat.id=account.category_id) as cattitle"))
            ->orderBy("record_at", "desc")
            ->paginate($pageSize);
        foreach ($result as &$item) {
            $item['items'] = json_decode($item['items']);
            $item['created_date'] = MyFun::getDateStr($item['record_at']);
        }
        return $result;
    }
}
