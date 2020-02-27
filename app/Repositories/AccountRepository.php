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
use Carbon\Carbon;

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
     * 根据条件搜索结果，返回分页数据
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        extract($params);
        $builder = Account::join("book as b", "account.book_id", "=", "b.id")->select("account.type", "b.title");
        if (isset($year) && $year) {
            $builder = $builder
                ->whereRaw("DATE_FORMAT(created_at,'%Y')", $params['year']);
        }
        if (isset($book) && $book) {
            $builder = $builder
                ->where("account.book_id", $book);
        }
        if (isset($contact) && $contact) {
            $builder = $builder->where("contact", $contact);
        }
        $data = $builder->get();
        return $data;
    }
}