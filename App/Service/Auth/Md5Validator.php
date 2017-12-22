<?php

namespace App\Service\Auth;

/**
 * Class Md5Validator
 *
 * @package App\Service\Auth
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Md5Validator implements ValidatorInterface
{
    /**
     * @param string $token
     *
     * @return bool
     */
    public function validate(string $token): bool
    {
        return strlen($token) === 32;
    }
}
