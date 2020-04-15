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
     * 上传文件到public/upload目录
     */
    public function uploadFile(Request $request)
    {
        $saveDir = "/upload";
        $relativeDir = "/public{$saveDir}";
        $savePath = base_path().$relativeDir;
        if (!file_exists($savePath)) {
            mkdir($savePath);
            chmod($savePath, 0666);
        }
        $file=$request->file('file');
        if ($file->isValid()) {
            $dir = $savePath;
            $filename = $file->getBasename()."_".date('Ymd')."_".str_pad(rand(0, 100),3, 0, STR_PAD_LEFT).'.'.$file->guessExtension();
            $file->move($dir, $filename);
            return $request->getSchemeAndHttpHost().$saveDir."/".$filename;
        }
        return "";
    }

    /**
     * 下载Android安装包
     */
    public function downloadApk(Request $request)
    {
        $version = $request->get("v", "1.0");
        return $request->getSchemeAndHttpHost()."/20200415_{$version}.apk";
    }
}
