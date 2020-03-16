<?php
namespace App\Models;

use Vera\JWT\Contracts\IClaimProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;

//实现IClaimProvider接口
class Customer extends Model implements AuthenticatableContract,AuthorizableContract,IClaimProvider
{
    use Authenticatable, Authorizable;
    protected $table = 'customer';
    //...

    //Token中身份标识,一般设置为user id 即可
    public function getIdentifier()
    {
        return $this->id;
    }

    //自定义的claims,无法覆盖预定义的claims
    public function getCustomClaims()
    {
        //['name'=>'value','author'=>'lsxiao'] 必须是键值对形式
        return [];
    }
}
