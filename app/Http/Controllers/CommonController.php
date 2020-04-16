<?php
/**
 * 公共数据
 * @author Vera
 * @date 2020-02-22 11:15
 */
namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use App\Repositories\VersionRepository;
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
     * 创建目录，赋值权限rw-rw-rw-
     * @param $dir
     */
    private function makeDir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
            chmod($dir, 0666);
        }
    }
    /**
     * 上传文件到public/upload目录
     */
    public function uploadFile(Request $request)
    {
        $saveDir = "/upload";
        $relativeDir = "/public{$saveDir}";
        $savePath = base_path().$relativeDir;
        $this->makeDir($savePath);
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
     * 获取最新版本及下载地址
     * @param Request $request
     * @return array
     */
    public function getLatestVersion(Request $request)
    {
        $versionRep = new VersionRepository();
        $latest = $versionRep->getLatest();
        $match = [];
        preg_match("/_(.*)\./", $latest['download_uri'], $match);
        return [
            "version" => (count($match) == 2) ? $match[1] : $latest['version'],
            "url" => $request->getSchemeAndHttpHost().$latest['download_uri'],
        ];
    }
    /**
     * 下载Android安装包
     * @deprecated
     */
    public function downloadApk(Request $request)
    {
        $version = $request->get("v", "1.0.1");
        return $request->getSchemeAndHttpHost()."/apk/20200415_{$version}.apk";
    }
}
