<?php
/**
 * 收入增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use App\Facades\MyFun;
use App\Models\Item;
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
        $user = $this->getUser();
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
            if (isset($data['contact']) && $data['contact']) {
                //保存名称到contact
                $this->contactRep->createNotExists(['name' => $data['contact']]);
            }
            $items = $data['items'];
            $data['items'] = json_encode($items);
            //保存account
            $account = $this->rep->create($data);
            //包含图片
            if ($data['images']) {
                $images = $data['images'];
                $imageBuilder = $this->rep->getImageBuilder(['rel_id'=>$account->id]);
                $sourcePath = $imageBuilder->pluck("path")->toArray();
                if (array_diff($images, $sourcePath)) {//有修改，删除已有，添加新图片
                    $imageBuilder->delete();
                    foreach ($images as $path) {
                        $this->rep->createImages([
                            'rel_id'=>$account->id,
                            'path' => $path,
                        ]);
                    }
                }
            }
            //保存items
            foreach ($items as &$item) {
                //现金
                if ($item['value_type'] == Item::VALUE_TYPE_DECIMAL) {
                    $item['formValue'] = $item['formValue'] ? $item['formValue'] : 0;
                    //格式化价格金额显示
                    $item['formValue'] = number_format($item['formValue'], 2, '.', '');
                }
                $this->rep->createItems([
                    'item_id' => $item['value'],
                    'account_id' => $account->id,
                    'item_value' => $item['formValue'],
                ]);
            }
            $this->rep->edit($account->id, ['items'=>json_encode($items)]);
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
        $params = $request->all();
        DB::beginTransaction();
        try {
            $items = $params['items'];
            //保存items
            foreach ($items as &$item) {
                //现金
                if ($item['value_type'] == Item::VALUE_TYPE_DECIMAL) {
                    $item['formValue'] = $item['formValue'] ? $item['formValue'] : 0;
                    $item['formValue'] = number_format($item['formValue'], 2, '.', '');
                    $params['cash'] = $item['formValue'];
                } else if ($item['value_type'] == Item::VALUE_TYPE_COMBOX) {//姓名
                    $params['contact'] = $item['formValue'];
                    if ($params['contact']) {
                        //保存名称到contact
                        $this->contactRep->createNotExists(['name' => $params['contact']]);
                    }
                }
                $this->rep->updateItem(
                    [
                        'item_id' => $item['value'],
                        'account_id' => $id,
                    ],
                    [
                        'item_value' => $item['formValue'],
                    ]
                );
            }
            //保存account
            $params['items'] = json_encode($items);
            $isOk = $this->rep->edit($id, $params);
            //包含图片
            if ($params['images']) {
                $images = $params['images'];
                $imageBuilder = $this->rep->getImageBuilder(['rel_id'=>$id]);
                $sourcePath = $imageBuilder->pluck("path")->toArray();
                if (array_diff($images, $sourcePath)) {//有修改，删除已有，添加新图片
                    $imageBuilder->delete();
                    foreach ($images as $path) {
                        $this->rep->createImages([
                            'rel_id'=>$id,
                            'path' => $path,
                        ]);
                    }
                }
            }
            DB::commit();
            return $isOk ? ['code' => 0] : ['code' => 1, 'msg' => '该支出项不存在'];
        } catch (\Exception $ex) {
            DB::rollback();
            return ['code'=>1, 'msg'=>'save db exception.'.$ex->getMessage()];
        }
    }

	public function get($id)
	{
		$data = $this->rep->get($id);
        $data->record_at_date = MyFun::getDateStr($data->record_at);
		if (!$data) {
			return ['code'=>1, 'msg'=>'未找到'];
		}
		$data->category_title = $this->catRep->getField($data->category_id);
		$data->items = json_decode($data->items, true);
		$data->images = $this->rep->getImageBuilder(['rel_id'=>$id])->pluck("path")->toArray();
		return $data;
	}
}
