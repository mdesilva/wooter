<?php

namespace Wooter\Wooter\Transformers\Comment;

use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class ImageCommentedTransformer extends Transformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;
    /**
     * @var ImageTransformer
     */
    private $imageTransformer;

    /**
     * @param UserTransformer  $userTransformer
     * @param ImageTransformer $imageTransformer
     */
    public function __construct(UserTransformer $userTransformer, ImageTransformer $imageTransformer)
    {

        $this->userTransformer = $userTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    public function transform($comment)
    {
        return [
            'id' => $comment->id,
            'user' => $this->userTransformer->transform($comment->user),
            'image' => $this->imageTransformer->transform($comment->commented_item),
            'comment' => $comment->comment
        ];
    }
}