<?php
/**
 * 收入数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Outgo;

class OutgoRepository
{
    public function exists($data)
    {
        return Outgo::where($data)->exists();
    }

    public function get($id)
    {
        return Outgo::find($id);
    }
    public function create($data)
    {
        return Outgo::create($data);
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

    public function builder($cond)
    {
        return Outgo::where($cond);
    }
}