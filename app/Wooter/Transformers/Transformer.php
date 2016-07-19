<?php

namespace Wooter\Wooter\Transformers;

use ArrayAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Transformer
{

    /**
     * @param Collection $items
     *
     * @return array
     */
    final public function transformCollection($items)
    {

        $transformedItems = [];

        foreach ($items as $item) {
            $transformedItems[] = $this->transform($item);
        }

        return $transformedItems;
    }

    /**
     * @param $item
     *
     * @return mixed
     */
    abstract public function transform($item);

}