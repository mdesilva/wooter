<?php

namespace Wooter\Listeners\Photos;

use Wooter\Events\Photos\LeaguePhotoCacheflyEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\UploadContentToCacheflyCommand;
use Intervention\Image\Facades\Image;
use Wooter\Commands\Organization\League\UpdateLeaguePhotoCacheflySrcPathCommand;


class LeaguePhotoCacheflyListener implements ShouldQueue
{
    use InteractsWithQueue;
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeaguePhotoCacheflyEvent  $event
     * @return void
     */
    public function handle(LeaguePhotoCacheflyEvent $event)
    {
        $leaguePhoto = $event->leaguePhoto;

        $image = $event->image;

        $organizationId = $event->organizationId;

        $fileName = "league_photo_".$image->id.".".$image->extension;
        $thumbName = "league_photo_thumbnail_".$image->id.".".$image->extension;

        $storagePath = base_path(config('file.image.upload_path'));

        $photoAndThumb = $this->dispatchFromArray(UploadContentToCacheflyCommand::class, ['srcDirectory' => $storagePath, 'file' => $fileName, "orgId" => $organizationId, "leagueId" => $leaguePhoto->league_id, "uploadPhoto"=> true, "uploadThumb"=> true, "thumbFile" => $thumbName]);

        $this->dispatchFromArray(UpdateLeaguePhotoCacheflySrcPathCommand::class, ['id' => $image->id, 'files' => $photoAndThumb]);

        if(file_exists($image->file_path))
        {
            unlink($image->file_path);
        }
        if(file_exists($image->thumbnail_path))
        {
            unlink($image->thumbnail_path);
        }

        $this->delete();

    }
}
