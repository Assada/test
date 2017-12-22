<?php

namespace Core;

/**
 * Class Conservator
 *
 * @package Core
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Conservator implements \IteratorAggregate, \Countable
{

    /**
     * @var array
     */
    protected $items;

    /**
     * @param array $items Array of items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @param $item
     *
     * @return void
     */
    public function add($item): void
    {
        $this->items[] = $item;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->items) ? $this->items[$key] : $default;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return void
     */
    public function set($key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @param $key
     *
     * @return void
     */
    public function remove($key): void
    {
        unset($this->items[$key]);
    }

    /**
     *
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($value) {
            return $value instanceof ArrayableInterface ? $value->toArray() : $value;

        }, $this->items);
    }
}
