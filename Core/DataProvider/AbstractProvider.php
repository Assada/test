<?php

namespace Core\DataProvider;

/**
 * Class AbstractProvider
 *
 * @package Core\DataProvider
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
abstract class AbstractProvider
{

    /**
     * @var array
     */
    private $source;

    /**
     * AbstractProvider constructor.
     *
     * @param array $source
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * @param array $source
     *
     * @return void
     */
    public function setSource(array $source)
    {
        $this->source = $source;
    }

    /**
     *
     * @return array
     */
    public function getSource(): array
    {
        return $this->source;
    }
}
