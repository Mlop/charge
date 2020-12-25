<?php
/**
 * 工具类数据与业务中间层
 * User: Vera
 * Date: 2019/12/24
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\TaskTodo;

class ToolRepository
{
    public function exists($data)
    {
        return TaskTodo::where($data)->exists();
    }
	public function get($id)
    {
		return TaskTodo::find($id);
    }
	public function edit($id, $params)
	{
		return $this->get($id)->update($params);
	}
	
	public function add($params)
	{
		return TaskTodo::create($params);
	}
	public function getTodoList($params = [])
	{
		return TaskTodo::select(["id","desc","status","user_id"])->where($params)->get();
	}
	public function delete($id)
	{
		return $this->get($id)->delete();
	}
}