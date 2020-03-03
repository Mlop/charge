<?php
/**
 * 账本数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Book;
use App\Models\Account;
use Illuminate\Support\Facades\Redis;
use DB;

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

    /**
     * 缓存我的账本1小时，有从缓存中取，没有则从数据库获取
     * @param $user_id
     * @return mixed
     */
	public function getList($user_id)
	{
        $list = json_decode(Redis::get("books_".$user_id));
        if (!$list) {
            $list = Book::where("user_id", $user_id)->get();
            Redis::setex("books_".$user_id, 7200, $list);
        }
        return $list;
	}
    /**
     * 筛选条件的账本列表
     * @return mixed
     */
    public function getFilterList($user_id)
    {
        $books = $this->getList($user_id);
        $data[] = [
            "title" => "不限",
            "value" => ""
        ];
        foreach ($books as $item) {
            $data[] = [
                "title" => $item->title,
                "value" => $item->id
            ];
        }
        return $data;
	}

	public function delete($id)
	{
		return $this->get($id)->delete();
	}

    /**
     * 账目创建年份(筛选条件的年份)
     * @return mixed
     */
    public function getFilterYears($user_id)
    {
        $years = Account::select(DB::Raw("DATE_FORMAT(created_at,'%Y') as create_year"))
            ->where("user_id", $user_id)
            ->groupBy("create_year")
            ->get();
        $data[] = [
            "title" => "不限",
            "value" => ""
        ];
        foreach ($years as $item) {
            $data[] = [
                "title" => $item->create_year,
                "value" => $item->create_year
            ];
        }
        return $data;
	}

    /**
     * 清除缓存账本列表的缓存
     * @param $user_id
     */
    public function clearBooksCache($user_id)
    {
        Redis::del("books_".$user_id);
	}
}