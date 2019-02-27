<?php
/**
 * 报表
 * User: Vera
 * Date: 2019/2/17
 * Time: 22:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
//  use App\Repositories\OutgoRepository;
//  use App\Repositories\IncomeRepository;
//  use App\Repositories\LoanRepository;
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
        $user = Auth::user();
        $this->userId = $user->id;
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
        $items = $this->reportRep->lastestRecord($this->userId);
		return compact('totalOut', 'totalIn', 'items');
    }

    public function getSummaryList(Request $request)
    {
        $type = $request->input("type", "outgo");
        return $this->reportRep->getSummaryByMonth($this->userId, $type);
    }

    public function getMonthList(Request $request)
    {
        $type = $request->input("type", "outgo");
        $ym = $request->input("date", date('Y-m'));
//         switch ($type) {
//             case 'out':
//                 $rep = $this->outRep;
//                 break;
//             case "in":
//                 $rep = $this->inRep;
//                 break;
//             case "loan":
//                 $rep = $this->loanRep;
//                 break;
//             default:
//                 $rep = $this->outRep;
//                 break;
//         }
        return $this->reportRep->getMonthList($this->userId, $ym);
    }
}