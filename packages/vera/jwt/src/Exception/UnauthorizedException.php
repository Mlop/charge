<?php

namespace Vera\JWT\Exception;


class UnauthorizedException extends BaseJWTException
{
    public function __construct($message = 'UnauthorizedException')
    {
        parent::__construct($message);
    }
}
