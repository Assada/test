<?php

namespace App;

use App\Model\Post;
use App\Service\Auth\Md5Validator;
use App\Service\TokenAuth;

/**
 * Class Config
 *
 * @package App
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class Config
{
    const DEBUG = false;

    /**
     * @var array Routes auth politics
     */
    public static $security = [
        '/posts' => TokenAuth::class,
    ];

    /**
     * @var string Security validator
     */
    public static $securityValidator = Md5Validator::class;

    /**
     * @var array Data sources for models
     */
    public static $dataSources = [
        Post::class => [
            'path' => __DIR__ . '/../data/Post.json',
        ],
    ];
}
