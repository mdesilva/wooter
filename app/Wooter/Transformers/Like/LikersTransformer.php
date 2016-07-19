<?php

namespace Wooter\Wooter\Transformers\Like;

use Wooter\Wooter\Transformers\ImageTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class LikersTransformer extends Transformer
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

    public function transform($like)
    {
        return [
            'user' => $this->userTransformer->transform($like->user),
        ];
    }
}