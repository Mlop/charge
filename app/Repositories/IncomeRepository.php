<?php
/**
 * 收入数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Income;

class IncomeRepository
{
    public function exists($data)
    {
        return Income::where($data)->exists();
    }

    public function create($data)
    {
        return Income::create($data);
    }
}