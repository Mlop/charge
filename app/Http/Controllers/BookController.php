<?php
/**
 * 账本增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Repositories\BookItemRepository;
use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use Auth;

class BookController extends Controller
{
    protected $bookRep;
    protected $userId;
    protected $bookItemRep;
    protected $accountRep;

    public function __construct(BookRepository $bookRep, BookItemRepository $bookItemRep, AccountRepository $accountRep)
    {
        $this->bookRep = $bookRep;
        $this->bookItemRep = $bookItemRep;
        $user = $this->getUser();
        $this->userId = $user ? $user->id : 0;
        $this->accountRep = $accountRep;
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
				"user_id"=>$this->userId
			];
			$isExists = $this->bookRep->exists($params);
			if ($isExists) {
			    return ['code'=>1, 'msg'=>'该账本已经存在'];
			}
			$isOk = $this->bookRep->add($params);
			if ($isOk) {
                $this->bookRep->clearBooksCache($this->userId);
            }
            return $isOk ? ['code'=>0, 'msg'=>'添加成功'] : ['code'=>1, 'msg'=>'添加失败'];
		} else {//编辑
			$params = [
				"title" => $title,
			];

			$isOk = $this->bookRep->edit($id, $params);
            if ($isOk) {
                $this->bookRep->clearBooksCache($this->userId);
            }
			return $isOk ? ['code'=>0, 'msg'=>'修改成功'] : ['code'=>1, 'msg'=>'修改失败'];
		}
	}
	public function delete($id)
	{
		$isOk = $this->bookRep->delete($id);
		return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}
	public function getList()
	{
        return $this->bookRep->getList($this->userId);
	}
    /**
     * 复选框列表数据
     * @return mixed
     */
    public function getItemList(Request $request, $book_id)
    {
        $isIncludeUncheck = $request->get('is_include_uncheck', 1);
        $defaultConfig = ['', '0.00', '0', '输入或选择姓名'];
        $list = $this->bookItemRep->getList($book_id)->toArray();
        $data = [];
        foreach ($list as $item) {
            $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => true, 'value_type'=>$item['value_type'], 'default_value'=>$defaultConfig[$item['value_type']]];
        }
        if ($isIncludeUncheck) {
            $notSelect = $this->bookItemRep->getNotSelectedItems($book_id);
            foreach ($notSelect as $item) {
                $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => false, 'value_type'=>$item['value_type'], 'default_value'=>$defaultConfig[$item['value_type']]];
            }
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
            $isExists = $this->bookItemRep->exists($params);
            if ($isExists) {
                return ['code' => 1, 'msg' => '该条目已经存在'];
            }
            return $this->bookItemRep->add($params);
        } else {
            //如果已被使用，不能删除
            $isExists = $this->accountRep->getItemBuilder(["item_id"=>$itemId])->join("account", "account_id", "=", "account.id")
                ->where("book_id", $book_id)->exists();
            if ($isExists) {
                return ['code'=>1, 'msg'=>'取消失败,该列项正在使用中'];
            }
            $params = [
                "item_id" => $itemId,
                "user_id" => $this->userId,
                "book_id" => $book_id
            ];
            $isOk = $this->bookItemRep->deleteByParams($params);
            return $isOk ? ['code'=>0, 'msg'=>'取消成功'] : ['code'=>1, 'msg'=>'取消失败'];
        }
        return ['code'=>0, 'msg'=>'操作成功'];
    }
}
