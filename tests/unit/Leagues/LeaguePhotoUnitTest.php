<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Intervention\Image\ImageManager as InterventionImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Wooter\Commands\Organization\League\CreateLeaguePhotoCommand;
use Wooter\Commands\Organization\League\UpdateLeaguePhotoCommand;
use Wooter\Image as ImageModel;
use Wooter\LeagueOrganization;
use Wooter\LeaguePhoto;
use Wooter\Organization;
use Wooter\User;
use Wooter\Wooter\Repositories\ImageRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class LeaguePhotoUnitTest extends TestCase
{
    use DispatchesJobs;

    protected $leagueRepository;
    protected $league;
    protected $user;
    protected $image;
    protected $organization;
    protected $imageModel;
    protected $imageRepository;
    protected $leaguePhotoRepository;
    protected $leaguePhoto;
    protected $photo;
    protected $photoModel;
    protected $imageUploaded;
    protected $interventionImageManager;
    protected $interventionImageModel;

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function check_create_league_photo_command()
    {
        $this->markTestIncomplete();
        $this->leagueRepository = $this->mock(LeagueRepository::class);
        $this->imageRepository = $this->mock(ImageRepository::class);
        $this->leaguePhotoRepository = $this->mock(LeaguePhotoRepository::class);
        $this->league = $this->mock(LeagueOrganization::class);
        $this->user = $this->mock(User::class);
        $this->image = $this->mock(UploadedFile::class);

        $leagueId = $this->faker->numberBetween(1);
        $userId = $this->faker->numberBetween(1);
        $imageName = $this->faker->name;
        $imageMimeType = $this->faker->mimeType;
        $imagePath = $this->faker->imageUrl();
        $imageExtension = 'jpeg';

        $this->user->shouldReceive('getAttribute')->with('id')->once()->andReturn($userId);
        $this->league->shouldReceive('getAttribute')->with('organization')->once()->andReturn($this->organization);

        $this->imageRepository->shouldReceive('create')->once()->andReturn(true);
        $this->imageRepository->shouldReceive('update')->once()->andReturn(true);
        $this->leaguePhotoRepository->shouldReceive('create')->once()->andReturn(true);
        $this->image->shouldReceive('move')->once()->andReturn(true);
        $this->image->shouldReceive('getPathname')->once()->andReturn($imagePath);
        $this->image->shouldReceive('getClientMimeType')->once()->andReturn($imageMimeType);
        $this->image->shouldReceive('getClientOriginalName')->once()->andReturn($imageName);
        $this->image->shouldReceive('getExtension')->times(3)->andReturn($imageExtension);
        $this->image->shouldReceive('getClientSize')->times(2)->andReturn(10000);
        $this->image->shouldReceive('isValid')->andReturn(true);
        $this->leagueRepository->shouldReceive('getFromId')->with($leagueId)->once()->andReturn($this->league);

        $request = [
            'league_id' => $leagueId,
            'description' => $this->faker->paragraph(),
            'user_id' => $userId,
            'photo' => $this->image
        ];

        $leaguePhoto = $this->dispatchFromArray(CreateLeaguePhotoCommand::class, $request);
    }

    /**
     * @test
     */
    public function check_update_league_photo_command()
    {
        $this->markTestIncomplete();
        $this->imageRepository = $this->mock(ImageRepository::class);
        $this->leaguePhotoRepository = $this->mock(LeaguePhotoRepository::class);
        $this->league = $this->mock(LeagueOrganization::class);
        $this->user = $this->mock(User::class);
        $this->imageUploaded = $this->mock(UploadedFile::class);
        $this->organization = $this->mock(Organization::class);
        $this->leaguePhoto = $this->mock(LeaguePhoto::class);
        $this->photoModel = $this->mock(ImageModel::class);
        $this->interventionImageManager = $this->mock(InterventionImageManager::class);

        $leaguePhotoId = $this->faker->numberBetween(1);
        $userId = $this->faker->numberBetween(1);
        $imageId = $this->faker->numberBetween(1);
        $imageName = $this->faker->name;
        $imageMimeType = $this->faker->mimeType;
        $imagePath = $this->faker->imageUrl();
        $imageExtension = 'jpeg';

        $this->interventionImageManager->shouldReceive('save');
        $this->interventionImageManager->shouldReceive('resize');
        $this->interventionImageManager->shouldReceive('make')->once()->andReturn($this->interventionImageManager);
        $this->user->shouldReceive('getAttribute')->with('id')->once()->andReturn($userId);
        $this->organization->shouldReceive('getAttribute')->with('user')->once()->andReturn($this->user);
        $this->league->shouldReceive('getAttribute')->with('organization')->once()->andReturn($this->organization);
        $this->photoModel->shouldReceive('getAttribute')->with('id')->times(3)->andReturn($imageId);
        $this->photoModel->shouldReceive('getAttribute')->with('file_path')->once()->andReturn('path');
        $this->photoModel->shouldReceive('getAttribute')->with('thumbnail_path')->once()->andReturn('path');
        $this->photoModel->shouldReceive('setAttribute');
        $this->leaguePhoto->shouldReceive('fresh');
        $this->leaguePhoto->shouldReceive('getAttribute')->with('league')->once()->andReturn($this->league);
        $this->leaguePhoto->shouldReceive('getAttribute')->with('photo')->once()->andReturn($this->photoModel);
        $this->imageRepository->shouldReceive('update')->once()->andReturn(true);
        $this->leaguePhotoRepository->shouldReceive('getFromId')->with($leaguePhotoId)->once()->andReturn($this->leaguePhoto);
        $this->imageUploaded->shouldReceive('move')->once()->andReturn(true);
        $this->imageUploaded->shouldReceive('getPathname')->once()->andReturn($imagePath);
        $this->imageUploaded->shouldReceive('getClientMimeType')->once()->andReturn($imageMimeType);
        $this->imageUploaded->shouldReceive('getClientOriginalName')->once()->andReturn($imageName);
        $this->imageUploaded->shouldReceive('getExtension')->times(3)->andReturn($imageExtension);
        $this->imageUploaded->shouldReceive('getClientSize')->times(2)->andReturn(10000);
        $this->imageUploaded->shouldReceive('isValid')->andReturn(true);
        $this->imageUploaded->shouldReceive('getAttribute')->andReturn($imageId);
        $this->imageRepository->shouldReceive('getFromId')->andReturn($this->photoModel);



        $request = [
            'league_photo_id' => $leaguePhotoId,
            'description' => $this->faker->paragraph(),
            'user_id' => $userId,
            'photo' => $this->imageUploaded
        ];

        $leaguePhoto = $this->dispatchFromArray(UpdateLeaguePhotoCommand::class, $request);
    }
}
