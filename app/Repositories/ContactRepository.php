<?php
/**
 * 账目联系人
 * User: Vera
 * Date: 2020/2/22
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Contact;
use Carbon\Carbon;

class ContactRepository
{
    public function exists($data)
    {
        return Contact::where($data)->exists();
    }

    public function get($id)
    {
        return Contact::find($id);
    }
    public function create($data)
    {
        return Contact::create($data);
    }

    public function delete($id)
    {
        return $this->get($id)->delete();
    }

    public function edit($id, $params)
    {
        $item = $this->get($id);
        if (!$item) {
            return false;
        }
		return $item->update($params);
    }

    public function builder($cond)
    {
        return Contact::where($cond);
    }

    /**
     * 创建不存在的用户名称，存在则跳过
     * @param $data
     */
    public function createNotExists($data)
    {
        if (!$this->exists($data)) {
            return $this->create($data);
        }
        return false;
    }
}