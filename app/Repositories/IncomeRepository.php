<?php
/**
 * 收入数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Income;

class IncomeRepository
{
    public function exists($data)
    {
        return Income::where($data)->exists();
    }
    public function get($id)
    {
        return Income::find($id);
    }
    public function create($data)
    {
        return Income::create($data);
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
        return $item->setRawAttributes($params)->save();
    }
}