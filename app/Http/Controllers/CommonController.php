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
}