<?php

namespace Core;

use App\Config;
use Core\Exception\HttpException;
use Core\Exception\MethodNotAllowedHttpException;
use Core\Exception\NotFoundHttpException;
use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Http\Response\ResponseInterface;

/**
 * Class Router
 *
 * @package Core
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Router
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param string $route
     * @param array  $params
     *
     * @return void
     */
    public function add(string $route, array $params = [])
    {
        $params = $this->routerParams($params);
        $route  = preg_replace('/\//', '\\/', $route);
        $route  = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route  = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route  = '/^' . $route . '$/i';

        foreach ($params['methods'] as $method) {
            $this->routes[$route][$method] = $params;
        }
    }

    /**
     * @param $params
     *
     * @return array
     */
    protected function routerParams($params): array
    {
        $defaultParams = [
            'controller' => 'Default',
            'action'     => 'index',
            'methods'    => [Request::METHOD_GET],
        ];

        return array_replace($defaultParams, $params);
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $methods) {
            if (preg_match($route, $url, $matches)) {
                foreach ((array)$methods as $method => $params) {
                    $params['data']     = [];
                    $params['security'] = [];
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $params['data'][$key] = $match;
                        }
                    }
                    $secRoutes = array_keys(Config::$security);

                    foreach ($secRoutes as $secRoute) {
                        if (strpos($url, $secRoute) === 0) {
                            $params['security'] = Config::$security[$secRoute];
                        }
                    }

                    $this->params[$method] = $params;
                }

                return true;
            }

        }

        return false;
    }

    /**
     * @param \Core\Http\Request\Request $request
     *
     * @return void
     * @throws \Core\Exception\HttpException
     */
    public function dispatch(Request $request)
    {
        $url    = $request->server->get('REQUEST_URI');
        $url    = $this->getUrlPath($url);
        $method = $request->getMethod();

        if ($this->match($url)) {
            if (!array_key_exists($method, $this->params)) {
                $message = sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $url, implode(', ', array_keys($this->params)));

                throw new MethodNotAllowedHttpException(array_keys($this->params), $message);
            }

            $this->params = $this->params[$method];

            $controller = $this->params['controller'];
            $controller = $this->normilize($controller);
            $controller = $this->getNamespace() . $controller . 'Controller';
            if (class_exists($controller)) {
                $securityClass = $this->params['security'];
                if (count($securityClass) > 0) {
                    $validator      = new Config::$securityValidator();
                    $securityObject = new $securityClass($validator);
                    $securityObject->setRequest($request);
                    $securityObject->execute();
                }


                /** @var \Core\Http\BaseController $controllerObject */
                $controllerObject = new $controller($this->params);
                $controllerObject->setRequest($request);

                $action = $this->params['action'];
                $action = $this->camelize($action);
                $action .= 'Action';

                /** @var \core\Http\Response\ResponseInterface $response */
                $response = call_user_func_array([$controllerObject, $action], $this->params['data']);
                if (!$response instanceof ResponseInterface) {
                    throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, "Controller $controller must return instance of " . ResponseInterface::class . ' class');
                }

                $response->send();
            }
        } else {
            $message = sprintf('No route found for "%s %s"', $request->getMethod(), $url);

            throw new NotFoundHttpException($message);
        }
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function normilize(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function camelize(string $string): string
    {
        return lcfirst($this->normilize($string));
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    protected function getUrlPath(string $url)
    {
        return parse_url($url, PHP_URL_PATH);
    }

    /**
     *
     * @return string
     */
    protected function getNamespace(): string
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
