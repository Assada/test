<?php

namespace Core\Exception;

/**
 * Class MethodNotAllowedHttpException
 *
 * @package core\Exception
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class MethodNotAllowedHttpException extends HttpException
{
    /**
     * @param array      $allow    Array of allowed methods
     * @param string     $message  Exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     Exception code
     */
    public function __construct(array $allow, $message = null, \Exception $previous = null, $code = 0)
    {
        $headers = ['Allow' => strtoupper(implode(', ', $allow))];

        parent::__construct(405, $message, $previous, $headers, $code);
    }
}
