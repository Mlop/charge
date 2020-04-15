<?php
/**
 * 公共数据
 * @author Vera
 * @date 2020-02-22 11:15
 */
namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected $contactRep;
    public function __construct(ContactRepository $contactRep)
    {
        $this->contactRep = $contactRep;
    }
    public function contactList()
    {
        return $this->contactRep->builder([])->pluck("name");
    }

    /**
     * 上传文件到public目录
     */
    public function uploadFile(Request $request)
    {var_dump('abc');exit;
        $savePath = base_path()."/public/upload";
        if (!file_exists($savePath)) {
            mkdir($savePath);
            chmod($savePath, 0777);
        }
        $file=$request->file('file');var_dump($file->isValid());exit;
        $res = ['code' => 1, 'data'=>null, 'msg' => 'invalid file'];
        if ($file->isValid()) {
            $dir = $savePath;
            $filename = date('YmdHis').rand(0, 1000).'.'.$file->guessExtension();
            $file->move( $dir, $filename);

            $res['code'] = 0;
            $res['data'] = env("UPLOAD_URL").$filename;
            $res['msg'] = 'success';
        }
        return $res;
    }
}
