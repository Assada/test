<?php

namespace Core\Exception;

use Core\Http\Response\Response;

/**
 * Class NotFoundHttpException
 *
 * @package core\Exception
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class NotFoundHttpException extends HttpException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message, $previous, [], $code);
    }
}
