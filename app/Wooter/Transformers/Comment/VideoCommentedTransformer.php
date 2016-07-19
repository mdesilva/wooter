<?php

namespace Wooter\Wooter\Transformers\Comment;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;
use Wooter\Wooter\Transformers\VideoTransformer;

class VideoCommentedTransformer extends Transformer
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

    public function transform($comment)
    {
        return [
            'id' => $comment->id,
            'user' => $this->userTransformer->transform($comment->user),
            'video' => $this->videoTransformer->transform($comment->commented_item),
            'comment' => $comment->comment
        ];
    }
}