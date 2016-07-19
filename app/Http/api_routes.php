<?php

Route::get('share/video/{video_id}', 'VideoMediaController@show');
Route::get('share/photo/{photo_id}', 'PhotoMediaController@show');
Route::match(['post', 'get'],'error/{key}', ['as' => '/error', 'uses'=>'API\ResponseController@error']);

Route::get('/api/svg/{svg}/{from?}/{to?}', ['uses' => 'API\Files\SVG@getSVG', 'as' => 'api.svg']);

Route::post('/api/config/website', [ 'before' => 'ajax' ,function(){
    return config('website');
}]);

Route::group(['prefix'=>'api'],function(){
        Route::get('contact','ContactController@index');
        Route::get('scheduledemo','ScheduleDemoController@index');
});

Route::group(['prefix' => 'api', 'before' => ['localization','translate'], 'namespace' => 'API'], function(){

    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('check-auth', 'AuthenticateController@getAuthenticatedUser');
    Route::get('get-user', 'AuthenticateController@getAuthenticatedUser');

    Route::post('/file-upload/{type}', ['uses' => 'Files\Upload@uploadFile', 'middleware' => ['ajax'], 'as' => 'api.file-upload']);
    Route::get('/view/{view}', ['uses' => 'Files\Views@getView', 'as' => 'api.view']);
    Route::post('setLanguage', ['as' => '/setLanguage', 'uses'=>'ResponseController@setLanguage']);

    Route::post('search', 'SearchController@search');
    Route::post('auto-complete-search', 'SearchController@autoCompleteSearch');

    Route::get('apparel','ApparelRequestController@index');

    Route::get('likes/{itemId}', 'LikesController@show');
    Route::post('likes/{itemId}', 'LikesController@store');

    Route::post('comments/{itemId}', 'CommentsController@store');
    Route::resource('comments', 'CommentsController');

    Route::resource('season-structures', 'SeasonStructuresController');
    Route::resource('playoff-structures', 'PlayoffStructuresController');
    Route::resource('game-structures', 'GameStructuresController');
    Route::resource('countries', 'CountriesController');
    Route::resource('weekdays', 'WeekdaysController');
    Route::resource('features', 'FeaturesController');
    Route::resource('sports', 'SportsController');

    Route::group(['namespace' => 'User'], function() {
        Route::resource('users','UserController');
        Route::resource('user/{userId}/photos', 'UserPhotosController');
        Route::resource('user/{userId}/videos', 'UserVideosController');
    });

    Route::group(['namespace' => 'Organization'], function() {
        Route::group(['namespace' => 'League'], function() {
            Route::resource('leagues', 'LeagueOrganizationsController');
            Route::resource('leagues/{leagueId}/is-owner', 'LeagueOrganizationsController@isOwner');
            Route::resource('leagues/{leagueId}/seasons', 'LeagueOrganizationSeasonsController');
            Route::resource('leagues/{leagueId}/tournaments', 'LeagueOrganizationTournamentsController');
            Route::resource('leagues/{leagueId}/cups', 'LeagueOrganizationCupsController');
            Route::get('leagues/{leagueId}/basics', 'LeagueOrganizationBasicsController@index');
            Route::post('leagues/{leagueId}/basics/edit', 'LeagueOrganizationBasicsController@update');
            Route::put('leagues/{leagueId}/basics', 'LeagueOrganizationBasicsController@update');
            Route::resource('leagues/{leagueId}/basics', 'LeagueOrganizationBasicsController');
            Route::get('leagues/{leagueId}/details', 'LeagueOrganizationDetailsController@index');
            Route::put('leagues/{leagueId}/details', 'LeagueOrganizationDetailsController@update');
            Route::resource('leagues/{leagueId}/details', 'LeagueOrganizationDetailsController');
            Route::resource('leagues/{leagueId}/reviews', 'LeagueOrganizationReviewsController');
            Route::resource('leagues/{leagueId}/game-venues', 'LeagueOrganizationGameVenuesController');
            Route::resource('leagues/{leagueId}/locations', 'LeagueOrganizationLocationsController');
            Route::resource('leagues/{leagueId}/prices', 'LeagueOrganizationPricesController');
            Route::resource('leagues/{leagueId}/photos', 'LeagueOrganizationPhotosController');
            Route::resource('leagues/{leagueId}/videos', 'LeagueOrganizationVideosController');
            Route::resource('leagues/{leagueId}/players', 'LeagueOrganizationPlayersController');
            Route::resource('leagues/{leagueId}/teams', 'LeagueOrganizationTeamsController');
            Route::resource('leagues/{leagueId}/passcodes', 'LeagueOrganizationPasscodesController');
            Route::resource('leagues/{leagueId}/video-labels', 'LeagueOrganizationVideoLabelsController');
            Route::resource('leagues/{leagueId}/photo-albums', 'LeagueOrganizationPhotoAlbumsController');
            Route::resource('leagues/{leagueId}/features', 'LeagueOrganizationFeaturesController');
            Route::resource('leagues/{leagueId}/games', 'LeagueOrganizationGamesController');
            Route::resource('leagues/{leagueId}/divisions', 'LeagueOrganizationDivisionsController');
            Route::resource('leagues/{leagueId}/permissions', 'LeagueOrganizationPermissionsController');
            Route::resource('leagues/{leagueId}/videoLabel', 'LeagueOrganizationVideoLabelsController');
            Route::resource('leagues/{leagueId}/toggle-dream-league', 'LeagueOrganizationsController@toggleDreamLeague');
            Route::resource('leagues/{leagueId}/players-stats-averages', 'LeagueOrganizationPlayerStatsAveragesController');
            Route::resource('leagues/{leagueId}/teams-stats-totals', 'LeagueOrganizationTeamStatsTotalsController');
            Route::resource('leagues/{leagueId}/teams-stats-averages', 'LeagueOrganizationTeamStatsAveragesController');
            Route::resource('leagues/{leagueId}/teams-stats-percentages', 'LeagueOrganizationTeamStatsPercentagesController');
        });

        Route::group(['namespace' => 'Association'], function() {
            Route::resource('associations', 'AssociationOrganizationsController');
            Route::resource('associations/{associationId}/seasons', 'AssociationOrganizationSeasonsController');
            Route::resource('associations/{associationId}/tournaments', 'AssociationOrganizationTournamentsController');
            Route::resource('associations/{associationId}/cups', 'AssociationOrganizationCupsController');
            Route::resource('associations/{associationId}/basics', 'AssociationOrganizationBasicsController');
            Route::resource('associations/{associationId}/details', 'AssociationOrganizationDetailsController');
            Route::resource('associations/{associationId}/reviews', 'AssociationOrganizationReviewsController');
            Route::resource('associations/{associationId}/game-venues', 'AssociationOrganizationGameVenuesController');
            Route::resource('associations/{associationId}/locations', 'AssociationOrganizationLocationsController');
            Route::resource('associations/{associationId}/photos', 'AssociationOrganizationPhotosController');
            Route::resource('associations/{associationId}/videos', 'AssociationOrganizationVideosController');
            Route::resource('associations/{associationId}/players', 'AssociationOrganizationPlayersController');
            Route::resource('associations/{associationId}/passcodes', 'AssociationOrganizationPasscodesController');
            Route::resource('associations/{associationId}/video-labels', 'AssociationOrganizationVideoLabelsController');
            Route::resource('associations/{associationId}/photo-albums', 'AssociationOrganizationPhotoAlbumsController');
            Route::resource('associations/{associationId}/features', 'AssociationOrganizationFeaturesController');
            Route::resource('associations/reviews', 'AssociationOrganizationReviewsController');
        });

        Route::group(['namespace' => 'Conference'], function() {
            Route::resource('conferences', 'ConferenceOrganizationsController');
            Route::resource('conferences/{conferenceId}/seasons', 'ConferenceOrganizationSeasonsController');
            Route::resource('conferences/{conferenceId}/tournaments', 'ConferenceOrganizationTournamentsController');
            Route::resource('conferences/{conferenceId}/cups', 'ConferenceOrganizationCupsController');
            Route::resource('conferences/{conferenceId}/basics', 'ConferenceOrganizationBasicsController');
            Route::resource('conferences/{conferenceId}/details', 'ConferenceOrganizationDetailsController');
            Route::resource('conferences/{conferenceId}/reviews', 'ConferenceOrganizationReviewsController');
            Route::resource('conferences/{conferenceId}/game-venues', 'ConferenceOrganizationGameVenuesController');
            Route::resource('conferences/{conferenceId}/locations', 'ConferenceOrganizationLocationsController');
            Route::resource('conferences/{conferenceId}/photos', 'ConferenceOrganizationPhotosController');
            Route::resource('conferences/{conferenceId}/videos', 'ConferenceOrganizationVideosController');
            Route::resource('conferences/{conferenceId}/players', 'ConferenceOrganizationPlayersController');
            Route::resource('conferences/{conferenceId}/passcodes', 'ConferenceOrganizationPasscodesController');
            Route::resource('conferences/{conferenceId}/video-labels', 'ConferenceOrganizationVideoLabelsController');
            Route::resource('conferences/{conferenceId}/photo-albums', 'ConferenceOrganizationPhotoAlbumsController');
            Route::resource('conferences/{conferenceId}/features', 'ConferenceOrganizationFeaturesController');
            Route::resource('conferences/reviews', 'ConferenceOrganizationReviewsController');
        });

        Route::group(['namespace' => 'Federation'], function() {
            Route::resource('federations', 'FederationOrganizationsController');
            Route::resource('federations/{federationId}/seasons', 'FederationOrganizationSeasonsController');
            Route::resource('federations/{federationsId}/tournaments', 'FederationOrganizationTournamentsController');
            Route::resource('federations/{federationsId}/cups', 'FederationOrganizationCupsController');
            Route::resource('federations/{federationsId}/basics', 'FederationOrganizationBasicsController');
            Route::resource('federations/{federationsId}/details', 'FederationOrganizationDetailsController');
            Route::resource('federations/{federationsId}/reviews', 'FederationOrganizationReviewsController');
            Route::resource('federations/{federationsId}/game-venues', 'FederationOrganizationGameVenuesController');
            Route::resource('federations/{federationsId}/locations', 'FederationOrganizationLocationsController');
            Route::resource('federations/{federationsId}/photos', 'FederationOrganizationPhotosController');
            Route::resource('federations/{federationsId}/videos', 'FederationOrganizationVideosController');
            Route::resource('federations/{federationsId}/players', 'FederationOrganizationPlayersController');
            Route::resource('federations/{federationsId}/passcodes', 'FederationOrganizationController');
            Route::resource('federations/{federationsId}/video-labels', 'FederationOrganizationVideoLabelsController');
            Route::resource('federations/{federationsId}/photo-albums', 'FederationOrganizationPhotoAlbumsController');
            Route::resource('federations/{federationsId}/features', 'FederationOrganizationFeaturesController');
            Route::resource('federations/reviews', 'FederationOrganizationReviewsController');
        });
    });

    Route::group(['namespace' => 'Competition'], function() {
        Route::group(['namespace' => 'Season'], function() {
            Route::resource('seasons', 'SeasonCompetitionsController');
            Route::resource('seasons/{seasonId}/regulars', 'SeasonCompetitionRegularStagesController');
            Route::resource('seasons/{seasonId}/preseason', 'SeasonCompetitionPreseasonStagesController');
            Route::resource('seasons/{seasonId}/postseason', 'SeasonCompetitionPostSeasonStagesController');
            Route::resource('seasons/{seasonId}/exhibitions', 'SeasonCompetitionExhibitionStagesController');
            Route::resource('seasons/{seasonId}/games', 'SeasonCompetitionGamesController');
            Route::resource('seasons/{seasonId}/divisions', 'SeasonCompetitionDivisionsController');
        });

        Route::group(['namespace' => 'Tournament'], function() {
            Route::resource('tournaments', 'TournamentCompetitionsController');
            Route::resource('tournaments/{tournamentId}/rounds', 'TournamentCompetitionRoundStagesController');
            Route::resource('tournaments/{tournamentId}/games', 'TournamentCompetitionGamesController');
        });

        Route::group(['namespace' => 'Cup'], function() {
            Route::resource('cups', 'CupCompetitionsController');
            Route::resource('cups/{cupId}/round', 'CupCompetitionRoundStagesController');
            Route::resource('cups/{cupId}/games', 'CupCompetitionGamesController');
        });
    });

    Route::group(['namespace' => 'Stage'], function() {
        Route::group(['namespace' => 'Regular'], function() {
            Route::resource('regulars', 'RegularStagesController');
            Route::resource('regulars/{regularId}/games', 'RegularStageGamesController');
            Route::resource('regulars/{regularId}/competition-weeks', 'RegularCompetitionWeeksController');
        });

        Route::group(['namespace' => 'Preseason'], function() {
            Route::resource('preseasons', 'PreseasonStagesController');
            Route::resource('preseasons/{preseasonId}/games', 'PreseasonStageGamesController');
        });

        Route::group(['namespace' => 'Postseason'], function() {
            Route::resource('postseasons', 'PostseasonStagesController');
            Route::resource('postseasons/{postseasonId}/games', 'PostseasonStageGamesController');
        });

        Route::group(['namespace' => 'Exhibition'], function() {
            Route::resource('exhibitions', 'ExhibitionStagesController');
            Route::resource('exhibitions/{exhibitionId}/games', 'ExhibitionStageGamesController');
        });

        Route::group(['namespace' => 'Round'], function() {
            Route::resource('rounds', 'RoundStagesController');
            Route::resource('rounds/{roundId}/games', 'RoundStageGamesController');
        });
    });
    
    Route::group(['namespace' => 'Game'], function() {
        Route::resource('games', 'GamesController');
        Route::resource('games/{gameId}/photos', 'GamePhotosController');
        Route::resource('games/{gameId}/videos', 'GameVideosController');
        Route::resource('games/{gameId}/player-stats', 'GameStatsController');
        Route::delete('games/{gameId}/player-stats', 'GameStatsController@deleteByGameId');
    });
    
    Route::group(['namespace' => 'Team'], function() {
        Route::post('teams/{teamId}', 'TeamsController@update');
        Route::resource('teams', 'TeamsController');
        Route::resource('teams/{teamId}/leagues', 'TeamLeaguesController');
        Route::resource('teams/{teamId}/players', 'TeamPlayersController');
        Route::resource('teams/{teamId}/team-join-league', 'TeamLeaguesController');
        Route::resource('teams/{teamId}/{token}/join-league-by-invite', 'TeamLeaguesController@teamJoinLeagueByInvite');
        Route::resource('teams/{teamId}/photos', 'TeamPhotosController');
        Route::resource('teams/{teamId}/videos', 'TeamVideosController');
        Route::resource('teams/{teamId}/stats', 'TeamStatsController');
    });
    


    Route::group(['namespace' => 'Notification'], function() {
        Route::resource('notifications', 'NotificationsController');
        Route::delete('notifications', 'NotificationsController@clear');
        Route::put('notifications', 'NotificationsController@markAsConsumed');
    });

    Route::group(['namespace' => 'Follow'], function() {
        Route::resource('follow-league', 'FollowLeagueController');
    });

    Route::group(['namespace' => 'StaticPages'], function() {
        Route::resource('service-requests', 'ServiceRequestsController');
        Route::resource('package-requests', 'PackageRequestsController');
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::resource('code', 'AdminUrlGeneratorController');
    });

    Route::group(['namespace' => 'Stat'], function() {
        Route::resource('stats', 'StatsController');
        Route::resource('stats/{statId}/Players', 'StatPlayersController');
    });

    Route::group(['namespace' => 'Award'], function() {
        Route::resource('awards', 'AwardsController');
        Route::resource('awards/{awardId}/Players', 'AwardPlayersController');
    });

    Route::group(['namespace' => 'Division'], function() {
        Route::resource('divisions', 'DivisionsController');
        Route::resource('divisions/{divisionId}/teams', 'DivisionTeamsController');
    });



    Route::group(['namespace' => 'Player'], function() {
        Route::put('player/info', 'PlayerInfoController@updateInfo');
        Route::put('player/change-password', 'PlayerInfoController@changePassword');
        Route::resource('players/{playerId}/teams', 'PlayerTeamsController');
        Route::resource('players', 'PlayersController');
        Route::resource('players/{playerId}/awards', 'PlayerAwardsController');
        Route::resource('players/{playerId}/stats', 'PlayerStatsController');
        Route::post('players/{playerId}/join-league', 'PlayerLeaguesController@playerJoinLeague');
        Route::resource('players/{playerId}/photos', 'PlayerPhotosController');
        Route::resource('players/{playerId}/videos', 'PlayerVideosController');
    });

    Route::group(['namespace' => 'Mailbox'], function() {
        Route::get('mailbox/inbox/', 'MailboxInboxController@index');
        Route::get('mailbox/inbox/conversations', 'MailboxInboxConversationsController@index');
        Route::get('mailbox/inbox/broadcasts', 'MailboxInboxBroadcastsController@index');
        Route::get('mailbox/sent/conversations', 'MailboxInboxConversationsController@index');
        Route::get('mailbox/sent/broadcasts', 'MailboxInboxBroadcastsController@index');
        Route::get('mailbox/inbox/broadcasts/{id}', 'MailboxInboxBroadcastsController@show');
        Route::get('mailbox/trash/conversations', 'MailboxTrashConversationsController@index');
        Route::get('mailbox/trash/broadcasts', 'MailboxTrashBroadcastsController@index');
        Route::get('mailbox/inbox/conversations/{id}/messages', 'MailboxInboxConversationMessagesController@index');
        Route::get('mailbox/trash/conversations/{id}/messages', 'MailboxTrashConversationMessagesController@index');
        Route::post('mailbox/inbox/conversation/store', 'MailboxInboxConversationsController@store');
        Route::post('mailbox/inbox/conversations/{id}/message/store', 'MailboxInboxConversationMessagesController@store');
        Route::post('mailbox/inbox/broadcast/store', 'MailboxInboxBroadcastsController@store');
    });

    Route::group(['namespace' => 'Court'], function() {
        Route::get('courts/{distance}/{latitude}/{longitude}/{offset}/{limit}', 'CourtsController@index');
        Route::get('courts/{court_id}', 'CourtsController@show');
        Route::get('courts/{court_id}/bookings', 'CourtBookingsController@index');
        Route::get('courts/{court_id}/bookings/{booking_id}', 'CourtBookingsController@show');
        Route::get('courts/{court_id}/features', 'CourtFeaturesController@index');
        Route::get('courts/{court_id}/features/{feature_id}', 'CourtFeaturesController@show');
        Route::get('courts/{court_id}/images', 'CourtImagesController@index');
        Route::get('courts/{court_id}/images/{image_id}', 'CourtImagesController@show');
        Route::get('courts/{court_id}/manual-offs', 'CourtManualOffsController@index');
        Route::get('courts/{court_id}/manual-offs/{off_id}', 'CourtManualOffsController@show');
        Route::get('courts/{court_id}/manual-time-slots', 'CourtManualTimeSlotsController@index');
        Route::get('courts/{court_id}/manual-time-slots/{slot_id}', 'CourtBookingsController@show');
        Route::get('courts/{court_id}/time-slots', 'CourtTimeSlotsController@index');
        Route::get('courts/{court_id}/time-slots/{slot_id}', 'CourtTimeSlotsController@show');
        Route::get('courts/{court_id}/prices', 'CourtPricesController@index');
        Route::get('courts/{court_id}/prices/{price_id}', 'CourtPricesController@show');
        Route::get('courts/{court_id}/videos', 'CourtVideosController@index');
        Route::get('courts/{court_id}/videos/{video_id}', 'CourtVideosController@show');
    });

    Route::group(['namespace' => 'Qnap'], function() {
        Route::resource('qnap/qnapVideo', 'QnapLeagueVideosController');
       /* Route::resource('qnap/storeVideos', 'QnapLeagueVideosController@store');
        Route::resource('qnap/updateVideos', 'QnapLeagueVideosController@update');
        Route::resource('qnap/deleteVideos', 'QnapLeagueVideosController@destroy');*/
        Route::resource('qnap/getOrganizationLeagues', 'QnapLeagueVideosController@organizationLeagues');
    });


});

Route::post('contact','ContactController@store');
Route::post('scheduledemo','ScheduleDemoController@store');
