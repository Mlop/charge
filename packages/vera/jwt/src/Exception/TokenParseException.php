<?php

namespace Vera\JWT\Exception;

class TokenParseException extends BaseJWTException
{
    public function __construct($message = 'TokenParseException')
    {
        parent::__construct($message);
    }
}
