<?php
/**
 * 报表
 * User: Vera
 * Date: 2019/2/17
 * Time: 22:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Repositories\OutgoRepository;
 use App\Repositories\ReportRepository;
 use App\Repositories\IncomeRepository;
 use App\Repositories\LoanRepository;
 use Auth;

class ReportController extends Controller
{
    protected $reportRep;
    protected $outRep;
    protected $inRep;
    protected $loanRep;
    protected $userId;

    public function __construct(ReportRepository $reportRep, OutgoRepository $outRep, IncomeRepository $inRep, LoanRepository $loanRep)
    {
        $user = Auth::user();
        $this->userId = $user->id;
        $this->reportRep = $reportRep;
        $this->outRep = $outRep;
        $this->inRep = $inRep;
        $this->loanRep = $loanRep;
    }

    public function index(Request $request)
    {
		//本月总支出
        $totalOut =  $this->reportRep->getTotalInMonth($this->outRep, $this->userId);
		//本月总收入
        $totalIn =  $this->reportRep->getTotalInMonth($this->inRep, $this->userId);
		//最近4条收支记录
        $items = $this->reportRep->lastestRecord($this->userId);
		return compact('totalOut', 'totalIn', 'items');
    }

    public function getSummaryList(Request $request)
    {
        $type = $request->input("type", "out");
        return $this->reportRep->getSummaryByMonth($type, $this->userId);
    }

    public function getMonthList(Request $request)
    {
        $type = $request->input("type", "out");
        $ym = $request->input("date", date('Y-m'));
        switch ($type) {
            case 'out':
                $rep = $this->outRep;
                break;
            case "in":
                $rep = $this->inRep;
                break;
            case "loan":
                $rep = $this->loanRep;
                break;
            default:
                $rep = $this->outRep;
                break;
        }
        $this->reportRep->getMonthList($rep, $this->userId, $ym);
    }
}