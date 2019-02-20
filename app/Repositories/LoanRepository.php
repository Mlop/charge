<?php
/**
 * 借贷数据与业务中间层
 * User: Vera
 * Date: 2019/2/20
 * Time: 22:51
 */
namespace App\Repositories;

use App\Models\Loan;

class LoanRepository
{
    public function exists($data)
    {
        return Loan::where($data)->exists();
    }
    public function get($id)
    {
        return Loan::find($id);
    }
    public function create($data)
    {
        return Loan::create($data);
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
        return $item->setRawAttributes($params)->save();
    }
}