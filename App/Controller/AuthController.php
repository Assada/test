<?php

namespace App\Controller;

use App\Service\CredentialsChecker;
use Core\Exception\HttpException;
use Core\Http\BaseController;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\Response;

/**
 * Class AuthController
 *
 * @package App\Controller
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class AuthController extends BaseController
{
    /**
     *
     * @return \Core\Http\Response\JsonResponse
     * @throws \Core\Exception\HttpException
     */
    public function tokenAction(): JsonResponse
    {
        $data = $this->getRequest()->getRequest()->all();

        if (array_key_exists('login', $data) && array_key_exists('password', $data)) {
            $credentialsChecker = new CredentialsChecker($data['login'], $data['password']);
            $credentialsChecker->execute();

            if ($credentialsChecker->isValid()) {
                return new JsonResponse(['token' => md5(mt_rand()), 'expire' => 3600]);
            }
        }

        throw new HttpException(Response::HTTP_FORBIDDEN, 'Not valid credentials');
    }
}
