<?php

namespace App\Repository;

use App\Model\AbstractModel;

/**
 * Class AbstractRepository
 *
 * @package App\Repository
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
abstract class AbstractRepository
{
    /**
     * @var array Data source configuration
     */
    private $source;

    /**
     * AbstractRepository constructor.
     *
     * @param array $source Data source configuration
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * @return array
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * @param array $source Data source configuration
     */
    public function setSource(array $source)
    {
        $this->source = $source;
    }

    /**
     *
     * @return string
     */
    public function getModelName(): string
    {
        return str_replace('Repository', '', substr(strrchr(\get_class($this), "\\"), 1));
    }

    /**
     *
     * @return \App\Model\AbstractModel
     */
    public function getModel(): AbstractModel
    {
        $model = 'App\\Model\\' . $this->getModelName();

        return new $model();
    }
}
