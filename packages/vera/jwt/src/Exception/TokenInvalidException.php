<?php

namespace Vera\JWT\Exception;

class TokenInvalidException extends BaseJWTException
{
    public function __construct($message = 'TokenInvalidException')
    {
        parent::__construct($message);
    }
}
