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

    private function cors()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $origin = "*";
        if ($request_method === 'OPTIONS') {

            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET, POST, OPTIONS');

            header('Access-Control-Max-Age:1728000');
            header('Content-Type:text/plain charset=UTF-8');
            header('Content-Length: 0',true);

            header('status: 204');
            header('HTTP/1.0 204 No Content');

        }

        if ($request_method === 'POST') {

            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET, POST, OPTIONS');

        }

        if ($request_method === 'GET') {

            header('Access-Control-Allow-Origin:'.$origin);
            header('Access-Control-Allow-Credentials:true');
            header('Access-Control-Allow-Methods:GET, POST, OPTIONS');

        }
    }

    /**
     * 上传文件到public目录
     */
    public function uploadFile(Request $request)
    {
        $this->cors();
        $savePath = base_path()."/public/upload";
        if (!file_exists($savePath)) {
            mkdir($savePath);
            chmod($savePath, 0777);
        }
        $file=$request->file('file');
        $res = ['code' => 1, 'data'=>null, 'msg' => 'invalid file'];
        if ($file->isValid()) {
            $dir = $savePath;
            $filename = date('YmdHis').rand(0, 1000).'.'.$file->guessExtension();
            $file->move( $dir, $filename);

            $res['code'] = 0;
            $res['data'] = "http://".$filename;
            $res['msg'] = 'success';
        }
        return $res;
    }
}
