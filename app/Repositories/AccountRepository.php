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
use App\Models\Image;
use App\Models\Item;
use Carbon\Carbon;
use DB;
use App\Facades\MyFun;

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

    public function clearItems($data)
    {
        return AccountItem::where($data)->delete();
    }

    public function updateItem($cond, $values)
    {
        $item = $this->getItemBuilder($cond);
        if (!$item->exists()) {
            return false;
        }
        return $item->update($values);
    }

    public function getItemBuilder($cond)
    {
        return AccountItem::where($cond);
    }

    public function getImageBuilder($cond, $type = Image::TYPE_ACCOUNT)
    {
        if ($type) {
            $cond['type'] = $type;
        }
        return Image::where($cond);
    }

    public function createImages($data, $type = Image::TYPE_ACCOUNT)
    {
        if ($type) {
            $data['type'] = $type;
        }
        return Image::create($data);
    }

    /**
     * 根据姓名统计数量
     */
    public function statByContact($params, $user_id)
    {
        $cond = [];
        //账本搜索
        if (isset($params['book']) && $params['book']) {
            $cond['book_id'] = $params['book'];
        }
        $query = Account::select("contact",DB::Raw("count(1) as totalTimes"), DB::Raw("sum(cash) as cash"))
            ->join("book", "book.id", "=", "account.book_id")
            ->where("book.user_id", $user_id)
            ->groupBy("contact");
        //记账年限搜索
        if (isset($params['year']) && $params['year']) {
            $query = $query->whereRaw("DATE_FORMAT(account.record_at, '%Y')=".$params['year']);
        }
        //联系人过滤
        if (isset($params['contact']) && $params['contact']) {
            if ($params['contact'] == '自己') {
                $params['contact'] = "";
            }
            $query = $query->whereIn('contact', explode(",", $params['contact']));
        }
        //排序
        if (isset($params['sort']) && $params['sort']) {
            list($field, $sortBy) = explode("#", $params['sort']);
            $query = $query->orderBy($field, $sortBy);
        }
        $data = $query->where($cond)->get();
        $result = [];
        foreach ($data as $item) {
            $item['contact'] = $item['contact'] ? : '';//个人
            $item['cash'] = MyFun::formatCash($item['cash']);
            $cond['a.contact'] = $item['contact'];
            $item['items'] = $this->statItems($cond);
            $result[] = $item;
        }
        return $result;
    }

    /**
     * 按项目标题统计值之和(统计类型是int和decimal的)
     * @param array $params
     * @return mixed
     */
    public function statItems($params = [])
    {
        $query = Item::join("account_item as ai", "item.id", "=", "ai.item_id")
            ->join("account as a", "a.id", "=", "ai.account_id")
            ->select("title",DB::Raw("sum(item_value) as totalValue"),"a.type")
            ->whereIn("item.value_type", [Item::VALUE_TYPE_INT, Item::VALUE_TYPE_DECIMAL])
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
            ->select("account.id", "account.type", "account.contact", DB::Raw("DATE_FORMAT(account.record_at, '%Y-%m-%d') as record_date"), "b.title as bookTitle")
            ->orderBy("account.record_at", "desc");
        if (isset($year) && $year) {
            $builder = $builder
                ->whereRaw("DATE_FORMAT(account.record_at,'%Y')=".$params['year']);
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
            $item['items'] = $this->getItemsDetail(["ai.account_id"=>$item['id']]);
            $result[] = $item;
        }

        return $result;
    }
}
