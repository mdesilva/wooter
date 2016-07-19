<?php

namespace Wooter\Http\Controllers\API;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wooter\Commands\Comment\CreateCommentCommand;
use Wooter\Commands\Comment\DeleteCommentCommand;
use Wooter\Commands\Comment\ReadCommentsCommand;
use Wooter\Commands\Comment\UpdateCommentCommand;
use Wooter\Http\Requests;
use Wooter\Http\Requests\Comment\CreateCommentRequest;
use Wooter\Http\Requests\Comment\UpdateCommentRequest;
use Wooter\Image;
use Wooter\Video;
use Wooter\Wooter\Exceptions\CommentNotFound;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\ImageNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePhotoNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueVideoNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\UserNotMemberException;
use Wooter\Wooter\Exceptions\VideoNotFound;
use Wooter\Wooter\Transformers\Comment\CommentersTransformer;
use Wooter\Wooter\Transformers\Comment\ImageCommentedTransformer;
use Wooter\Wooter\Transformers\Comment\VideoCommentedTransformer;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestObject;

final class CommentsController extends ApiController
{
    /**
     * @var ImageCommentedTransformer
     */
    private $imageCommentedTransformer;
    /**
     * @var VideoCommentedTransformer
     */
    private $videoCommentedTransformer;
    /**
     * @var CommentersTransformer
     */
    private $commentersTransformer;

    /**
     * @param ImageCommentedTransformer $imageCommentedTransformer
     * @param CommentersTransformer     $commentersTransformer
     * @param VideoCommentedTransformer $videoCommentedTransformer
     */
    public function __construct(ImageCommentedTransformer $imageCommentedTransformer,
                                CommentersTransformer $commentersTransformer,
                                VideoCommentedTransformer $videoCommentedTransformer) {

        $this->middleware('jwt.auth');

        $this->imageCommentedTransformer = $imageCommentedTransformer;
        $this->videoCommentedTransformer = $videoCommentedTransformer;
        $this->commentersTransformer = $commentersTransformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCommentRequest $request
     *
     * @param                          $commentedItemId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request, $commentedItemId)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();

            $commentedItem = $this->dispatchFrom(CreateCommentCommand::class, $request, ['user_id' => $user->id, 'commented_item_id' => $commentedItemId]);

            switch ($request->get('commented_item_type')) {
                case Image::class:
                    return $this->respond([
                        'data' => $this->imageCommentedTransformer->transform($commentedItem)
                    ]);

                case Video::class:
                    return $this->respond([
                        'data' => $this->videoCommentedTransformer->transform($commentedItem)
                    ]);
            }

        } catch (UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (UserNotMemberException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $commentedItemId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($commentedItemId)
    {
        try
        {
            $comments = $this->dispatchFrom(ReadCommentsCommand::class, new RequestObject(Request::all()), ['commented_item_id' => $commentedItemId]);

            if (is_numeric($comments)) {
                return $this->respond([
                    'data' => [
                        'count' => $comments
                    ]
                ]);
            }

            switch (Request::get('type')) {
                case Image::class:
                    return $this->respond([
                        'data' => $this->imageCommentedTransformer->transformCollection($comments)
                    ]);

                case Video::class:
                    return $this->respond([
                        'data' => $this->videoCommentedTransformer->transformCollection($comments)
                    ]);
            }

        } catch (ImageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (VideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeaguePhotoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch (Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|UpdateCommentRequest $request
     * @param                                  $commentId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateCommentRequest $request, $commentId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $comment = $this->dispatchFrom(UpdateCommentCommand::class, $request, ['user_id' => $user->id, 'comment_id' => $commentId]);

            switch ($comment->commented_item_type) {
                case Image::class:
                    return $this->respond([
                        'data' => $this->imageCommentedTransformer->transform($comment)
                    ]);

                case Video::class:
                    return $this->respond([
                        'data' => $this->videoCommentedTransformer->transform($comment)
                    ]);
            }

        } catch (CommentNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $commentId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($commentId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $this->dispatchFromArray(DeleteCommentCommand::class, ['comment_id' => $commentId, 'user_id' => $user->id]);

            return $this->respond([
                'data' => 'Success'
            ]);

        } catch(CommentNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(UserNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(ImageNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(VideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(LeaguePhotoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(LeagueVideoNotFound $e) {
            return $this->respondNotFound($e->getMessage());

        } catch(DatabaseException $e) {
            return $this->respondInternalError($e->getMessage());

        } catch(NotPermissionException $e) {
            return $this->respondForbidden($e->getMessage());

        } catch(Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
