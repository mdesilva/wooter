<?php

namespace Wooter\Wooter\Transformers\Comment;

use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class CommentersTransformer extends Transformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @param UserTransformer  $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {

        $this->userTransformer = $userTransformer;
    }

    public function transform($comment)
    {
        return [
            'user' => $this->userTransformer->transform($comment->user),
        ];
    }
}