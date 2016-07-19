<?php

namespace Wooter\Wooter\Transformers\Like;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;
use Wooter\Wooter\Transformers\VideoTransformer;

class VideoLikedTransformer extends Transformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;
    /**
     * @var VideoTransformer
     */
    private $videoTransformer;

    /**
     * @param UserTransformer  $userTransformer
     * @param VideoTransformer $videoTransformer
     */
    public function __construct(UserTransformer $userTransformer, VideoTransformer $videoTransformer)
    {

        $this->userTransformer = $userTransformer;
        $this->videoTransformer = $videoTransformer;
    }

    public function transform($like)
    {
        return [
            'id' => $like->id,
            'user' => $this->userTransformer->transform($like->user),
            'video' => $this->videoTransformer->transform($like->liked_item),
            'liked' => $like->liked
        ];
    }
}