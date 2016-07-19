<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Intervention\Image\ImageManager as InterventionImageManager;

class CreateVideoThumbnailCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $src;
    /**
     * @var
     */
    private $thumb;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($src, $thumb)
    {
        $this->src = $src;
        $this->thumb = $thumb;

    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(InterventionImageManager $interventionImageManager)
    {
        // ffmpeg binary path.
        $ffmpeg_WIN = 'C:\ffmpeg\bin\ffmpeg.exe';
        $ffmpeg_SERVER = '/opt/ffmpeg/bin/';

        $output = array();

        $this->src = base_path()."/".$this->src;

        //$this->src="E:/xampp/htdocs/woozard"."/".$this->src;
       $this->thumb = base_path()."/".$this->thumb;
       // $this->thumb="E:/xampp/htdocs/woozard"."/".$this->thumb;

        if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')){
            $cmd = sprintf('%s -i %s -an -ss 00:00:05 -r 1 -vframes 1 -y  %s', $ffmpeg_WIN, $this->src, $this->thumb);
            $cmd = str_replace('/', DIRECTORY_SEPARATOR, $cmd);

        }else{
            $cmd = sprintf('%sffmpeg -i %s -an -ss 00:00:05 -r 1 -vframes 1 -y %s', $ffmpeg_SERVER, $this->src, $this->thumb);
            $cmd = str_replace('\\', DIRECTORY_SEPARATOR, $cmd);
        }


        exec($cmd, $output, $retval);

        $imageIntervention = $interventionImageManager->make($this->thumb);
        $imageIntervention->resize(config('file.image.thumbnail_width'), null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imageIntervention->save($this->thumb, 80);
        if ($retval)
            return false;

        return true;
    }
}
