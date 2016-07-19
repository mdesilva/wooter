<?php

namespace Wooter\Commands;

use Exception;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\ImageManager as InterventionImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Image as ImageModel;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\ImageTooBigException;
use Wooter\Wooter\Repositories\ImageRepository;

class CreateImageCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $image;
    /**
     * @var null
     */
    private $description;
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var
     */
    private $fromCreate;

    /**
     * Create a new command instance.
     *
     * @param UploadedFile $image
     * @param string       $prefix
     *
     * @param null         $description
     * @param bool         $fromCreate
     *
     * @internal param null $description
     */
    public function __construct(UploadedFile $image, $prefix = '', $description = null, $fromCreate = false) {
        $this->image = $image;
        $this->description = $description;
        $this->prefix = $prefix;
        $this->fromCreate = $fromCreate;
    }

    /**
     * Execute the command.
     *
     * @param ImageRepository          $imageRepository
     *
     * @param InterventionImageManager $interventionImageManager
     *
     * @return ImageModel
     * @throws DatabaseException
     * @throws Exception
     * @throws ImageTooBigException
     */
    public function handle(ImageRepository $imageRepository, InterventionImageManager $interventionImageManager)
    {
        $storePath = config('file.image.upload_path');
        $visiblePath = config('file.image.visible_path');

        if ( ! $this->image->isValid()) {
            throw new Exception('The image uploaded is not valid');
        }

        if (config('file.image.max_size') * config('file.megabyte') < $this->image->getClientSize()) {
            throw new ImageTooBigException('Too big image size, max size allowed: ' . config('file.image.max_size') . ' MB');
        }

        $image = new ImageModel;

        if ( ! $imageRepository->create($image)) {
            throw new DatabaseException('Error creating the Image record');
        }

        $fileName = $this->prefix . $image->id . '.' . $this->image->getClientOriginalExtension();
        $image->file_path = $visiblePath . $fileName;
        $image->file_name = $this->image->getClientOriginalName();
        $image->mime_type = $this->image->getClientMimeType();
        $image->extension = $this->image->getClientOriginalExtension();
        $image->size = $this->image->getClientSize();
        $image->description = $this->description;

        // Create and store the Thumbnail using the Intervention Package
        $thumbnail = $this->prefix . 'thumbnail_' . $image->id . '.' . $this->image->getClientOriginalExtension();
        $imageIntervention = $interventionImageManager->make($this->image->getPathname());
        $imageIntervention->resize(config('file.image.thumbnail_width'), null, function ($constraint) {
            $constraint->aspectRatio();
        });



        $imageIntervention->save( base_path($storePath . $thumbnail) , 80);
        $image->thumbnail_path = $visiblePath . $thumbnail;
        $this->image->move(base_path($storePath), $fileName, 80);

        if ( ! $imageRepository->update($image)) {
            throw new DatabaseException('Error saving the Image record');
        }

        return $image;
    }
}
