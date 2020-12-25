<?php
/**
 * 工具函数，如未完成工作
 * User: Vera
 * Date: 2020/12/24
 * Time: 09:19
 */

namespace App\Http\Controllers;

use App\Models\TaskTodo;
use App\Repositories\ToolRepository;
use Illuminate\Http\Request;
use Auth;

class ToolController extends Controller
{
    protected $rep;
    protected $userId;

    public function __construct(ToolRepository $rep)
    {
        $this->rep = $rep;
        $user = $this->getUser();
        $this->userId = $user ? $user->id : 0;
    }

    /**
     * 添加/编辑任务, desc
     * @param Request $request
     * @return mixed
     */
    public function editTodo(Request $request, $id)
    {
        $params = [
            'user_id'=>$this->userId,
            'desc'=>$request->input('desc'),
            'status'=>$request->input('status', TaskTodo::STATUS_TODO),
        ];
        //编辑
        if ($id) {
            $result = $this->rep->edit($id, $params);
            $result = $result ? $this->successResult($result) : $this->failResult();
        } else {
            $result = $this->rep->add($params);
        }
        return $result;
    }
    /**
     * 计划任务列表
     * @param Request $request
     * @return mixed
     */
	public function getTodoList(Request $request)
	{
        return $this->rep->getTodoList(['user_id'=>$this->userId]);
	}

    /**
     * 删除任务
     * @param $id
     * @return array
     */
    public function deleteTodo($id)
    {
        $isOk = $this->rep->delete($id);
        return $isOk ? ['code'=>0, 'msg'=>'删除成功'] : ['code'=>1, 'msg'=>'删除失败'];
	}
}
