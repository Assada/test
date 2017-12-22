<?php

namespace Core\Http\Request;

use Core\Conservator;

/**
 * Class Request
 *
 * @package Core\Http\Request
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Request implements RequestInterface
{
    const METHOD_HEAD    = 'HEAD';
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_PURGE   = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE   = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';

    /**
     * $_POST
     *
     * @var Conservator
     */
    public $request;

    /**
     * $_GET
     *
     * @var Conservator
     */
    public $query;

    /**
     * $_SERVER
     *
     * @var Conservator
     */
    public $server;

    /**
     * $_FILES
     *
     * @var Conservator
     */
    public $files;

    /**
     * $_COOKIE
     *
     * @var Conservator
     */
    public $cookies;

    /**
     * $_SERVER
     *
     * @var Conservator
     */
    public $headers;

    /**
     * @var string
     */
    protected $method;

    /**
     * Request constructor.
     *
     * @param array $query
     * @param array $request
     * @param array $cookies
     * @param array $files
     * @param array $server
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $cookies = [],
        array $files = [],
        array $server = []
    )
    {
        $this->query   = new Conservator($query);
        $this->request = new Conservator($request);
        $this->cookies = new Conservator($cookies);
        $this->files   = new Conservator($files);
        $this->server  = new Conservator($server);
        $this->headers = new Conservator($this->getRequestHeaders($server));
    }

    /**
     * @param array $server
     *
     * @return array
     */
    private function getRequestHeaders(array $server): array
    {
        $headers = [];
        foreach ($server as $key => $value) {
            if (0 !== strpos($key, 'HTTP_')) {
                continue;
            }
            $header           = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }

        return $headers;
    }

    /**
     * Create Request instance of Request
     *
     * @return static
     */
    public static function create()
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getMethod(): string
    {
        if (null === $this->method) {
            $this->method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));

            if ('POST' === $this->method) {
                if ($method = $this->headers->get('X-HTTP-METHOD-OVERRIDE')) {
                    $this->method = strtoupper($method);
                }
            }
        }

        return $this->method;
    }

    /**
     * @return Conservator
     */
    public function getRequest(): Conservator
    {
        return $this->request;
    }

    /**
     * @param Conservator $request
     */
    public function setRequest(Conservator $request)
    {
        $this->request = $request;
    }

    /**
     * @return Conservator
     */
    public function getQuery(): Conservator
    {
        return $this->query;
    }

    /**
     * @param Conservator $query
     */
    public function setQuery(Conservator $query)
    {
        $this->query = $query;
    }

    /**
     * @return Conservator
     */
    public function getServer(): Conservator
    {
        return $this->server;
    }

    /**
     * @param Conservator $server
     */
    public function setServer(Conservator $server)
    {
        $this->server = $server;
    }

    /**
     * @return Conservator
     */
    public function getFiles(): Conservator
    {
        return $this->files;
    }

    /**
     * @param Conservator $files
     */
    public function setFiles(Conservator $files)
    {
        $this->files = $files;
    }

    /**
     * @return Conservator
     */
    public function getCookies(): Conservator
    {
        return $this->cookies;
    }

    /**
     * @param Conservator $cookies
     */
    public function setCookies(Conservator $cookies)
    {
        $this->cookies = $cookies;
    }


}
