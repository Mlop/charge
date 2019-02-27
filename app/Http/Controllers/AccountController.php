<?php
/**
 * 收入增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Auth;

class AccountController extends Controller
{
    protected $rep;
	protected $catRep;
    protected $userId;

    public function __construct(AccountRepository $rep, CategoryRepository $catRep)
    {
        $this->rep = $rep;
        $user = Auth::user();
        $this->userId = $user->id;
		$this->catRep = $catRep;
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->userId;
        return $this->rep->create($data);
    }

    public function delete($id)
    {
        $isOk = $this->rep->delete($id);
        return $isOk ? ['code' => 0] : ['code' => 1];
    }

    public function edit(Request $request, $id)
    {
        $parmas = $request->all();
        $isOk = $this->rep->edit($id, $parmas);
        return $isOk ? ['code' => 0] : ['code' => 1, 'msg' => '该支出项不存在'];
    }
	
	public function get($id)
	{
		$data = $this->rep->get($id);
		if (!$data) {
			return ['code'=>1, 'msg'=>'未找到'];
		}
		$data->category_title = $this->catRep->getField($data->category_id);
		return $data;
	}
}