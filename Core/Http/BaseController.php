<?php

namespace Core\Http;

use App\Config;
use Core\Http\Request\RequestInterface;

/**
 * Class BaseController
 *
 * @package core\Http
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class BaseController
{
    protected $request;

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getRepository(string $modelName)
    {
        $shortModelName = (string)substr(strrchr($modelName, "\\"), 1);
        $repositoryName = 'App\\Repository\\' . $shortModelName . 'Repository';

        if (!class_exists($repositoryName)) {
            throw new \RuntimeException(sprintf('Repository %s not exists', $repositoryName));
        }

        return new $repositoryName(Config::$dataSources[$modelName]);
    }

}
