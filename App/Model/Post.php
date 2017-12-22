<?php

namespace App\Model;

/**
 * Class Post
 *
 * @package App\Model
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Post extends AbstractModel
{
    /** @var int */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }
}
