<?php
/**
 * 收入增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use App\Repositories\LoanRepository;
use Illuminate\Http\Request;
use Auth;

class LoanController extends Controller
{
    protected $loanRep;
    protected $userId;

    public function __construct(LoanRepository $loanRep)
    {
        $this->loanRep = $loanRep;
        $user = Auth::user();
        $this->userId = $user->id;
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->userId;
        return $this->loanRep->create($data);
    }

    public function edit(Request $request, $id)
    {
        $parmas = $request->all();
        $isOk = $this->loanRep->edit($id, $parmas);
        return $isOk ? ['code'=>0] : ['code'=>1, 'msg'=>'该收入项不存在'];
    }

    public function delete($id)
    {
        $isOk = $this->loanRep->delete($id);
        return $isOk ? ['code'=>0] : ['code'=>1];
    }
}