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
use App\Models\BookItem;
use App\Models\Image;
use App\Models\Item;
use Carbon\Carbon;
use DB;
use App\Facades\MyFun;

class AccountRepository
{
    const MYSELF_STR = '自己';
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
        // 开始事务
        DB::beginTransaction();
        try {
            //账本条目
            $builder = BookItem::where(["book_id"=>$id]);
            if ($builder) {
                $builder->delete();
            }
            $builder = $this->get($id);
            if ($builder) {
                $builder->delete();
            }
            // 流程操作顺利则commit
            DB::commit();
        } catch (\Exception $e) {
            // 抛出异常则rollBack
            DB::rollBack();
        }
        return true;
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
        $pureCash = "if(acc.type='income', acc.cash, -1*acc.cash) pure_cash";

        $reportRep = new ReportRepository();
        $reportRep->getDetailAll($user_id, $pureCash);
        $query = DB::table(DB::Raw("(".$reportRep->getDetailAll($user_id, $pureCash).") as t1"))
            ->select("contact",DB::Raw("count(1) as totalTimes"), DB::Raw("round(sum(pure_cash), 2) as cash"))
            ->groupBy("contact");
        //记账年限搜索
        if (isset($params['year']) && $params['year']) {
            $query = $query->whereRaw("DATE_FORMAT(account.record_at, '%Y')=".$params['year']);
        }
        //类型搜索
        if (isset($params['type']) && $type = trim($params['type'], ",")) {
            $query = $query->whereIn('type', explode(",", $params['type']));
        }
        //联系人过滤
        if (isset($params['contact']) && $params['contact']) {
            if ($params['contact'] == self::MYSELF_STR) {
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
        $data = json_decode(json_encode($data), true);
        $result = [];
        foreach ($data as $item) {
            $cond['a.contact'] = $item['contact'];
            $item['contact'] = $item['contact'] ? : self::MYSELF_STR;//自己
            $item['cash'] = MyFun::formatCash($item['cash']);
            $item['items'] = $this->statItems($cond)->toArray();
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
            ->select("title",DB::Raw("round(sum(item_value), 2) as totalValue"),"a.type")
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
            if ($contact == self::MYSELF_STR) {
                $contact = '';
            }
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

    /**
     * 筛选条件的类型
     * 'outgo'=>'支出',
     * 'income'=>'收入',
     * 'loan'=>'借贷',
     */
    public function getFilterTypes()
    {
        $data[] = [
            "title" => "类型不限",
            "value" => ""
        ];
        foreach (Account::$typeConfig as $value => $title) {
            $data[] = [
                "title" => $title,
                "value" => $value
            ];
        }
        return $data;
    }
}
