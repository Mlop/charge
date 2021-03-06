<?php
/**
 * 打卡记录增、删、改
 * User: Vera
 * Date: 2020/09/17
 * Time: 09:19
 */

namespace App\Http\Controllers;

use App\Repositories\WorkRecordRepository;
use Illuminate\Http\Request;
use Auth;

class WorkRecordController extends Controller
{
    protected $recordRep;
    protected $userId;

    public function __construct(WorkRecordRepository $recordRep)
    {
        $this->recordRep = $recordRep;
        $user = $this->getUser();
        $this->userId = $user ? $user->id : 0;
    }
	/**
	添加或编辑
	*/
	public function edit(Request $request)
	{
		$work_date = $request->input("work_date");
		$record_at = $request->input("record_at");
        $row = $this->recordRep->find(["work_date" => $work_date, "user_id"=>$this->userId]);
		//创建
		if (!$row->exists()) {
			$params = [
				"work_date" => $work_date,
				"record_info" => json_encode([$record_at]),
				"user_id"=>$this->userId
			];
			$isOk = $this->recordRep->add($params);
            return $isOk ? ['code'=>0, 'msg'=>'打卡成功'] : ['code'=>1, 'msg'=>'打卡失败'];
		} else {//编辑
            $row = $row->first();
            $record_info = json_decode($row->record_info, true);
            array_push($record_info, $record_at);
            $params = [
                "work_date" => $work_date,
                "record_info" => json_encode($record_info),
            ];
			$isOk = $this->recordRep->edit($row->id, $params);
			return $isOk ? ['code'=>0, 'msg'=>'打卡成功'] : ['code'=>1, 'msg'=>'打卡失败'];
		}
	}

	public function getList(Request $request)
	{
        $month = $request->input("month");
        return $this->recordRep->getList($this->userId, $month);
	}
    /**
     * 复选框列表数据
     * @return mixed
     */
//    public function getItemList(Request $request, $book_id)
//    {
//        $isIncludeUncheck = $request->get('is_include_uncheck', 1);
//        $defaultConfig = ['', '0.00', '0', '输入或选择姓名'];
//        $list = $this->bookItemRep->getList($book_id)->toArray();
//        $data = [];
//        foreach ($list as $item) {
//            $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => true, 'value_type'=>$item['value_type'], 'default_value'=>$defaultConfig[$item['value_type']]];
//        }
//        if ($isIncludeUncheck) {
//            $notSelect = $this->bookItemRep->getNotSelectedItems($book_id);
//            foreach ($notSelect as $item) {
//                $data[] = ['value' => (string)$item['id'], 'name' => $item['title'], 'checked' => false, 'value_type'=>$item['value_type'], 'default_value'=>$defaultConfig[$item['value_type']]];
//            }
//        }
//        return $data;
//    }
//
//    /**
//     * 选择和取消账本的列项
//     * @param Request $request
//     * @param $book_id
//     * @return array
//     */
//    public function checkItems(Request $request, $book_id)
//    {
//        $isCheck = $request->input('is_check', true);
//        $itemId = $request->input('item_id');
//        if ($isCheck) {
//            $params = [
//                "item_id" => $itemId,
//                "user_id" => $this->userId,
//                "book_id" => $book_id
//            ];
//            $isExists = $this->bookItemRep->exists($params);
//            if ($isExists) {
//                return ['code' => 1, 'msg' => '该条目已经存在'];
//            }
//            return $this->bookItemRep->add($params);
//        } else {
//            //如果已被使用，不能删除
//            $isExists = $this->accountRep->getItemBuilder(["item_id"=>$itemId])->join("account", "account_id", "=", "account.id")
//                ->where("book_id", $book_id)->exists();
//            if ($isExists) {
//                return ['code'=>1, 'msg'=>'取消失败,该列项正在使用中'];
//            }
//            $params = [
//                "item_id" => $itemId,
//                "user_id" => $this->userId,
//                "book_id" => $book_id
//            ];
//            $isOk = $this->bookItemRep->deleteByParams($params);
//            return $isOk ? ['code'=>0, 'msg'=>'取消成功'] : ['code'=>1, 'msg'=>'取消失败'];
//        }
//        return ['code'=>0, 'msg'=>'操作成功'];
//    }
}
