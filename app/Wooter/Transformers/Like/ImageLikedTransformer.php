<?php

namespace Wooter\Wooter\Transformers\Like;

use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class ImageLikedTransformer extends Transformer
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

    public function transform($like)
    {
        return [
            'id' => $like->id,
            'user' => $this->userTransformer->transform($like->user),
            'image' => $this->imageTransformer->transform($like->liked_item),
            'liked' => $like->liked
        ];
    }
}