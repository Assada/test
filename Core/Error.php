<?php


namespace Core;

use App\Config;
use Core\Exception\HttpException;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\Response;

/**
 * Class Error
 *
 * @package Core
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Error
{
    /**
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     *
     * @return void
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    public static function exceptionHandler($e)
    {
        $response = new JsonResponse();

        $code    = $e->getCode();
        $message = $e->getMessage();

        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            if (array_key_exists($code, Response::$statusTexts) && $e->getMessage() === '') {
                $message = Response::$statusTexts[$code];
            }

            $response->addHeaders($e->getHeaders());
        }

        if ($code === 0) {
            $code = 500;
        }

        $error = [
            'code'    => $code,
            'message' => $message,
        ];

        if (Config::DEBUG) {
            $error['file']  = $e->getFile() . ': ' . $e->getLine();
            $error['trace'] = $e->getTraceAsString();
        }


        $response->setJson($error);
        $response->setStatusCode($code);
        $response->send();
    }
}
