<?php
/**
 * 报表
 * User: Vera
 * Date: 2019/2/17
 * Time: 22:14
 */

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
use App\Repositories\AccountRepository;
use Auth;

class ReportController extends Controller
{
    protected $reportRep;
    protected $accountRep;
    protected $inRep;
    protected $loanRep;
    protected $userId;

    public function __construct(ReportRepository $reportRep, AccountRepository $accountRep)
    {
        $user = $this->getUser();
        $this->userId = $user ? $user->id : 0;
        $this->reportRep = $reportRep;
        $this->accountRep = $accountRep;
    }

    public function index(Request $request)
    {
		//本月总支出
        $totalOut =  $this->reportRep->getTotalInMonth($this->userId, 'outgo');
		//本月总收入
        $totalIn =  $this->reportRep->getTotalInMonth($this->userId, 'income');
		//最近4条收支记录
        $items = $this->formatRecordItem($this->reportRep->lastestRecord($this->userId));
		return compact('totalOut', 'totalIn', 'items');
    }

    /**
     * 格式化单条收支记录
     */
    private function formatRecordItem($items)
    {
        foreach ($items as &$item) {
            //备注显示顺序为：添加的备注》姓名》类型
            $remark = $item->remark;
            if (!$remark) {
                $remark = $item->contact ? : Account::$typeConfig[$item->type];
            }
            $item->remark = $remark;
        }
        return $items;
    }

    public function getSummaryList(Request $request)
    {
        $type = $request->input("type", "outgo");
        return $this->reportRep->getSummaryByMonth($this->userId, $type);
    }

    public function getMonthList(Request $request)
    {
        $ym = $request->input("date", date('Y-m'));
        return $this->reportRep->getMonthList($this->userId, $ym);
    }

    /**
     * 按年份统计
     * @param Request $request
     * @return array
     */
	public function getYearSummary(Request $request)
	{
		$top = $request->input("top", 2);
		return $this->reportRep->getYearSummary($this->userId, $top);
	}

    /**
     * 按账本统计
     * @param Request $request
     * @return array
     */
    public function getBookSummary(Request $request)
    {
        $top = $request->input("top", 10);
        return $this->reportRep->getBookSummary($this->userId, $top);
    }

    /**
     * 某账本下所有想象账目
     * @param $book_id
     * @return mixed
     */
    public function getBookDetail($book_id)
    {
        return $this->reportRep->getBookDetail($book_id);
    }
}
