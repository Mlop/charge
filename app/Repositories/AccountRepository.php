<?php
/**
 * 帐目数据与业务中间层
 * User: Vera
 * Date: 2019/2/27
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Account;

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
}