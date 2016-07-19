/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio@gmail.com
 * For: APIs
 * License: Wooter LLC.
 * Date: 2016.04.04
 * Description:  Factory for APIs
 *
 */
__Wooter.factory('API', ['$window', '$http', '$q', '$resource', '$stateParams', function($window, $http, $q, $resource, $stateParams){
    var factory = {};

    var formDataObject = function (data) {
        var fd = new FormData();
        angular.forEach(data, function(value, key) {
            fd.append(key, value);
        });
        return fd;
    };

    /**
     * COnfiguration
     * @type {{leagues: {url: string, params: {id: string}, methods: {update: {method: string}}}}}
     */
    factory.apis = {
        /**
         * API name
         */
        
        /********** USERS **********/
        users: {
            url: 'api/users',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/users/:userId',
                    params: {
                        userId: '@userId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/users',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/users/:userId',
                    params: {
                        userId: '@userId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/users/:userId',
                    params: {
                        userId: '@userId'
                    }
                }
            }
        },
        userPhotos: {
            url: 'api/users/:userId/photos',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/users/:userId/photos/:photoId',
                    params: {
                        userId: '@userId',
                        photoId: '@photoId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/users/:userId/photos',
                    params: {
                        userId: 'userId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/users/:userId/photos/:photoId',
                    params: {
                        userId: '@userId',
                        photoId: '@photoId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/users/:userId/photos/:photoId',
                    params: {
                        userId: '@userId',
                        photoId: '@photoId'
                    }
                }
            }
        },
        userVideos: {
            url: 'api/users/:userId/videos',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/users/:userId/videos',
                    params: {
                        userId: '@userId',
                        videoId: '@videoId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/users/:userId/videos',
                    params: {
                        userId: 'userId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/users/:userId/videos/:videoId',
                    params: {
                        userId: '@userId',
                        photoId: '@videoId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/users/:userId/videos/:videoId',
                    params: {
                        userId: '@userId',
                        photoId: '@videoId'
                    }
                }
            }
        },
        
        /********** LEAGUES **********/
        
        leagues: {
            url: 'api/leagues',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                isOwner:{
                    method: 'GET',
                    url: 'api/leagues/:leagueId/is-owner',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId',
                    params: {
                        leagueId: '@leagueId'
                    }
                }
            }
        },
        leagueDivisions: {
            url: '/api/leagues/:leagueId/divisions/:divisionId',
            methods: {
                show: {
                    method: 'GET',
                    url: '/api/leagues/:leagueId/divisions/:divisionId',
                    params: {
                        leagueId: '@leagueId',
                        divisionId: '@divisionId'
                    }
                },
                save:{
                    method: 'POST',
                    url: '/api/leagues/:leagueId/divisions',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: '/api/leagues/:leagueId/divisions/:divisionId',
                    params: {
                        leagueId: '@leagueId',
                        divisionId: '@divisionId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: '/api/leagues/:leagueId/divisions/:divisionId',
                    params: {
                        leagueId: '@leagueId',
                        divisionId: '@divisionId'
                    }
                }
            }
        },
        leagueSeasons: {
            url: 'api/leagues/:leagueId/seasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/seasons/:seasonId',
                    params: {
                        leagueId: '@leagueId',
                        seasonId: '@seasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/seasons',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/seasons/:seasonId',
                    params: {
                        leagueId: '@leagueId',
                        seasonId: '@seasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/seasons/:seasonId',
                    params: {
                        leagueId: '@leagueId',
                        seasonId: '@seasonId'
                    }
                }
            }
        },
        leagueBasics: {
            url: 'api/leagues/:leagueId/basics',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/basics/:basicId',
                    params: {
                        leagueId: '@leagueId',
                        basicId: '@basicId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/basics',
                    params: {
                        leagueId: '@leagueId'
                    },
                    transformRequest: formDataObject,
                    headers: {'Content-Type':undefined, enctype:'multipart/form-data'}
                },
                put: {
                    method: 'POST',
                    url: 'api/leagues/:leagueId/basics/edit',
                    params: {
                        leagueId: '@leagueId'
                    },
                    transformRequest: formDataObject,
                    headers: {'Content-Type':undefined, enctype:'multipart/form-data'}
                }
            }
        },
        leagueDetails: {
            url: 'api/leagues/:leagueId/details',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/details/:detailId',
                    params: {
                        leagueId: '@leagueId',
                        detailId: '@detailId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/details',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/details',
                    params: {
                        leagueId: '@leagueId'
                    }
                }
            }
        },
        leagueReviews: {
            url: 'api/leagues/:leagueId/reviews',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/reviews/:reviewId',
                    params: {
                        leagueId: '@leagueId',
                        reviewId: '@reviewId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/reviews',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/reviews/:reviewId',
                    params: {
                        leagueId: '@leagueId',
                        reviewId: '@reviewId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/reviews/:reviewId',
                    params: {
                        leagueId: '@leagueId',
                        reviewId: '@reviewId'
                    }
                }
            }
        },
        leagueGameVenues: {
            url: 'api/leagues/:leagueId/game-venues',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/game-venues/:gameVenueId',
                    params: {
                        leagueId: '@leagueId',
                        gameVenueId: '@gameVenueId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/game-venues',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/game-venues/:gameVenueId',
                    params: {
                        leagueId: '@leagueId',
                        gameVenueId: '@gameVenueId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/game-venues/:gameVenueId',
                    params: {
                        leagueId: '@leagueId',
                        gameVenueId: '@gameVenueId'
                    }
                }
            }
        },
        leagueLocations: {
            url: 'api/leagues/:leagueId/locations',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/locations/:locationId',
                    params: {
                        leagueId: '@leagueId',
                        locationId: '@locationId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/locations',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/locations/:locationId',
                    params: {
                        leagueId: '@leagueId',
                        locationId: '@locationId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/locations/:locationId',
                    params: {
                        leagueId: '@leagueId',
                        locationId: '@locationId'
                    }
                }
            }
        },
        leaguePhotos: {
            url: 'api/leagues/:leagueId/photos',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/photos/:photoId',
                    params: {
                        leagueId: '@leagueId',
                        photoId: '@photoId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/photos',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/photos/:photoId',
                    params: {
                        leagueId: '@leagueId',
                        photoId: '@photoId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/photos/:photoId',
                    params: {
                        leagueId: '@leagueId',
                        photoId: '@photoId'
                    }
                }
            }
        },
        leagueVideos: {
            url: 'api/leagues/:leagueId/videos',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/videos/:videoId',
                    params: {
                        leagueId: '@leagueId',
                        videoId: '@videoId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/videos',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/videos/:videoId',
                    params: {
                        leagueId: '@leagueId',
                        videoId: '@videoId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/videos/:videoId',
                    params: {
                        leagueId: '@leagueId',
                        videoId: '@videoId'
                    }
                }
            }
        },
        leaguePasscodes: {
            url: 'api/leagues/:leagueId/passcodes',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/passcodes/:passcodeId',
                    params: {
                        leagueId: '@leagueId',
                        passcodeId: '@passcodeId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/passcodes',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/passcodes/:passcodeId',
                    params: {
                        leagueId: '@leagueId',
                        passcodeId: '@passcodeId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/passcodes/:passcodeId',
                    params: {
                        leagueId: '@leagueId',
                        passcodeId: '@passcodeId'
                    }
                }
            }
        },
        leaguePlayers: {
            url: 'api/leagues/:leagueId/players',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/players/:playerId',
                    params: {
                        leagueId: '@leagueId',
                        playerId: '@playerId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/players',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/players/:playerId',
                    params: {
                        leagueId: '@leagueId',
                        playerId: '@playerId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/players/:playerId',
                    params: {
                        leagueId: '@leagueId',
                        playerId: '@playerId'
                    }
                }
            }
        },
        leagueVideoLabels: {
            url: 'api/leagues/:leagueId/video-labels',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/video-labels/:videoLabelId',
                    params: {
                        leagueId: '@leagueId',
                        videoLabelId: '@videoLabelId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/video-labels',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/video-labels/:videoLabelId',
                    params: {
                        leagueId: '@leagueId',
                        videoLabelId: '@videoLabelId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/video-labels/:videoLabelId',
                    params: {
                        leagueId: '@leagueId',
                        videoLabelId: '@videoLabelId'
                    }
                }
            }
        },
        leaguePhotoAlbums: {
            url: 'api/leagues/:leagueId/photo-albums',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/photo-albums/:photoAlbumId',
                    params: {
                        leagueId: '@leagueId',
                        photoAlbumId: '@photoAlbumId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/photo-albums',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/photo-albums/:photoAlbumId',
                    params: {
                        leagueId: '@leagueId',
                        photoAlbumId: '@photoAlbumId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/photo-albums/:photoAlbumId',
                    params: {
                        leagueId: '@leagueId',
                        photoAlbumId: '@photoAlbumId'
                    }
                }
            }
        },
        leagueFeatures: {
            url: 'api/leagues/:leagueId/features',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/features/:featureId',
                    params: {
                        leagueId: '@leagueId',
                        featureId: '@featureId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/features',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/features/:featureId',
                    params: {
                        leagueId: '@leagueId',
                        featureId: '@featureId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/features/:featureId',
                    params: {
                        leagueId: '@leagueId',
                        featureId: '@featureId'
                    }
                }
            }
        },
        leagueGames: {
            url: 'api/leagues/:leagueId/games',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/games/:gameId',
                    params: {
                        leagueId: '@leagueId',
                        gameId: '@gameId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagues/games',
                    params: {
                        leagueId: 'leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/games/:gameId',
                    params: {
                        leagueId: '@leagueId',
                        gameId: '@gameId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/games/:gameId',
                    params: {
                        leagueId: '@leagueId',
                        gameId: '@gameId'
                    }
                }
            }
        },
        leagueTeams: {
            url: 'api/leagues/:leagueId/teams',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/teams/:teamId',
                    params: {
                        leagueId: '@leagueId',
                        teamId: '@teamId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/teams',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/teams/:teamId',
                    params: {
                        leagueId: '@leagueId',
                        teamId: '@teamId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/teams/:teamId',
                    params: {
                        leagueId: '@leagueId',
                        teamId: '@teamId'
                    }
                }
            }
        },
        leaguePrices: {
            url: 'api/leagues/:leagueId/prices',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/leagues/:leagueId/prices/:leaguePriceId',
                    params: {
                        leagueId: '@leagueId',
                        leaguePriceId: '@leaguePriceId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/leagues/:leagueId/prices',
                    params: {
                        leagueId: '@leagueId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/leagues/:leagueId/prices/:leaguePriceId',
                    params: {
                        leagueId: '@leagueId',
                        leaguePriceId: '@leaguePriceId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:leagueId/prices/:leaguePriceId',
                    params: {
                        leagueId: '@leagueId',
                        leaguePriceId: '@leaguePriceId'
                    }
                }
            }
        },
        leagueStatsAverages: {
            url: 'api/leagues/:leagueId/players-stats-averages',
            method: 'GET',
            params: {
                leagueId: '@leagueId',
                sport: '@sport',
                type: '@type',
                competition_id : '@competition_id',
                game_id : '@game_id',
                team_id : '@team_id',
                player_id : '@player_id',
                offset : '@offset',
                limit : '@limit',
                order_by : '@order_by',
                order_direction : '@order_direction',
                stat_name : '@stat_name',
                bulk : '@bulk'
            }
        },
        leagueTeamsStatsTotals: {
            url: 'api/leagues/:leagueId/teams-stats-totals',
            method: 'GET',
            params: {
                leagueId: '@leagueId',
                offset : '@offset',
                limit : '@limit',
                order_by : '@order_by',
                order_direction : '@order_direction',
                team_id : '@team_id',
                season_id : '@season_id',
                stage_id : '@stage_id',
                game_id : '@game_id',
                sport: '@sport',
                bulk: '@bulk'
            }
        },
        leagueTeamsStatsAverages: {
            url: 'api/leagues/:leagueId/teams-stats-averages',
            method: 'GET',
            params: {
                leagueId: '@leagueId',
                offset : '@offset',
                limit : '@limit',
                order_by : '@order_by',
                order_direction : '@order_direction',
                team_id : '@team_id',
                season_id : '@season_id',
                stage_id : '@stage_id',
                game_id : '@game_id',
                sport: '@sport',
                bulk: '@bulk'
            }
        },
        leagueTeamsStatsPercentages: {
            url: 'api/leagues/:leagueId/teams-stats-percentages',
            method: 'GET',
            params: {
                leagueId: '@leagueId',
                offset : '@offset',
                limit : '@limit',
                order_by : '@order_by',
                order_direction : '@order_direction',
                team_id : '@team_id',
                season_id : '@season_id',
                stage_id : '@stage_id',
                game_id : '@game_id',
                sport: '@sport',
                bulk: '@bulk'
            }
        },
        
        
        /********** ASSOCIATIONS **********/
        
        associations: {
            url: 'api/associations',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/associations/:associationId',
                    params: {
                        associationId: '@associationId',
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/associations',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/associations/:associationId',
                    params: {
                        associationId: '@associationId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/associations/:associationId',
                    params: {
                        associationId: '@associationId'
                    }
                }
            }
        },
        
        /********** CONFERENCES **********/
        
        conferences: {
            url: 'api/conferences',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/conferences/:conferenceId',
                    params: {
                        conferenceId: '@conferenceId',
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/conferences',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/conferences/:conferenceId',
                    params: {
                        conferenceId: '@conferenceId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/conferences/:conferenceId',
                    params: {
                        conferenceId: '@conferenceId'
                    }
                }
            }
        },
        
        /********** FEDERATIONS **********/
        
        federations: {
            url: 'api/federations',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/federations/:federationId',
                    params: {
                        federationId: '@federationId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/federations',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/federations/:federationId',
                    params: {
                        federationId: '@federationId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/federations/:federationId',
                    params: {
                        federationId: '@federationId'
                    }
                }
            }
        },
        
        /********** SEASONS **********/
        
        seasonCompetitions: {
            url: 'api/seasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/seasons/:seasonId',
                    params: {
                        seasonId: '@seasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/seasons',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/seasons/:seasonId',
                    params: {
                        seasonId: '@seasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/seasons/:seasonId',
                    params: {
                        seasonId: '@seasonId'
                    }
                }
            }
        },
        seasonRegularStage: {
            url: 'api/seasons/:seasonId/regulars',
            methods: {
             
            }
        },
        seasonPreseasonStage: {
            url: 'api/seasons/:seasonId/preseasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/seasons/:seasonId/preseasons/:preseasonId',
                    params: {
                        seasonId: '@seasonId',
                        preseasonId: '@preseasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/seasons/:seasonId/preseasons',
                    params: {
                        seasonId: 'seasonId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/seasons/:seasonId/preseasons/:preseasonId',
                    params: {
                        seasonId: '@seasonId',
                        preseasonId: '@preseasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:seasonId/preseasons/:preseasonId',
                    params: {
                        seasonId: '@seasonId',
                        preseasonId: '@preseasonId'
                    }
                }
            }
        },
        seasonPostseasonStage: {
            url: 'api/seasons/:seasonId/postseasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/seasons/:seasonId/postseasons/:postseasonId',
                    params: {
                        seasonId: '@seasonId',
                        postseasonId: '@postseasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/seasons/:seasonId/postseasons',
                    params: {
                        seasonId: 'seasonId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/seasons/:seasonId/postseasons/:postseasonId',
                    params: {
                        seasonId: '@seasonId',
                        postseasonId: '@postseasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:seasonId/postseasons/:postseasonId',
                    params: {
                        seasonId: '@seasonId',
                        postseasonId: '@postseasonId'
                    }
                }
            }
        },
        seasonExhibitionStage: {
            url: 'api/seasons/:seasonId/exhibitions',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/seasons/:seasonId/exhibitions/:exhibitionId',
                    params: {
                        seasonId: '@seasonId',
                        exhibitionId: '@exhibitionId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/seasons/:seasonId/exhibitions',
                    params: {
                        seasonId: 'seasonId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/seasons/:seasonId/exhibitions/:exhibitionId',
                    params: {
                        seasonId: '@seasonId',
                        exhibitionId: '@exhibitionId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/leagues/:seasonId/exhibitions/:exhibitionId',
                    params: {
                        seasonId: '@seasonId',
                        exhibitionId: '@exhibitionId'
                    }
                }
            }
        },
        seasonGames: {
            url: 'api/seasons/:seasonId/games',
            methods: {
                save: {
                    method: 'POST',
                    url: 'api/seasons/:seasonId/games',
                    params: {
                        seasonId: '@seasonId'
                    }
                }
            }
        },

        /********** TOURNAMENTS **********/
        
        tournamentCompetitions: {
            url: 'api/tournaments',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/tournaments/:tournamentId',
                    params: {
                        seasonId: '@seasonId',
                        tournamentId: '@tournamentId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/tournaments',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/tournaments/:tournamentId',
                    params: {
                        tournamentId: '@tournamentId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/tournaments/:tournamentId',
                    params: {
                        tournamentId: '@tournamentId'
                    }
                }
            }
        },
        
        /********** CUPS **********/
        
        cupCompetitions: {
            url: 'api/cups',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/cups/:cupId',
                    params: {
                        seasonId: '@seasonId',
                        cupId: '@cupId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/cups',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/cups/:cupId',
                    params: {
                        cupId: '@cupId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/cups/:cupId',
                    params: {
                        cupId: '@cupId'
                    }
                }
            }
        },
        
        /********** REGULAR STAGES **********/
        
        regularStages: {
            url: 'api/regulars',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/regulars/:regularId',
                    params: {
                        seasonId: '@seasonId',
                        regularId: '@regularId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/regulars',
                    params: {
                        competition_id: '@competition_id',
                        competition_type: '@competition_type',
                        rule_id: '@rule_id',
                        rule_type: '@rule_type',
                        starts_at: '@starts_at',
                        ends_at: '@ends_at'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/regulars/:regularId',
                    params: {
                        regularId: '@regularId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/regulars/:regularId',
                    params: {
                        regularId: '@regularId'
                    }
                }
            }
        },
        regularStageGames: {
            url: 'api/regulars/:regularId/games',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/regulars/:regularId/games/:gameId',
                    params: {
                        seasonId: '@seasonId',
                        gameId: '@gameId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/regulars/:regularId/games',
                    params: {
                        regularId: '@regularId',
                        home_team_id : '@home_team_id',
                        visiting_team_id : '@visiting_team_id',
                        location_id : '@location_id',
                        game_structure_id : '@game_structure_id',
                        sport_id : '@sport_id',
                        competition_week_id : '@competition_week_id',
                        stage_id : '@competition_id',
                        stage_type : '@competition_type',
                        time : '@time'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/regulars/:regularId/games/:gameId',
                    params: {
                        regularId: '@regularId',
                        gameId: '@gameId',
                        home_team_id : '@home_team_id',
                        visiting_team_id : '@visiting_team_id',
                        location_id : '@location_id',
                        game_structure_id : '@game_structure_id',
                        sport_id : '@sport_id',
                        competition_week_id : '@competition_week_id',
                        stage_id : '@competition_id',
                        stage_type : '@competition_type',
                        time : '@time'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/regulars/:regularId/games/:gameId',
                    params: {
                        regularId: '@regularId',
                        gameId: '@gameId'
                    }
                }
            }
        },
        regularCompetitionWeeks: {
            url: 'api/regulars/:regularId/competition-weeks',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/regulars/:regularId/competition-weeks/:competitionWeekId',
                    params: {
                        regularId: '@regularId',
                        competitionWeekId: '@competitionWeekId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/regulars/:regularId/competition-weeks',
                    params: {
                        regularId: '@regularId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/regulars/:regularId/competition-weeks/:competitionWeekId',
                    params: {
                        regularId: '@regularId',
                        competitionWeekId: '@competitionWeekId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/regulars/:regularId/competition-weeks/:competitionWeekId',
                    params: {
                        regularId: '@regularId',
                        competitionWeekId: '@competitionWeekId'
                    }
                }
            }
        },
        /********** PRESEASONS **********/
        
        preseasonStages: {
            url: 'api/preseasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/preseasons/:preseasonId',
                    params: {
                        seasonId: '@seasonId',
                        preseasonId: '@preseasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/preseasons',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/preseasons/:preseasonId',
                    params: {
                        preseasonId: '@preseasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/preseasons/:preseasonId',
                    params: {
                        preseasonId: '@preseasonId'
                    }
                }
            }
        },
        
        /********** POSTSEASONS **********/
        
        postseasonStages: {
            url: 'api/postseasons',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/postseasons/:postseasonId',
                    params: {
                        seasonId: '@seasonId',
                        postseasonId: '@postseasonId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/postseasons',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/postseasons/:postseasonId',
                    params: {
                        postseasonId: '@postseasonId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/postseasons/:postseasonId',
                    params: {
                        postseasonId: '@postseasonId'
                    }
                }
            }
        },
        
        /********** EXHIBITIONS **********/
        
        exhibitionStages: {
            url: 'api/exhibitions',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/exhibitions/:exhibitionId',
                    params: {
                        seasonId: '@seasonId',
                        exhibitionId: '@exhibitionId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/exhibitions',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/exhibitions/:exhibitionId',
                    params: {
                        exhibitionId: '@exhibitionId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/exhibitions/:exhibitionId',
                    params: {
                        exhibitionId: '@exhibitionId'
                    }
                }
            }
        },
        
        /********** ROUNDS **********/
        
        roundStages: {
            url: 'api/rounds',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/rounds/:roundId',
                    params: {
                        seasonId: '@seasonId',
                        roundId: '@roundId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/rounds',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/rounds/:roundId',
                    params: {
                        roundId: '@roundId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/rounds/:roundId',
                    params: {
                        roundId: '@roundId'
                    }
                }
            }
        },
        
        /********** GAMES **********/
        
        games: {
            url: 'api/games',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/games/:gameId',
                    params: {
                        gameId: '@gameId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/games'
                },
                put: {
                    method: 'PUT',
                    url: 'api/games/:gameId',
                    params: {
                        gameId: '@gameId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/games/:gameId',
                    params: {
                        gameId: '@gameId'
                    }
                }
            }
        },
        gamePhotos: {
            url: 'api/games/:gameId/photos',
            methods: {

            }
        },
        gameVideos: {
            url: 'api/games/:gameId/videos',
            methods: {
 
            }
        },
        gamePlayerStats: {
            url: 'api/games/:gameId/player-stats',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/games/:gameId/player-stats/:statsId',
                    params: {
                        seasonId: '@seasonId',
                        statsId: '@statsId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/games/:gameId/player-stats',
                    params: {
                        gameId: '@gameId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/games/:gameId/layer-statss/:statsId',
                    params: {
                        gameId: '@gameId',
                        statsId: '@statsId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/games/:gameId/player-stats/:statsId',
                    params: {
                        gameId: '@gameId',
                        statsId: '@statsId'
                    }
                },
                deleteByGameId: {
                    method: 'DELETE',
                    url: 'api/games/:gameId/player-stats',
                    params: {
                        gameId: '@gameId'
                    }
                }
            }
        },
        
        /********** TEAMS **********/

        playerTeams: {
            url: '/api/players/:playerId/teams',
            methods: {
                show: {
                    method: 'GET',
                    url: '/api/players/:playerId/teams/:teamId',
                    params: {
                        playerId: '@playerId',
                        teamId: '@teamId'
                    }
                },
                save:{
                    method: 'POST',
                    url: '/api/players/:playerId/teams',
                    params: {
                        playerId: '@playerId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: '/api/players/:playerId/teams/:teamId',
                    params: {
                        playerId: '@playerId',
                        teamId: '@teamId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: '/api/players/:playerId/teams/:teamId',
                    params: {
                        playerId: '@playerId',
                        teamId: '@teamId'
                    }
                }
            }
        },

        /********** TEAMS **********/

        teams: {
            url: 'api/teams',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/teams/:teamId',
                    params: {
                        teamId: '@teamId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/teams',
                    params: {
                    },
                    transformRequest: formDataObject,
                    headers: {'Content-Type':undefined, enctype:'multipart/form-data'}

                },
                put: {
                    method: 'POST',
                    url: 'api/teams/:teamId',
                    params: {
                        teamId: '@teamId'
                    },
                    transformRequest: formDataObject,
                    headers: {'Content-Type':undefined, enctype:'multipart/form-data'}
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/teams/:teamId',
                    params: {
                        teamId: '@teamId'
                    }
                }
            }
        },
        divisionTeams: {
            url: '/api/divisions/:divisionId/teams',
            methods: {
                show: {
                    method: 'GET',
                    url: '/api/divisions/:divisionId/teams/:teamId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                },
                save:{
                    method: 'POST',
                    url: '/api/divisions/:divisionId/teams',
                    params: {
                        divisionId: '@divisionId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: '/api/divisions/:divisionId/teams/:teamId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: '/api/divisions/:divisionId/teams/:teamId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                }
            }
        },
        teamLeagues: {
            url: 'api/teams/:teamId/leagues',
            methods: {
 
            }
        },
        teamPlayers: {
            url: '/api/teams/:teamId/players',
            methods: {
                show: {
                    method: 'GET',
                    url: '/api/teams/:teamId/players/:playerId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                },
                save:{
                    method: 'POST',
                    url: '/api/teams/:teamId/players',
                    params: {
                        teamId: '@teamId'
                    }
                },
                put: {
                    method: 'PUT',
                    url: '/api/teams/:teamId/players/:playerId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: '/api/teams/:teamId/players/:playerId',
                    params: {
                        divisionId: '@divisionId',
                        teamId: '@teamId'
                    }
                }
            }
        },
        teamPhotos: {
            url: 'api/teams/:teamId/photos',
            methods: {
  
            }
        },
        teamVideos: {
            url: 'api/teams/:teamId/videos',
            methods: {
  
            }
        },
        teamStats: {
            url: 'api/teams/:teamId/stats',
            methods: {
                put: {
                    method: 'PUT',
                    url: 'api/teams/:teamId/stats/:gameId',
                    params: {
                        teamId: '@teamId',
                        gameId: '@gameId',
                        sport: '@sport',
                        final_score: '@final_score',
                        win: '@win',
                        loss: '@loss',
                        draw: '@draw'
                    }
                }
            }
        },

        
        /********** IMAGES **********/
        
        images: {
            url: 'api/images',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/images/:imageId',
                    params: {
                        seasonId: '@seasonId',
                        imageId: '@imageId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/images',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/images/:imageId',
                    params: {
                        imageId: '@imageId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/images/:imageId',
                    params: {
                        imageId: '@imageId'
                    }
                }
            }
        },
        
        /********** VIDEOS **********/
        
        videos: {
            url: 'api/videos',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/videos/:videoId',
                    params: {
                        seasonId: '@seasonId',
                        videoId: '@videoId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/videos',
                    params: {
                        
                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/videos/:videoId',
                    params: {
                        videoId: '@videoId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/videos/:videoId',
                    params: {
                        videoId: '@videoId'
                    }
                }
            }
        },


        divisions: {
            url: '/api/divisions',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/divisions/:divisionId',
                    params: {
                        divisionId: '@divisionId'
                    }
                },
                update: {
                    method: 'PUT',
                    url: 'api/divisions/:divisionId',
                    params: {
                        divisionId: '@divisionsId'
                    }
                }
            }
        },
        
        scheduleDemoRequest: {
            url: 'api/scheduledemo'
        },
        apparelRequest: {
            url: 'api/apparel'
        },
        contactSubmission: {
            url: 'api/contact'
        },
        serviceRequest: {
            url: 'api/service-requests',
        },
        packageRequest: {
            url: 'api/package-requests'
        },
        adminLeagues: {
            url: 'api/leagues'
        },
        loginUser: {
            url: '/admin/user-management/login-as/',
            methods: {
                get: {
                    method: 'GET',
                    params: { userId: '@userId'},
                    url: '/admin/user-management/login-as/:userId',
                }
            }
        },
        adminCode: {
            url: '/api/admin/code',
            methods: {
                get: {
                    method: 'GET',
                    params: { code: '@code'},
                    url: '/api/admin/code/:code',
                }
            }
        }, 
        organizations: {
            url: 'api/admin/organizations',
            methods: {
                put: {
                    method: 'PUT',
                    params: { id: '@id' },
                    url: 'api/admin/organizations/:id',
                },
                delete: {
                    method: 'DELETE',
                    params: { id: '@id' },
                    url: 'api/admin/organizations/:id'
                }
            }
        },

        /********** SPORTS **********/

        sports: {
            url: 'api/sports',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/sports/:sportId',
                    params: {
                        sportId: '@sportId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/sports',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/sports/:sportId',
                    params: {
                        sportId: '@sportId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/sports/:sportId',
                    params: {
                        sportId: '@sportId'
                    }
                }
            }
        },

        /********** FEATURES **********/

        features: {
            url: 'api/features',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/features/:featureId',
                    params: {
                        featureId: '@featureId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/features',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/features/:sportId',
                    params: {
                        featureId: '@featureId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/features/:sportId',
                    params: {
                        featureId: '@featureId'
                    }
                }
            }
        },

        /********** COUNTRIES **********/

        countries: {
            url: 'api/countries',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/countries/:countryId',
                    params: {
                        countryId: '@countryId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/countries',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/countries/:countryId',
                    params: {
                        countryId: '@countryId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/countries/:countryId',
                    params: {
                        countryId: '@countryId'
                    }
                }
            }
        },

        /********** SEASON STRUCTURES **********/

        seasonStructures: {
            url: 'api/season-structures',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/season-structures/:seasonStructureId',
                    params: {
                        seasonStructureId: '@seasonStructureId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/season-structures',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/season-structures/:seasonStructureId',
                    params: {
                        seasonStructureId: '@seasonStructureId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/season-structures/:seasonStructureId',
                    params: {
                        seasonStructureId: '@seasonStructureId'
                    }
                }
            }
        },

        /********** PLAYOFF STRUCTURES **********/

        playoffStructures: {
            url: 'api/playoff-structures',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/playoff-structures/:playoffStructureId',
                    params: {
                        playoffStructureId: '@playoffStructureId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/playoff-structures',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/playoff-structures/:playoffStructureId',
                    params: {
                        playoffStructureId: '@playoffStructureId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/playoff-structures/:playoffStructureId',
                    params: {
                        playoffStructureId: '@playoffStructureId'
                    }
                }
            }
        },

        /********** GAME STRUCTURES **********/

        gameStructures: {
            url: 'api/game-structures',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/game-structures/:gameStructureId',
                    params: {
                        gameStructureId: '@gameStructureId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/game-structures',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/game-structures/:gameStructureId',
                    params: {
                        gameStructureId: '@gameStructureId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/game-structures/:gameStructureId',
                    params: {
                        gameStructureId: '@gameStructureId'
                    }
                }
            }
        },

        /********** WEEKDAYS **********/

        weekdays: {
            url: 'api/weekdays',
            methods: {
                show: {
                    method: 'GET',
                    url: 'api/weekdayss/:weekdayId',
                    params: {
                        weekdayId: '@weekdayId'
                    }
                },
                save:{
                    method: 'POST',
                    url: 'api/weekdayss',
                    params: {

                    }
                },
                put: {
                    method: 'PUT',
                    url: 'api/weekdayss/:weekdayId',
                    params: {
                        weekdayId: '@weekdayId'
                    }
                },
                delete: {
                    method: 'DELETE',
                    url: 'api/season-structures/:weekdayId',
                    params: {
                        weekdayId: '@weekdayId'
                    }
                }
            }
        },
        notifications: {
            url: '/api/notifications/:notificationId',
            params: { notificationId: '@notificationId' },
            methods: {
                update: {
                    method: 'PUT'
                },
                clear: {
                    method: 'DELETE'
                },
                markAsConsumed: {
                    method: 'PUT'
                }
            }
        },
        autocompleteSearch: {
            url: '/api/auto-complete-search'
        },
        playerStats: {
            url: '/api/leagues/:league_id/games/:game_id/player-stats',
            params: { league_id: '@league_id', game_id: '@game_id' },
            methods: {
                update: {
                    method: 'PUT'
                }
            }
        },
        recoverPassword: {
            methods: {
                forgotPassword: {
                    method: 'POST',
                    url: '/password/email'
                },
                resetPassword: {
                    method: 'POST',
                    url: '/password/reset'
                }
            }
        }
    };

    /**
     * Method to get API based on $resource function
     * @param apiName
     * @returns {*}
     */
    factory.exec = function (apiName) {
        if(apiName in factory.apis){
            var $api = factory.apis[apiName];
            return $resource($api.url, ($api.params)?$api.params:{}, ($api.methods)?$api.methods:{});
        } else {
            throw new Error(apiName+' API not declared!');
        }
    };

    return factory;
}]);
