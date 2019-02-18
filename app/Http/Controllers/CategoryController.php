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

class CategoryController extends Controller
{
    protected $catRep;

    public function __construct(CategoryRepository $catRep)
    {
        $this->catRep = $catRep;
    }

    public function getList(Request $request)
    {
        $type = $request->input('type', CategoryRepository::TYPE_IN);
        $parent_id = $request->input('parent_id', 0);
		$include_sub = $request->input('include_sub', false);
        $list = $this->catRep->getList($type, $parent_id);
        foreach ($list as $i => $cat) {
            $list[$i]['total'] = $this->catRep->count($type, $cat->id);
			if ($include_sub) {
				$list[$i]['sub'] = $this->catRep->getList($type, $cat->id);
			}
        }
        return $list;
    }
	public function getFavoriteList(Request $request)
	{
		$type = $request->input('type', CategoryRepository::TYPE_IN);
		return $this->catRep->getFavorite($type);
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
}