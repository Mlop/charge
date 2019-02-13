<?php
/**
 * 用户功能函数，负责数据库与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\User;
use DB;
use App\Models\Category;

class UserRepository
{
    const CATEGORY_TYPE_IN = 'in';
    const CATEGORY_TYPE_OUT = 'out';
    const CATEGORY_TYPE_LOAN = 'loan';
    /**
     * 初始化分类表
     */
    public function initCategory()
    {
        DB::transaction(function () {
            //支出分类
            $now = DB::Raw('now()');
            $id = Category::insertGetId(['title' => '餐饮', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '早餐', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '午餐', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '晚餐', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '饮料水果', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '买菜原料', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '油盐酱醋', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '餐饮其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '交通', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '打车', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '加油', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '停车费', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '火车', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '长途汽车', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '公交', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '地铁', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '交通其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '购物', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '服装鞋包', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '家居百货', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '宝宝用品', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '烟酒', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电子数码', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '报刊书籍', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电器', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '购物其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '娱乐', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '旅游度假', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电影', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '运动健身', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '花鸟宠物', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '聚会玩乐', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '娱乐其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '居家', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '手机电话', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '水电燃气', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '生活费', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '房款房贷', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '快递邮政', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '物业', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '消费贷款', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '生活其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '人情', 'type' => self::CATEGORY_TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '礼金红包', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '物品', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '人情其他', 'type' => self::CATEGORY_TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            //收入分类
            Category::insert([
                ['title' => '红包', 'type' => self::CATEGORY_TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '工资薪水', 'type' => self::CATEGORY_TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '营业收入', 'type' => self::CATEGORY_TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '奖金', 'type' => self::CATEGORY_TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '其他', 'type' => self::CATEGORY_TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            //贷款分类
            Category::insert([
                ['title' => '借入', 'type' => self::CATEGORY_TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '借出', 'type' => self::CATEGORY_TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '还款', 'type' => self::CATEGORY_TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '收款', 'type' => self::CATEGORY_TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
        });
    }

    public function create($data)
    {
        return User::create($data);
    }

//    public static function __callStatic($method, $arguments)
//    {
//        return call_user_func_array(
//            array(new static, $method), $arguments
//        );
//    }
}