<?php
/**
 * 账本数据与业务中间层
 * User: Vera
 * Date: 2019/2/13
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function exists($data)
    {
        return Book::where($data)->exists();
    }

    public function create($data)
    {
        return Book::create($data);
    }
}