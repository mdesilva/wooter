<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Likes\LikeCommand;
use Wooter\Commands\Likes\ReadLikesCommand;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Like\LikeRequest;
use Wooter\Image;
use Wooter\Video;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\UserNotMemberException;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Transformers\Like\ImageLikedTransformer;
use Wooter\Wooter\Transformers\Like\LikersTransformer;
use Wooter\Wooter\Transformers\Like\VideoLikedTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;

final class LikesController extends ApiController
{
    /**
     * @var ImageLikedTransformer
     */
    private $imageLikedTransformer;
    /**
     * @var VideoLikedTransformer
     */
    private $videoLikedTransformer;
    /**
     * @var LikersTransformer
     */
    private $likersTransformer;

    /**
     * @param ImageLikedTransformer $imageLikedTransformer
     * @param LikersTransformer     $likersTransformer
     * @param VideoLikedTransformer $videoLikedTransformer
     *
     */
    public function __construct(ImageLikedTransformer $imageLikedTransformer,
                                LikersTransformer $likersTransformer,
                                VideoLikedTransformer $videoLikedTransformer) {

        $this->middleware('jwt.auth');

        $this->imageLikedTransformer = $imageLikedTransformer;
        $this->videoLikedTransformer = $videoLikedTransformer;
        $this->likersTransformer = $likersTransformer;
    }

    /**
     * @api               {get} api/likes/:itemId Like/Unlike
     * @apiVersion        1.0.0
     * @apiName           Like/Unlike
     * @apiGroup          Likes
     * @apiPermission     Requires JWT
     * @apiDescription    Likes or Unlikes an item
     *
     * @apiParam {Number} liked_item_id ID of the item
     * @apiParam {Number} liked_item_id Type of the item
     * @apiParam {Boolean} liked Where to like or unlike the item
     *
     * @apiSuccessExample Success:
     *     HTTP/1.1 200 OK
     *     {
     *          'data' =>
     *          [
     *              'id' => '6',
     *              'sport' => $sportObject,
     *              'captain' => $userObject,
     *              'logo' => $imageObject,
     *              'cover_photo' => $imageObject,
     *              'players' => $collectionOfUsers,
     *              'division' => $divisionObject,
     *              'name' => 'Real Madrid',
     *              'description' => 'Team of Madrid, Spain',
     *              'wins' => 20,
     *              'loss' => 15,
     *              'ties' => 5,
     *              'played' => 40,
     *          ]
     *     }
     *
     * @apiUse            UserNotFound
     * @apiUse            NotPermissionException
     *
     * @param LikeRequest $request
     * @param $likedItemId
     *
     * @return JsonResponse
     */
    public function store(LikeRequest $request, $likedItemId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $likedItem = $this->dispatchFrom(LikeCommand::class, $request, ['user_id' => $user->id, 'liked_item_id' => $likedItemId]);

            switch ($request->get('liked_item_type')) {
                case Image::class:
                    return $this->respond([
                        'data' => $this->imageLikedTransformer->transform($likedItem)
                    ]);

                case Video::class:
                    return $this->respond([
                        'data' => $this->videoLikedTransformer->transform($likedItem)
                    ]);
            }

        } catch (ImageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(VideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotMemberException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * @api               {get} api/likes/:itemId?options ReadLike
     * @apiVersion        1.0.0
     * @apiName           ReadLike
     * @apiGroup          Likes
     * @apiDescription    Get the likes information
     *
     * @apiParam {String} type Type of the item, a Wooter-like class (  Wooter\Video )
     * @apiParam {Boolean} [by_me] Check if the current user likes the item
     * @apiParam {Boolean} [total_count] Returns the number of likes for that item
     * @apiParam {Boolean} offset Offset to return total likers
     * @apiParam {Boolean} limit Limit to return total likers
     *
     * @apiUse            UserNotFound
     *
     * @param $likedItemId

     * @return JsonResponse
     */
    public function show($likedItemId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $like = $this->dispatchFrom(ReadLikesCommand::class, new RequestObject(Request::all()), ['liked_item_id' => $likedItemId, 'user_id' => $user->id]);

            if (is_bool($like)) {
                return $this->respond([
                    'data' => [
                        'liked' => $like
                        ]
                ]);
            }

            if (is_numeric($like)) {
                return $this->respond([
                    'data' => [
                        'count' => $like
                        ]
                ]);
            }

            return $this->respond([
                'data' => $this->likersTransformer->transformCollection($like)
            ]);

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

}
