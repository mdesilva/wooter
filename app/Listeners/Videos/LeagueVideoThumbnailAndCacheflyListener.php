<?php

namespace Wooter\Listeners\Videos;

use Wooter\Events\Videos\LeagueVideoThumbnailAndCachefly;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\CreateVideoThumbnailCommand;
use Wooter\Commands\UploadContentToCacheflyCommand;
use Wooter\Commands\Organization\League\UpdateLeagueVideoCacheflySrcAndThumbnailSrcCommand;




class LeagueVideoThumbnailAndCacheflyListener implements ShouldQueue
{
    use InteractsWithQueue;
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeagueVideoThumbnailAndCachefly  $event
     * @return void
     */
    public function handle(LeagueVideoThumbnailAndCachefly $event)
    {

        $leagueVideo = $event->leagueVideo;

        $video = $event->video;
        $organizationId = $event->organization_id;

       $storagePath = config('file.video.upload_path');

        $thumbName = "league_video_".$video->id."_thumb.jpg";
        $thumbPath = $storagePath.$thumbName;

        $videoName = "league_video_".$video->id.".mp4";
        $videoPath = $storagePath.$videoName;

       $this->dispatchFromArray(CreateVideoThumbnailCommand::class, ['src' => $videoPath, 'thumb' => $thumbPath ]);
        $videoAndThumb = $this->dispatchFromArray(UploadContentToCacheflyCommand::class, ['srcDirectory' => $storagePath, 'file' => $videoName, "orgId" => $organizationId, "leagueId" => $leagueVideo->league_id, "uploadThumb"=> true, "thumbFile" => $thumbName]);

       $this->dispatchFromArray(UpdateLeagueVideoCacheflySrcAndThumbnailSrcCommand::class, ['id' => $video->id, 'files' => $videoAndThumb]);

       if(file_exists(base_path()."/".$thumbPath))
       {
           unlink(base_path()."/".$thumbPath);
       }
       if(file_exists(base_path()."/".$videoPath))
       {
           unlink(base_path()."/".$videoPath);
       }

       /* if(file_exists("E:/xampp/htdocs/woozard"."/".$thumbPath))
       {
           unlink("E:/xampp/htdocs/woozard"."/".$thumbPath);
       }
       if(file_exists("E:/xampp/htdocs/woozard"."/".$videoPath))
       {
           unlink("E:/xampp/htdocs/woozard"."/".$videoPath);
       }*/

        $this->delete();

    }
}
