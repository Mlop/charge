<?php
/**
 * 账本数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function exists($data)
    {
        return Book::where($data)->exists();
    }
	public function get($id)
    {
		return Book::find($id);
    }
	public function edit($id, $params)
	{
		return $this->get($id)->update($params);
	}
	
	public function add($params)
	{
		return Book::create($params);
	}
	public function getList($user_id)
	{
		return Book::where("user_id", $user_id)->get();
	}
	public function delete($id)
	{
		return $this->get($id)->delete();
	}
}