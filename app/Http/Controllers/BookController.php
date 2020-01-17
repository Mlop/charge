<?php
/**
 * 账本增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use Auth;

class BookController extends Controller
{
    protected $bookRep;
    protected $userId;

    public function __construct(BookRepository $bookRep)
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
	public function getList()
	{
		return $this->bookRep->getList($this->userId);
	}
}