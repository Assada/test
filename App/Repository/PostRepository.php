<?php

namespace App\Repository;

use Core\Conservator;
use Core\DataProvider\JsonDataProvider;

/**
 * Class PostRepository
 *
 * @package App\Repository
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class PostRepository extends AbstractRepository
{
    /** @var \Core\DataProvider\JsonDataProvider */
    private $provider;

    /**
     * PostRepository constructor.
     *
     * @param array $source
     */
    public function __construct(array $source)
    {
        parent::__construct($source);

        $this->provider = new JsonDataProvider($this->getSource());
    }

    /**
     * Get Post by id
     *
     * @param int $id Post id
     *
     * @return \App\Model\AbstractModel|null
     */
    public function find(int $id)
    {
        $data = $this->provider->getData();

        return array_key_exists($id, $data) ? $this->getModel()->populate($data[$id]) : null;
    }

    /**
     * Get all posts
     *
     * @return \Core\Conservator
     */
    public function all(): Conservator
    {
        $data = $this->provider->getData();

        $return = new Conservator();

        foreach ((array)$data as $datum) {
            $return->add($this->getModel()->populate($datum));
        }

        return $return;
    }

    /**
     * Delete post by id
     *
     * @param int $id Post id
     *
     * @return void
     */
    public function delete(int $id)
    {
        //TODO: Not implemented
    }

    /**
     * Update by id or Add new post
     *
     * @param null $id
     *
     * @return void
     */
    public function save($id = null)
    {
        //TODO: Not implemented
    }
}
