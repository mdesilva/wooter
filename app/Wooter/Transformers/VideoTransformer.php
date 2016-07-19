<?php

namespace Wooter\Wooter\Transformers;

class VideoTransformer extends Transformer
{
    public function transform($video)
    {
        return [
            'id' => $video->id,
            'description' => $video->description,
            'mime_type' => $video->mime_type,
            'extension' => $video->extension,
            'size' => $video->size,
            'file_path' => $video->file_path,
            'thumbnail_path' => $video->thumbnail_path,
            'type' => $video->type,
            'file_name' => $video->file_name,
        ];
    }
}