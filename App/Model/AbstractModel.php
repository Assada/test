<?php

namespace App\Model;

use Core\ArrayableInterface;

/**
 * Class AbstractModel
 *
 * @package App\Model
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
abstract class AbstractModel implements ArrayableInterface
{
    /**
     * @var string Repository class
     */
    protected $repository;

    /**
     * AbstractModel constructor.
     */
    public function __construct()
    {
        $model = substr(strrchr(\get_class($this), "\\"), 1);
        $this->setRepository('App\\Repository\\' . $model . 'Repository');
    }

    /**
     *
     * @return string
     */
    protected function getRepository(): string
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     *
     * @return void
     * @throws \RuntimeException
     */
    protected function setRepository(string $repository)
    {
        if (!class_exists($repository)) {
            throw new \RuntimeException(sprintf('Repository %s not exists', $repository));
        }

        $this->repository = $repository;
    }

    /**
     * @param array|ArrayableInterface $data
     *
     * @return AbstractModel
     */
    public function populate(array $data): AbstractModel
    {
        $data = $data instanceof ArrayableInterface ? $data->toArray() : $data;

        $has = get_object_vars($this);
        foreach ($has as $name => $oldValue) {
            $this->$name = $data[$name] ?? null;
        }

        return $this;
    }

    /**
     *
     * @return array
     */
    abstract public function toArray(): array;
}
