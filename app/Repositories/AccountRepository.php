<?php
/**
 * 帐目数据与业务中间层
 * User: Vera
 * Date: 2019/2/27
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Account;
use App\Models\AccountItem;
use App\Models\Item;
use Carbon\Carbon;
use DB;

class AccountRepository
{
    public function exists($data)
    {
        return Account::where($data)->exists();
    }

    public function get($id)
    {
        return Account::find($id);
    }
    public function create($data)
    {
        $data['record_at'] = $data['record_at'] ?? Carbon::now();
        return Account::create($data);
    }

    public function delete($id)
    {
        return $this->get($id)->delete();
    }

    public function edit($id, $params)
    {
        $item = $this->get($id);
        if (!$item) {
            return false;
        }
		return $item->update($params);
    }

    public function builder($cond)
    {
        return Account::where($cond);
    }

    public function createItems($data)
    {
        return AccountItem::create($data);
    }

    /**
     * 根据姓名统计数量
     */
    public function statByContact($params)
    {
        $cond = [];
        if (isset($params['book']) && $params['book']) {
            $cond['book_id'] = $params['book'];
        }
        if (isset($params['year']) && $params['year']) {
            $cond['year'] = $params['year'];
        }
        $query = Account::select("contact",DB::Raw("count(1) as totalTimes"))
            ->groupBy("contact");
        if (isset($cond['year']) && $cond['year']) {
            $query = $query->whereRaw("DATE_FORMAT(account.created_at, '%Y')=".$cond['year']);
            unset($cond['year']);
        }
        $data = $query->where($cond)->get();
        $result = [];
        foreach ($data as $item) {
            $cond['a.contact'] = $item['contact'];
            $item['items'] = $this->statItems($cond);
            $result[] = $item;
        }
        return $result;
    }

    /**
     * 按项目标题统计值之和
     * @param array $params
     * @return mixed
     */
    public function statItems($params = [])
    {
        $query = Item::join("account_item as ai", "item.id", "=", "ai.item_id")
            ->join("account as a", "a.id", "=", "ai.account_id")
            ->select("title",DB::Raw("sum(item_value) as totalValue"),"a.type")
            ->groupBy("a.type","item.title");
        if (isset($params['year']) && $params['year']) {
            $query = $query->whereRaw("DATE_FORMAT(a.created_at, '%Y')=".$params['year']);
            unset($params['year']);
        }
        $query = $query->where($params);
        return $query->get();
    }

    /**
     * 获取条目详情
     * @param array $params
     * @return mixed
     */
    public function getItemsDetail($params = [])
    {
        $query = Item::join("account_item as ai", "item.id", "=", "ai.item_id")
            ->join("account as a", "a.id", "=", "ai.account_id")
            ->select("title", "item_value", "value_type");
        $query = $query->where($params);
        return $query->get();
    }
    /**
     * 根据条件搜索结果详细，返回分页数据
     * @param $params
     * @return mixed
     */
    public function searchDetail($params)
    {
        extract($params);
        $builder = Account::join("book as b", "account.book_id", "=", "b.id")
//            ->join("account_item ai", "account.id", "=", "ai.account_id")
            ->select("account.id", "account.type", "account.contact", DB::Raw("DATE_FORMAT(account.created_at, '%Y-%m-%d') as created_date"), "b.title as bookTitle");
        if (isset($year) && $year) {
            $builder = $builder
                ->whereRaw("DATE_FORMAT(account.created_at,'%Y')=".$params['year']);
        }
        if (isset($book) && $book) {
            $builder = $builder
                ->where("account.book_id", $book);
        }
        if (isset($contact) && $contact) {
            $builder = $builder->where("contact", $contact);
        }
        $data = $builder->get();
        $result = [];
        foreach ($data as $item) {
            $items = $this->getItemsDetail(["ai.account_id"=>$item['id']]);
            $item['items'] = $items;
            $result[] = $item;
        }

        return $result;
    }
}
