<?php

namespace Wooter\Wooter\Transformers;

class ImageTransformer extends Transformer
{
    public function transform($image)
    {
        return [
            'id' => $image->id,
            'description' => $image->description,
            'mime_type' => $image->mime_type,
            'extension' => $image->extension,
            'size' => $image->size,
            'file_path' => $image->file_path,
            'thumbnail_path' => $image->thumbnail_path,
            'file_name' => $image->file_name,
        ];
    }
}