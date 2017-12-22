<?php

namespace Core\Http\Response;

/**
 * Interface ResponseInterface
 *
 * @package core\Http\Response
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
interface ResponseInterface
{
    public function send();
}
