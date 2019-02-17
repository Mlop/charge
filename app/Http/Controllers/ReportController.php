<?php
/**
 * 报表
 * User: Vera
 * Date: 2019/2/17
 * Time: 22:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Repositories\BookRepository;
// use Auth;

class ReportController extends Controller
{
    // protected $bookRep;
    protected $userId;

    public function __construct()
    {
        // $this->bookRep = $bookRep;
        $user = Auth::user();
        $this->userId = $user->id;
    }

    public function index(Request $request)
    {
		//本月总支出
		//本月总收入
		//最近4条收支记录
		
    }
}