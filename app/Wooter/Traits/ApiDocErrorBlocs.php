<?php
/**
 * Created by PhpStorm.
 * User: carlosmoralescliment
 * Date: 08/01/16
 * Time: 02:21
 */

namespace Wooter\Wooter\Traits;


trait ApiDocErrorBlocs {

    /**
     * @apiDefine LeagueNotFound
     * @apiError (Error 404) LeagueNotFound The <code>id</code> of the League was not found.
     *
     * @apiErrorExample {json} LeagueNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeaguePasscodeLength
     * @apiError (Error 404) LeaguePasscodeLength Passcode should not be less or greater than 6 characters!.
     *
     * @apiErrorExample {json} LeaguePasscodeLength
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "Passcode should not be less or greater than 6 characters! "
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeaguePasscodeAlreadyCreated
     * @apiError (Error 404) LeaguePasscodeAlreadyCreated Passcode for the league is already created.
     *
     * @apiErrorExample {json} LeaguePasscodeAlreadyCreated
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "Passcode for the league is already created "
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueBasicsNotFound
     * @apiError (Error 404) LeagueBasicsNotFound The <code>id</code> of the League basics was not found.
     *
     * @apiErrorExample {json} LeagueBasicsNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The league basic information was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueDetailsNotFound
     * @apiError (Error 404) LeagueDetailsNotFound The <code>id</code> of the League details was not found.
     *
     * @apiErrorExample {json} LeagueDetailsNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The details of this league were not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine GameVenueNotFound
     * @apiError (Error 404) LeagueDetailsNotFound The league game venue was not found
     *
     * @apiErrorExample {json} GameVenueNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The league game venue was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeaguePhotoNotFound
     * @apiError (Error 404) LeaguePhotoNotFound The league photo was not found
     *
     * @apiErrorExample {json} LeaguePhotoNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The league photo was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueVideoNotFound
     * @apiError (Error 404) LeagueVideoNotFound The league video was not found
     *
     * @apiErrorExample {json} LeagueVideoNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The league video was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine NotPermissionException
     * @apiError (Error 403) NotPermissionException The user has no permission to perform this action
     *
     * @apiErrorExample {json} NotPermissionException
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "You do not have permission to perform this action"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine UserHasNoOrganization
     * @apiError (Error 404) UserHasNoOrganization The user has not any organization
     *
     * @apiErrorExample {json} UserHasNoOrganization
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The user has not an organization"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine UserHasNoLeagues
     * @apiError (Error 404) UserHasNoLeagues The user has not any leagues
     *
     * @apiErrorExample {json} UserHasNoLeagues
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The user has not any leagues"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueNotBelongToUser
     * @apiError (Error 403) LeagueNotBelongToUser The user do not have access to the league
     *
     * @apiErrorExample {json} LeagueNotBelongToUser:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "You do not have access to this league"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine DivisionNotBelongToUser
     * @apiError (Error 403) DivisionNotBelongToUser The user do not have access to the division
     *
     * @apiErrorExample {json} DivisionNotBelongToUser:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "You do not have access to this division"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine TeamDivisionNotBelongToUser
     * @apiError (Error 403) TeamDivisionNotBelongToUser The user do not have access to the team division relation
     *
     * @apiErrorExample {json} TeamDivisionNotBelongToUser:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "You do not have access to this team division relation"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine UserHasNoOrganization
     * @apiError (Error 403) UserHasNoOrganization The user has not an organization
     *
     * @apiErrorExample {json} UserHasNoOrganization:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "The user has not an organization"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine DatabaseException
     * @apiError (Error 500) DatabaseException Error with the DB
     *
     * @apiErrorExample {json} DatabaseException:
     *     HTTP/1.1 500 Server Error
     *     {
     *       "error": {
     *              "message": "Error with the DB"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine UserNotFound
     * @apiError (Error 404) UserNotFound The <code>id</code> of the User was not found.
     *
     * @apiErrorExample {json} UserNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This user does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueLocationNotFound
     * @apiError (Error 404) LeagueLocationNotFound The <code>id</code> of the League location was not found.
     *
     * @apiErrorExample {json} LeagueLocationNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league location does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeaguePriceNotFound
     * @apiError (Error 404) LeaguePriceNotFound The <code>id</code> of the League price was not found.
     *
     * @apiErrorExample {json} LeaguePriceNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league price does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueRegistrationAnswerNotFound
     * @apiError (Error 404) LeagueRegistrationAnswerNotFound The <code>id</code> of the League registration answer was not found.
     *
     * @apiErrorExample {json} LeagueRegistrationAnswerNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league registration answer does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeagueRegistrationQuestionNotFound
     * @apiError (Error 404) LeagueRegistrationQuestionNotFound The <code>id</code> of the League registration question was not found.
     *
     * @apiErrorExample {json} LeagueRegistrationQuestionNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league registration question does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine SeasonCompetitionNotFound
     * @apiError (Error 404) SeasonCompetitionNotFound The <code>id</code> of the League season was not found.
     *
     * @apiErrorExample {json} SeasonCompetitionNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This league season does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine PaymentMethodNotFound
     * @apiError (Error 404) PaymentMethodNotFound The <code>id</code> of the Payment Method was not found.
     *
     * @apiErrorExample {json} PaymentMethodNotFound
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This Payment Method does not exist"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine UserIsNotAdmin
     * @apiError (Error 403) UserIsNotAdmin The user is not an admin.
     *
     * @apiErrorExample {json} UserIsNotAdmin
     *     HTTP/1.1 403 Forbidden
     *     {
     *       "error": {
     *              "message": "The user is not an admin"
     *              "status_code": 403
     *        }
     *     }
     */

