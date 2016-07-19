<?php

namespace Wooter\Commands;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\ImageManager as InterventionImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Image as ImageModel;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\ImageTooBigException;
use Wooter\Wooter\Repositories\ImageRepository;

class DeleteImageCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $imageId;

    /**
     * @param $image_id
     */
    public function __construct($image_id) {
        $this->imageId = $image_id;
    }

    /**
     * Execute the command.
     *
     * @param ImageRepository          $imageRepository
     *
     * @return ImageModel
     * @throws DatabaseException
     * @throws Exception
     * @throws ImageTooBigException
     */
    public function handle(ImageRepository $imageRepository)
    {
        $image = $imageRepository->getById($this->imageId);

        if ( ! $image) {
            throw new ImageNotFound;
        }

        try {
            @unlink(base_path('public/'.$image->file_path));
            @unlink(base_path('public/'.$image->thumbnail_path));
        } catch (Exception $e){}

        $image->delete();

        return true;
    }
}
