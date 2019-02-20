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
        $this->userId = $user->id;
    }

    public function add(Request $request)
    {
        $title = $request->input('title');
        $data = ['title'=>$title, 'user_id'=>$this->userId];
        $isExists = $this->bookRep->exists($data);
        if ($isExists) {
            return ['code'=>1, 'msg'=>'该账本已经存在'];
        }
        return $this->bookRep->create($data);
    }
	
	public function getList()
	{
		return $this->bookRep->getList($this->userId);
	}
}