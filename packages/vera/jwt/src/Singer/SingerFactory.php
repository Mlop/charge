<?php

namespace Vera\JWT\Singer;


use InvalidArgumentException;
use Vera\JWT\Contracts\ISign;

class SingerFactory
{
    /**
     * 根据算法Id创建一个签名者
     * @param $algorithmId
     * @return ISign
     * @throws InvalidArgumentException
     */
    public static function createByAlgorithmId($algorithmId)
    {
        if (starts_with($algorithmId, 'H')) {
            return self::createHMACSigner($algorithmId);
        } elseif (starts_with($algorithmId, 'R')) {
            return self::createRsaSigner($algorithmId);
        }

        throw new InvalidArgumentException(
            "$algorithmId is not be supported,the supported algorithm list is: "
            . implode(',', HMAC::getSupportAlgorithmIds())
            . ","
            . implode(',', RSA::getSupportAlgorithmIds())
        );
    }

    /**
     * 创建一个HMAC签名者
     * @param $algorithmId
     * @return HMAC
     */
    public static function createHMACSigner($algorithmId)
    {
        return new HMAC($algorithmId);
    }

    /**
     * 创建一个RSA签名者
     * @param $algorithmId
     * @return RSA
     */
    public static function createRsaSigner($algorithmId)
    {
        return new RSA($algorithmId);
    }
}
