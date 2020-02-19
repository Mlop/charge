<?php
/**
 * 账本独立条目增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    protected $itemRep;
    protected $userId;

    public function __construct(ItemRepository $itemRep)
    {
        $this->itemRep = $itemRep;
    }
	/**
	添加或编辑
	*/
	public function edit(Request $request, $id)
	{
		$title = $request->input("title");

		//创建
		if ($id == 0) {
			$params = [
				"title" => $title,
			];
			$isExists = $this->itemRep->exists($params);
			if ($isExists) {
			    return ['code'=>1, 'msg'=>'该条目已经存在'];
			}
			return $this->itemRep->add($params);
		} else {//编辑
			$params = [
				"title" => $title,
			];
			
			$isOk = $this->itemRep->edit($id, $params);
			return $isOk ? ['code'=>0, 'msg'=>'修改成功'] : ['code'=>1, 'msg'=>'修改失败'];
		}
	}
	public function delete($id)
	{
		$isOk = $this->itemRep->delete($id);
		return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}

    /**
     * 复选框列表数据
     * @return mixed
     */
	public function getList(Request $request)
	{
		$list = $this->itemRep->getList();
		$data = [];
		foreach ($list as $item) {
		    $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => true];
        }
        return $data;
	}
}