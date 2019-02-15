<?php
/**
 * 分类增、删、改
 * User: Vera
 * Date: 2019/2/13
 * Time: 17:14
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $catRep;

    public function __construct(CategoryRepository $catRep)
    {
        $this->catRep = $catRep;
    }

    public function get(Request $request)
    {
        $type = $request->input('type', CategoryRepository::TYPE_IN);
        $parent_id = $request->input('parent_id', 0);
        $list = $this->catRep->get($type, $parent_id);
        foreach ($list as $i => $cat) {
            $list[$i]['total'] = $this->catRep->count($type, $cat->id);
        }
        return $list;
    }
}