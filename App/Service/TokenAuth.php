<?php

namespace App\Service;

use App\Service\Auth\ValidatorInterface;
use Core\Exception\HttpException;
use Core\Http\Request\RequestInterface;
use Core\Http\Response\Response;

/**
 * Class TokenAuth
 *
 * @package App\Service
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class TokenAuth
{
    /**
     * @var \App\Service\Auth\ValidatorInterface
     */
    private $tokenValidator;

    /**
     * TokenAuth constructor.
     *
     * @param \App\Service\Auth\ValidatorInterface $tokenValidator
     */
    public function __construct(ValidatorInterface $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
    }

    /**
     * @var \Core\Http\Request\RequestInterface
     */
    private $request;

    /**
     * Execute validation
     *
     * @return void
     * @throws \Core\Exception\HttpException
     */
    public function execute()
    {
        $token = $this->request->getQuery()->get('token');

        if ($token === null) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED);
        }

        if (!$this->tokenValidator->validate($token)) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'Token not valid or expired');
        }
    }

    /**
     * @param \Core\Http\Request\RequestInterface $request
     *
     * @return void
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }
}
