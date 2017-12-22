<?php

namespace App\Controller;

use App\Model\Post;
use Core\Exception\NotFoundHttpException;
use Core\Http\BaseController;
use Core\Http\Response\JsonResponse;
use Core\Http\Response\Response;

/**
 * Class PostController
 *
 * @package App\Controller
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class PostController extends BaseController
{
    /**
     * @param int $id
     *
     * @return \Core\Http\Response\JsonResponse
     * @throws \Core\Exception\NotFoundHttpException
     */
    public function viewAction(int $id): JsonResponse
    {
        /** @var \App\Repository\PostRepository $postRepository */
        $postRepository = $this->getRepository(Post::class);

        $post = $postRepository->find($id);

        if ($post === null) {
            throw new NotFoundHttpException(sprintf('Post with id: %s not found', $id));
        }

        return new JsonResponse($post->toArray());
    }

    /**
     *
     * @return \Core\Http\Response\JsonResponse
     */
    public function listAction(): JsonResponse
    {
        /** @var \App\Repository\PostRepository $postRepository */
        $postRepository = $this->getRepository(Post::class);

        $posts = $postRepository->all();

        return new JsonResponse($posts->toArray());
    }

    /**
     *
     * @return \Core\Http\Response\JsonResponse
     */
    public function createAction(): JsonResponse
    {
        //TODO: Not Implemented

        return new JsonResponse('', Response::HTTP_CREATED);
    }

    /**
     *
     * @return \Core\Http\Response\JsonResponse
     */
    public function updateAction(): JsonResponse
    {
        //TODO: Not Implemented

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @return \Core\Http\Response\JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        //TODO: Not Implemented

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}
