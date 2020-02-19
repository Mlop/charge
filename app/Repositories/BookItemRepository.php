<?php
/**
 * 账本数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\BookItem;
use Illuminate\Support\Facades\DB;

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
		return BookItem::join("item", "book_item.item_id", "item.id")
            ->where("book_id", $book_id)
            ->select("item.id", "item.title")
            ->get();
	}

    public function getNotSelectedItems($book_id)
    {
        $sql = "select id,title from item where id not in(select item_id from book_item where book_id=:book_id)";
        $result = DB::select($sql, [":book_id"=>$book_id]);

        return json_decode(json_encode($result), true);
	}
    public function deleteByParams($params)
    {
        return BookItem::where($params)->delete();
    }
	public function delete($id)
	{
		return $this->get($id)->delete();
	}
}