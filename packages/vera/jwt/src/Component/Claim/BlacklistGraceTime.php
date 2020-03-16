<?php

namespace Vera\JWT\Component\Claim;

/**
 * 记录刷新次数
 * Class RefreshCount
 * @package Vera\JWT\Component\Claim
 */
class BlacklistGraceTime extends BaseClaim
{
    public function __construct($value)
    {
        parent::__construct("blgt", $value);
    }

    function validate()
    {
        return is_int($this->getValue()) && $this->getValue() >= 0;
    }
}
