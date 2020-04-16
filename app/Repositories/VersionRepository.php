<?php
/**
 * 版本管理.
 * User: Vera.Zhang
 * Date: 2020/4/16
 * Time: 10:00
 */
namespace App\Repositories;

use App\Models\Version;

class VersionRepository
{
    public function exists($data)
    {
        return Version::where($data)->exists();
    }
    public function get($id)
    {
        return Version::find($id);
    }
    public function edit($id, $params)
    {
        return $this->get($id)->update($params);
    }

    public function add($params)
    {
        return Version::create($params);
    }
    public function getList()
    {
        return Version::get();
    }
    public function delete($id)
    {
        return $this->get($id)->delete();
    }

    /**
     * 获取最新版本记录
     */
    public function getLatest()
    {
        return Version::orderBy("version", "desc")->select("version", "download_uri")->first();
    }
}
