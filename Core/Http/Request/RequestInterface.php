<?php
/**
 * Description RequestInterface.php
 *
 * @author Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */

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
interface RequestInterface
{
    /**
     * Create Request instance of Request
     *
     * @return static
     */
    public static function create();

    /**
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return Conservator
     */
    public function getRequest(): Conservator;

    /**
     * @param Conservator $request
     */
    public function setRequest(Conservator $request);

    /**
     * @return Conservator
     */
    public function getQuery(): Conservator;

    /**
     * @param Conservator $query
     */
    public function setQuery(Conservator $query);

    /**
     * @return Conservator
     */
    public function getServer(): Conservator;

    /**
     * @param Conservator $server
     */
    public function setServer(Conservator $server);

    /**
     * @return Conservator
     */
    public function getFiles(): Conservator;

    /**
     * @param Conservator $files
     */
    public function setFiles(Conservator $files);

    /**
     * @return Conservator
     */
    public function getCookies(): Conservator;

    /**
     * @param Conservator $cookies
     */
    public function setCookies(Conservator $cookies);
}