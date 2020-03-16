<?php

namespace Vera\JWT\Component\Claim;

class CustomClaim extends BaseClaim
{

    function validate()
    {
        return true;
    }

}
