<?php
/**
 * 分类
 * User: Vera
 * Date: 2019/2/15
 * Time: 14:28
 */
namespace App\Repositories;

use App\Models\Category;
use App\Models\CategoryFavorite;
use DB;

class CategoryRepository
{
    const TYPE_IN = 'income';
    const TYPE_OUT = 'outgo';
    const TYPE_LOAN = 'loan';
	const FAVORITE_YES = 'yes';
	const FAVORITE_NO = 'no';

    public function get($id)
    {
		return Category::find($id);
    }

    /**
     * 关注的分类
     * @param string $type 类型
     * @return array
     */
    public function getFavorite($user_id, $type = self::TYPE_IN)
    {
        return Category::select("category.*",DB::Raw("1 as isFav"))
			->join("category_favorite", "category.id", "=", "category_favorite.category_id")
            ->where("category.type", $type)
            ->where("category_favorite.user_id", $user_id)
            ->get();
    }

    public function addFavorite($param)
    {
        if (CategoryFavorite::where($param)->exists()) {
            return false;
        }
        return CategoryFavorite::create($param);
    }

    public function deleteFavorite($id, $userId)
    {
        return CategoryFavorite::where("category_id", $id)->where("user_id", $userId)->delete();
    }

    /**
     * 获取一级分类
     * @param string $type
     * @param int $parent_id
     */
    public function getList($type = self::TYPE_IN, $parent_id = 0)
    {
        $sql = "SELECT *,(SELECT cf.id FROM category_favorite cf WHERE cf.category_id=c.id) AS fav_id 
                      FROM category c 
                      WHERE type = '{$type}'
                      AND parent_category_id = {$parent_id}";
        return DB::table(DB::Raw("({$sql}) t1"))
            ->select("id","title","type","parent_category_id", DB::Raw("IFNULL(fav_id, 0)>0 as isFav"))
            ->get();
    }

    public function count($type = self::TYPE_IN, $parent_id = 0)
    {
        return Category::where("type", $type)
            ->where("parent_category_id", $parent_id)
            ->count();
    }
	
	public function edit($id, $params)
	{
		return $this->get($id)->setRawAttributes($params)->save();
	}
	
	public function add($params)
	{
		return Category::create($params);
	}
	public function del($id)
	{
		DB::beginTransaction();
		
		try {
			//删除所有子类别
			Category::where("parent_category_id", $id)->delete();
			//删除自己
			$this->get($id)->delete();
			DB::commit();
		} catch (Exception $ex) {
			DB::rollback();
			return false;
		}
		return true;
	}
	public function getField($id, $field = "title")
	{
		return Category::where("id", $id)->value($field);
	}
}