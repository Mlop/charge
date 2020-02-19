<?php
/**
 * 账本数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\BookItem;

class BookItemRepository
{
    public function exists($data)
    {
        return BookItem::where($data)->exists();
    }
	public function get($id)
    {
		return BookItem::find($id);
    }
	public function edit($id, $params)
	{
		return $this->get($id)->update($params);
	}
	
	public function add($params)
	{
		return BookItem::create($params);
	}
	public function getList($book_id)
	{
		return BookItem::where("book_id", $book_id)->get();
	}
	public function delete($id)
	{
		return $this->get($id)->delete();
	}
}