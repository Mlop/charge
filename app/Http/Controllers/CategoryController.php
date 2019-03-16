<?php
/**
 * 分类增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use Auth;

class CategoryController extends Controller
{
    protected $catRep;
    protected $user;
    protected $userId;

    public function __construct(CategoryRepository $catRep)
    {
        $this->catRep = $catRep;
        $this->user = Auth::user();
        $this->userId = $this->user->id;
    }

    public function getList(Request $request)
    {
        $type = $request->input('type', CategoryRepository::TYPE_IN);
        $parent_id = $request->input('parent_id', 0);
		$include_sub = $request->input('include_sub', false);
        $list = $this->catRep->getList($type, $parent_id);

        //孙类别数量
		$allSubTotal = 0;
        foreach ($list as $i => $cat) {
			$subTotal = $this->catRep->count($type, $cat->id);
            $cat->total = $subTotal;
			$allSubTotal += $subTotal;
			if ($include_sub) {
                $cat->sub = $this->catRep->getList($type, $cat->id);
			}
        }
        $cats = $list->toArray();
		if ($include_sub) {
		    if ($allSubTotal == 0 && $parent_id == 0) {
                $cats = [["id" => 0, "title" => "常用", "type" => $type, "sub" => $list]];
            }
            $favorites = $this->catRep->getFavorite($this->userId, $type);
            if (count($favorites) > 0) {
                array_unshift($cats, ["id"=>0, "title"=>"收藏", "type"=>$type, "sub"=>$favorites]);
            }
		}

        return $cats;
    }
	public function getFavoriteList(Request $request)
	{
		$type = $request->input('type', CategoryRepository::TYPE_IN);
		return $this->catRep->getFavorite($this->userId, $type);
	}
	/**
	添加或编辑类别
	*/
	public function edit(Request $request, $id)
	{
		$title = $request->input("title");
		$parent_id = $request->input("parent_id");
		$type = $request->input("type");
		
		//创建
		if ($id == 0) {
			$params = [
				"title" => $title,
				"parent_category_id" => $parent_id,
				"type" => $type,
//                "user_id" => , @todo
			];
			return $this->catRep->add($params);
		} else {//编辑
			$params = [
				"title" => $title,
			];
			
			$isOk = $this->catRep->edit($id, $params);
			return $isOk ? ['code'=>0, 'msg'=>'修改成功'] : ['code'=>1, 'msg'=>'修改失败'];
		}
	}
	public function del($id)
	{
		$isOk = $this->catRep->del($id);
		return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}

    public function addFavorite($id)
    {
        $params = [
            'category_id' => $id,
            'user_id' => $this->userId,
        ];
        $isOk = $this->catRep->addFavorite($params);
        if (!$isOk) {
            return ['code'=>1, 'msg'=>'添加失败'];
        }
        return $isOk;
	}

    public function removeFavorite($id)
    {
        $isOk = $this->catRep->deleteFavorite($id, $this->userId);
        return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}
}