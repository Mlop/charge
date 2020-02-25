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
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Auth;
use DB;

class AccountController extends Controller
{
    protected $rep;
	protected $catRep;
    protected $userId;
    protected $contactRep;

    public function __construct(AccountRepository $rep, CategoryRepository $catRep, ContactRepository $contactRep)
    {
        $this->rep = $rep;
        $user = Auth::user();
        $this->userId = $user->id;
		$this->catRep = $catRep;
        $this->contactRep = $contactRep;
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->userId;
        $data['cash'] = $data['cash'] ? $data['cash'] : 0;

        DB::beginTransaction();
        try {
            //保存名称到contact
            $this->contactRep->createNotExists(['name' => $data['contact']]);
            $items = $data['items'];
            $data['items'] = json_encode($items);
            //保存account
            $account = $this->rep->create($data);
            //保存items
            foreach ($items as $item) {
                $this->rep->createItems([
                    'item_id' => $item['value'],
                    'account_id' => $account->id,
                    'item_value' => $item['formValue'],
                ]);
            }
            DB::commit();
            return $account;
        } catch (\Exception $ex) {
            DB::rollback();
            return ['code'=>1, 'msg'=>'save db exception.'.$ex->getMessage()];
        }

    }

    public function delete($id)
    {
        $isOk = $this->rep->delete($id);
        return $isOk ? ['code' => 0] : ['code' => 1];
    }

    public function edit(Request $request, $id)
    {
        $parmas = $request->all();
        $parmas['cash'] = $parmas['cash'] ? $parmas['cash'] : 0;
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