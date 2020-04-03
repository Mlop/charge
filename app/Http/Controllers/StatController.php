<?php
/**
 * 统计，某账本按类型统计总收入；某人在时间范围内各账本支出情况.
 * User: Vera
 * Date: 2020/2/26
 * Time: 16:25
 */

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Repositories\BookRepository;
use App\Repositories\ContactRepository;
use Auth;
use Illuminate\Http\Request;

class StatController extends Controller
{
    protected $bookRep;
    protected $contactRep;
    protected $accountRep;
    protected $userId;
    public function __construct(BookRepository $bookRep, ContactRepository $contactRep, AccountRepository $accountRep)
    {
        $user = Auth::user();
        $this->userId = $user ? $user->id : 0;
        $this->bookRep = $bookRep;
        $this->contactRep = $contactRep;
        $this->accountRep = $accountRep;
    }
    public function index()
    {
        return "index suc";
    }

    /**
     * 列表过滤条件数据，包括结果总条数(TODO 排序)
     */
    public function filters(Request $request)
    {
        $field = $request->get('field', 'all');
        switch ($field) {
            case 'years':
                $data = $this->bookRep->getFilterYears($this->userId);
                break;
            case 'books':
                $data = $this->bookRep->getFilterList($this->userId);
                break;
            case 'contacts':
                $data = $this->contactRep->getAZIndexList();
                break;
            default:
                //年份
                $data['years'] = $this->bookRep->getFilterYears($this->userId);
                //账本
                $data['books'] = $this->bookRep->getFilterList($this->userId);
                //a-z姓名
                $data['contacts'] = $this->contactRep->getAZIndexList();
                break;
        }

        //账本条目
        return $data;
    }

    /**
     * 列表部分数据，包括分页(TODO 排序)
     * 统计的最终结果：共有账本数量，金额总数、账本各项总数。
     * year
     * book
     * contact
     * page
     * page_size
     * contact times, totalCash,=>*[cash(item)],*book,*created_at,
     */
    public function lists(Request $request)
    {
        $params = $request->all();
        $summary = $this->accountRep->statByContact($params);
        return $summary;
    }

    public function listDetail(Request $request)
    {
        $params = $request->all();
        return $this->accountRep->searchDetail($params);
    }
}
