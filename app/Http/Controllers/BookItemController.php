<?php
/**
 * 账本条目增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookItemRepository;
use Auth;

class BookItemController extends Controller
{
    protected $bookRep;
    protected $userId;

    public function __construct(BookItemRepository $bookRep)
    {
        $this->bookRep = $bookRep;
        $user = Auth::user();
        $this->userId = $user ? $user->id : 0;
    }
	/**
	添加或编辑
	*/
	public function edit(Request $request, $id)
	{
		$title = $request->input("title");
		$book_id = $request->input("book_id");

		//创建
		if ($id == 0) {
			$params = [
				"title" => $title,
				"user_id"=>$this->userId,
				"book_id"=>$book_id
			];
			$isExists = $this->bookRep->exists($params);
			if ($isExists) {
			    return ['code'=>1, 'msg'=>'该条目已经存在'];
			}
			return $this->bookRep->add($params);
		} else {//编辑
			$params = [
				"title" => $title,
			];
			
			$isOk = $this->bookRep->edit($id, $params);
			return $isOk ? ['code'=>0, 'msg'=>'修改成功'] : ['code'=>1, 'msg'=>'修改失败'];
		}
	}
	public function delete($id)
	{
		$isOk = $this->bookRep->delete($id);
		return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}

    /**
     * 复选框列表数据
     * @return mixed
     */
	public function getList(Request $request)
	{
        $book_id = $request->get('book_id');
		$list = $this->bookRep->getList($book_id);
		$data = [];
		foreach ($list as $item) {
		    $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => true];
        }
        $notSelect = $this->bookRep->getNotSelectedItems($book_id);
        foreach ($notSelect as $item) {
            $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => false];
        }
        return $data;
	}

    /**
     * 选择和取消账本的列项
     * @param Request $request
     * @param $book_id
     * @return array
     */
    public function checkItems(Request $request, $book_id)
    {
        $isCheck = $request->input('is_check', true);
        $itemId = $request->input('item_id');
        if ($isCheck) {
            $params = [
                "item_id" => $itemId,
                "user_id" => $this->userId,
                "book_id" => $book_id
            ];
            $isExists = $this->bookRep->exists($params);
            if ($isExists) {
                return ['code' => 1, 'msg' => '该条目已经存在'];
            }
            return $this->bookRep->add($params);
        } else {
            $params = [
                "item_id" => $itemId,
                "user_id" => $this->userId,
                "book_id" => $book_id
            ];
            $isOk = $this->bookRep->deleteByParams($params);
            return $isOk ? ['code'=>0, 'msg'=>'取消成功'] : ['code'=>1, 'msg'=>'取消失败'];
        }
	}
}