    /**
     * @apiDefine PlayerNotFound
     * @apiError (Error 404) LeagueNotFound The <code>id</code> player (the user_id) was not found.
     *
     * @apiErrorExample {json} PlayerNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The player was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine LeaguePlayerAlreadyInvited
     * @apiError (Error 404) LeaguePlayerAlreadyInvited This player is already invited.
     *
     * @apiErrorExample {json} LeaguePlayerAlreadyInvited:
     *     HTTP/1.1 404 Not Allowed
     *     {
     *       "error": {
     *              "message": "This player is already invited"
     *              "status_code": 404
     *        }
     *     }
     */

     /**
     * @apiDefine PlayerAlreadyJoinedLeague
     * @apiError (Error 404) PlayerAlreadyJoinedLeague Player already joined the league.
     *
     * @apiErrorExample {json} PlayerAlreadyJoinedLeague:
     *     HTTP/1.1 404 Not Allowed
     *     {
     *       "error": {
     *              "message": "Player already joined the league"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine PlayerAlreadyJoinedTeamAsLeague
     * @apiError (Error 404) PlayerAlreadyJoinedTeamAsLeague Player has been already added to league with a team.
     *
     * @apiErrorExample {json} PlayerAlreadyJoinedTeamAsLeague:
     *     HTTP/1.1 404 Not Allowed
     *     {
     *       "error": {
     *              "message": "Player has been already added to league with a team"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine PlayerLeagueNotFound
     * @apiError (Error 404) PlayerLeagueNotFound The <code>id</code> of the relation between
     *            the player and the league was not found
     *
     * @apiErrorExample {json} Error-PlayerLeagueNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The player was not found in this league"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine DeleteException
     * @apiError (Error 500) DeleteException There was an error when deleting from the database
     *
     * @apiErrorExample {json} Error-DeleteException:
     *     HTTP/1.1 500 Internal Error
     *     {
     *       "error": {
     *              "message": "There was an error while deleting the record in the database"
     *              "status_code": 500
     *        }
     *     }
     */

    /**
     * @apiDefine AwardNotFound
     * @apiError (Error 404) AwardNotFound The <code>id</code> of the Award was not found
     *
     * @apiErrorExample {json} Error-AwardNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The award was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine PlayerAwardNotFound
     * @apiError (Error 404) PlayerAwardNotFound The <code>id</code> of the relation between
     *            the player and the award was not found
     *
     * @apiErrorExample {json} Error-PlayerAwardNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "This award was not found in this player"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine PlayerTeamNotFound
     * @apiError (Error 404) PlayerTeamNotFound The <code>id</code> of the relation between
     *            the player and the team was not found
     *
     * @apiErrorExample {json} Error-PlayerTeamNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The player was not found in the team"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine TeamDivisionNotFound
     * @apiError (Error 404) TeamDivisionNotFound The <code>id</code> of the relation between
     *            the team and the division was not found
     *
     * @apiErrorExample {json} Error-TeamDivisionNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The team was not found in the division"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine TeamNotFound
     * @apiError (Error 404) TeamNotFound The <code>id</code> of the team was not found
     *
     * @apiErrorExample {json} Error-TeamNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The team was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine DivisionNotFound
     * @apiError (Error 404) DivisionNotFound The <code>id</code> of the division was not found
     *
     * @apiErrorExample {json} Error-DivisionNotFound:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": {
     *              "message": "The division was not found"
     *              "status_code": 404
     *        }
     *     }
     */

    /**
     * @apiDefine SlugExistsException
     * @apiError (Error 406) SlugExistsException The <code>slug</code> of the league already exists
     *
     * @apiErrorExample {json} Error-SlugExistsException:
     *     HTTP/1.1 406 Not acceptable
     *     {
     *       "error": {
     *              "message": "The slug already exists"
     *              "status_code": 406
     *        }
     *     }
     */
}