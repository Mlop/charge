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
use App\Models\CategoryFavorite;
use App\Models\Book;
use Log;

class UserRepository
{
    /**
     * 初始化分类表
     */
    public function initCategory()
    {
        DB::transaction(function () {
            //支出分类
            $now = DB::Raw('now()');
            $id = Category::insertGetId(['title' => '餐饮', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '早餐', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '午餐', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '晚餐', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '饮料水果', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '买菜原料', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '油盐酱醋', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '餐饮其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '交通', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '打车', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '加油', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '停车费', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '火车', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '长途汽车', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '公交', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '地铁', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '交通其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '购物', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '服装鞋包', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '家居百货', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '宝宝用品', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '烟酒', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电子数码', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '报刊书籍', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电器', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '购物其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '娱乐', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '旅游度假', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '电影', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '运动健身', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '花鸟宠物', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '聚会玩乐', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '娱乐其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '居家', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '手机电话', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '水电燃气', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '生活费', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '房款房贷', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '快递邮政', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '物业', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '消费贷款', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '生活其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            $id = Category::insertGetId(['title' => '人情', 'type' => CategoryRepository::TYPE_OUT, 'created_at'=>$now, 'updated_at'=>$now]);
            Category::insert([
                ['title' => '礼金红包', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '物品', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '人情其他', 'type' => CategoryRepository::TYPE_OUT, 'parent_category_id' => $id, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            //收入分类
            Category::insert([
                ['title' => '红包', 'type' => CategoryRepository::TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '工资薪水', 'type' => CategoryRepository::TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '营业收入', 'type' => CategoryRepository::TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '奖金', 'type' => CategoryRepository::TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '其他', 'type' => CategoryRepository::TYPE_IN, 'created_at'=>$now, 'updated_at'=>$now],
            ]);
            //贷款分类
            Category::insert([
                ['title' => '借入', 'type' => CategoryRepository::TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '借出', 'type' => CategoryRepository::TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '还款', 'type' => CategoryRepository::TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
                ['title' => '收款', 'type' => CategoryRepository::TYPE_LOAN, 'created_at'=>$now, 'updated_at'=>$now],
            ]);

        });
    }

    public function create($data)
    {
        return User::create($data);
    }
	
	public function get($user_id)
	{
		return User::find($user_id);
	}
	public function exists($data)
    {
        return User::where($data)->exists();
    }
	/**
	 * 新用户注册后添加通用类别
	 */
    public function addCommonCategory($user_id)
    {
        DB::transaction(function () use ($user_id) {
            //支出通用类别
            $ids = Category::where('type', CategoryRepository::TYPE_OUT)
                ->whereIn('title', ['打车', '早餐', '午餐', '晚餐'])
                ->pluck("id");
            $now = DB::Raw('now()');
            $fav = [];
            foreach ($ids as $id) {
                $fav[] = ['category_id' => $id, 'user_id' => $user_id, 'created_at' => $now, 'updated_at' => $now];
            }
            $rows = CategoryFavorite::insert($fav);
			Log::info("addCommonCategory out ".$rows);
            //收入通用类别
            $ids = Category::where('type', CategoryRepository::TYPE_IN)
                ->whereIn('title', ['工资薪水', '奖金', '红包', '营业收入'])
                ->pluck("id");
            $fav = [];
            foreach ($ids as $id) {
                $fav[] = ['category_id' => $id, 'user_id' => $user_id, 'created_at' => $now, 'updated_at' => $now];
            }
            $rows = CategoryFavorite::insert($fav);
			Log::info("addCommonCategory in ".$rows);
            //借贷通用类别
            $ids = Category::where('type', CategoryRepository::TYPE_LOAN)
                ->whereIn('title', ['借入', '借出', '还款', '收款'])
                ->pluck("id");
            $fav = [];
            foreach ($ids as $id) {
                $fav[] = ['category_id' => $id, 'user_id' => $user_id, 'created_at' => $now, 'updated_at' => $now];
            }
            $rows = CategoryFavorite::insert($fav);
			Log::info("addCommonCategory loan ".$rows);
        });
	}
	/**
	 * 新用户注册后添加通用账本
	 */
	public function addCommonBook($user_id)
	{
		Book::create(["title"=>"日常账本", "user_id"=>$user_id]);
	}
//    public static function __callStatic($method, $arguments)
//    {
//        return call_user_func_array(
//            array(new static, $method), $arguments
//        );
//    }
}