<?php

namespace App\Service\Auth;


/**
 * Interface ValidatorInterface
 *
 * @package App\Service\Auth
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
interface ValidatorInterface
{
    public function validate(string $token);
}