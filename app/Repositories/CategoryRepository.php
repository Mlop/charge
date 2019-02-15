<?php
/**
 * 分类
 * User: Vera
 * Date: 2019/2/15
 * Time: 14:28
 */
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';
    const TYPE_LOAN = 'loan';

    public function getBuilder()
    {

    }

    /**
     * 关注的分类
     * @param string $type 类型
     * @return array
     */
    public function getFavorite($type = self::TYPE_IN)
    {
        return Category::join("category_favorite", "id", "=", "category_id")
            ->where("type", $type)
            ->get();
    }

    /**
     * 获取一级分类
     * @param string $type
     * @param int $parent_id
     */
    public function get($type = self::TYPE_IN, $parent_id = 0)
    {
        return Category::where("type", $type)
            ->where("parent_category_id", $parent_id)
            ->get();
    }

    public function count($type = self::TYPE_IN, $parent_id = 0)
    {
        return Category::where("type", $type)
            ->where("parent_category_id", $parent_id)
            ->count();
    }
}