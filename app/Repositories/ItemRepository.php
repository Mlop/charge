<?php
/**
 * 账本的独立条目数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Item;

class ItemRepository
{
    public function exists($data)
    {
        return Item::where($data)->exists();
    }
	public function get($id)
    {
		return Item::find($id);
    }
	public function edit($id, $params)
	{
		return $this->get($id)->update($params);
	}
	
	public function add($params)
	{
		return Item::create($params);
	}
	public function getList()
	{
		return Item::get();
	}
	public function delete($id)
	{
		return $this->get($id)->delete();
	}
}