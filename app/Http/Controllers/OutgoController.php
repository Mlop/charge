<?php
/**
 * 收入增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use App\Repositories\OutgoRepository;
use Illuminate\Http\Request;
use Auth;

class OutgoController extends Controller
{
    protected $outRep;
    protected $userId;

    public function __construct(OutgoRepository $outRep)
    {
        $this->outRep = $outRep;
        $user = Auth::user();
        $this->userId = $user->id;
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->userId;
        return $this->outRep->create($data);
    }

    public function delete($id)
    {
        $isOk = $this->outRep->delete($id);
        return $isOk ? ['code' => 0] : ['code' => 1];
    }

    public function edit(Request $request, $id)
    {
        $parmas = $request->all();
        $isOk = $this->outRep->edit($id, $parmas);
        return $isOk ? ['code' => 0] : ['code' => 1, 'msg' => '该支出项不存在'];
    }
}