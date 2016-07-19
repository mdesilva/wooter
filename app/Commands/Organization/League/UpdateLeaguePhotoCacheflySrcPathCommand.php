<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\ImageRepository;

class UpdateLeaguePhotoCacheflySrcPathCommand extends Command implements SelfHandling
{
    private $imageId;
    private $data = array();
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($id, $files )
    {
        $this->imageId = $id;
        $this->data = $files;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(ImageRepository $imageRepository)
    {
        $image = $imageRepository->getById($this->imageId);

        $image->file_path = $this->data["file_path"];
        $image->thumbnail_path = $this->data["thumbnail_path"];

        $imageRepository->update($image);

        return;
    }
}
