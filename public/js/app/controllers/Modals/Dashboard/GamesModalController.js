/**
 * Created by Eric Rho
 * User: slack: erho87 skype: eric.rho
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.04.27
 * Description: Controller for game modals. Edit/Add/Delete
 *
 */
__Wooter.controller('Modals/Dashboard/GamesModalController', ['$scope', '$stateParams', '$mdDialog', 'Page', 'API', 'uiGmapGoogleMapApi', function ($scope, $stateParams, $mdDialog, Page, API, uiGmapGoogleMapApi) {

	var $leaguesAPI = API.exec('leagues');
    var $gamesAPI = API.exec('games');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leagueVenuesAPI = API.exec('leagueGameVenues');
    var $leagueGamesAPI = API.exec('leagueGames');
    var $countriesAPI = API.exec('countries');

	$leagueTeamsAPI.get({
		leagueId: $stateParams.league_id,
        all: true
	}, function(response) {
		$scope.teams = response.data.teams;
                console.log($scope.teams);
		$scope.homeTeams = $scope.teams;
	});

    $leagueVenuesAPI.get({
        leagueId: $stateParams.league_id
    }, function(response) {
        $scope.leagueGameVenues = response.data;
    });

    /**
	$leagueWeeksAPI.get({
		regularId: $stateParams.season_id
	}, function(response) {
		$scope.weeks = response.data;

		for (var i = 0; i < $scope.weeks.length; i++) {
			$scope.weeks[i].starts_at = new Date($scope.weeks[i].starts_at);
			$scope.weeks[i].ends_at = new Date($scope.weeks[i].ends_at);
		}
	});
     */

	var leagueId = $stateParams.league_id;


    /**
    $scope.setAvailableSlots = function(week){
        slotCounter = 0;
        $scope.availableSlots = [];
        for (var w = 0; w < $scope.lengthWeeks; w++) {
            for (var d = 0; d < 7; d++) {
                for (var s = 0; s < $scope.matches[w].schedule[d].slots.length; s++) {

                   if (!$scope.matches[w].schedule[d].slots[s].showGame && $scope.matches[w].weekId == week) {
                       finish_at = $scope.matches[w].schedule[d].slots[s].slot.finish_at;
                       date = $scope.matches[w].schedule[d].date;
                       league_game_venue_name = $scope.matches[w].schedule[d].slots[s].slot.league_game_venue_name;
                       starts_at = $scope.matches[w].schedule[d].slots[s].slot.starts_at;
                       weekday = $scope.matches[w].schedule[d].slots[s].slot.weekday;
                       $scope.availableSlots.push({ 'id':slotCounter, 'finish_at':finish_at, 'league_game_venue_name': league_game_venue_name, 'starts_at': starts_at, 'weekday':weekday, 'date':date});
                       slotCounter++;
                   }
                }
            }
        }
    };

     */

	$scope.addGameInModal = function() {
		$leaguesAPI.show({
			leagueId: leagueId
		}, function(response) {
                    
            var month = $scope.date.getMonth() + 1;
            var date = $scope.date.getDate();
            var hours = $scope.time.getHours();
            var minutes = $scope.time.getMinutes();
            var seconds = $scope.time.getSeconds();
			var normalizedTime;
                        
            normalizedTime = $scope.date.getFullYear();
            normalizedTime += (month.toString().length < 2) ? '-0' + month : '-' + month;
            normalizedTime += (date.toString().length < 2) ? '-0' + date : '-' + date;
            normalizedTime += (hours.toString().length < 2) ? ' 0' + hours + ':' : ' ' + hours + ':';
            normalizedTime += (minutes.toString().length < 2) ? '0' + minutes + ':' : minutes + ':';
            normalizedTime += (seconds.toString().length < 2) ? '0' + seconds : seconds;

			var requestData = {
				home_team_id: $scope.homeTeamId,
				visiting_team_id: $scope.visitingTeamId,
				game_venue_id: $scope.leagueGameVenueId,
				sport_id: response.data.sport_id,
				stage_id: response.data.seasons[0].regulars[0].id,
                stage_type: response.data.seasons[0].regulars[0].type,
				time: normalizedTime
			};

			$gamesAPI.save(requestData, function(response) {

                $scope.homeTeamId = undefined;
                $scope.visitingTeamId = undefined;
                $scope.leagueGameVenueId = undefined;
                $scope.date = undefined;
                $scope.time = undefined;

                $scope.synchronize();
			});
		});
		$mdDialog.hide();
	};

	$scope.deleteGameInModal = function(gameId) {
		$gamesAPI.delete({
			gameId: gameId
		}, function() {
            $scope.synchronize();
        });

		$mdDialog.hide();
	};
        
        $scope.deleteCompletedGame = function(gameId) {
            $gamesAPI.delete({
                gameId: gameId
            }, function() {
                $scope.$leagueGamesApi.get($scope.gamesRequest, $scope.displayGames);
            });
            
            $mdDialog.hide();
        };

	$scope.editGameInModal = function(gameId) {
        $leaguesAPI.show({
            leagueId: leagueId
        }, function(response) {

            var month = $scope.dateToEdit.getMonth() + 1;
            var date = $scope.dateToEdit.getDate();
            var hours = $scope.timeToEdit.getHours();
            var minutes = $scope.timeToEdit.getMinutes();
            var seconds = $scope.timeToEdit.getSeconds();
            var normalizedTime;

            normalizedTime = $scope.dateToEdit.getFullYear();
            normalizedTime += (month.toString().length < 2) ? '-0' + month : '-' + month;
            normalizedTime += (date.toString().length < 2) ? '-0' + date : '-' + date;
            normalizedTime += (hours.toString().length < 2) ? ' 0' + hours + ':' : ' ' + hours + ':';
            normalizedTime += (minutes.toString().length < 2) ? '0' + minutes + ':' : minutes + ':';
            normalizedTime += (seconds.toString().length < 2) ? '0' + seconds : seconds;

            var requestData = {
                gameId: gameId,
                home_team_id: $scope.homeTeamIdToEdit,
                visiting_team_id: $scope.visitingTeamIdToEdit,
                game_venue_id: $scope.leagueGameVenueIdToEdit,
                sport_id: response.data.sport_id,
                stage_id: response.data.seasons[0].regulars[0].id,
                stage_type: response.data.seasons[0].regulars[0].type,
                time: normalizedTime
            };

            $gamesAPI.put(requestData, function(response) {
                $scope.synchronize();
            });
        });
        $mdDialog.hide();
	};

    $scope.addGameVenue = function(ev, method, gameToEdit) {

        $countriesAPI.get(function(response) {
            $scope.countries = response.data;
            $scope.defaultCountry = 236;
        });
        $scope.event = ev;
        $scope.gameVenueMethod = method;
        $scope.gameToEdit = gameToEdit;

        var parentEl = angular.element(document.body);
        $mdDialog.show({
            parent: parentEl,
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/addGameVenue.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };

    $scope.addGameVenueInModal = function (er) {
        if(count(er.$error) > 0){
            $$notify.create({
                message: 'Make sure all data fields are correct!',
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        } else {
            function fullAddress(data) {
                data.countryName = 'United States'; // default

                angular.forEach($scope.countries, function(val){
                    if(val.id == data.game_venue.location.country_id){
                        data.countryName = val.name;
                    }
                });

                data.flat = (data.game_venue.location.flat)?data.game_venue.location.flat+',':'';
                data.street = data.game_venue.location.street;
                data.city_name = data.game_venue.location.city_name;
                data.state = data.game_venue.location.state;
                data.zip = data.game_venue.location.zip;
                return tpl('{flat} {street}, {city_name}, {countryName}, {state} {zip}', data);
            }
            $scope.$addVenue.game_venue.location.state = $scope.$addVenue.game_venue.location.state.toUpperCase();

            uiGmapGoogleMapApi.then(function(gmaps) {

                var geocoder = new gmaps.Geocoder();
                geocoder.geocode( { 'address': $scope.$addVenue.game_venue.location.zip }, function(results, status) {
                    if (status == gmaps.GeocoderStatus.OK) {


                        var data =  {
                            leagueId: leagueId,
                            name: $scope.$addVenue.game_venue.location.name,
                            full_address: fullAddress($scope.$addVenue),
                            country_id: $scope.$addVenue.game_venue.location.country_id,
                            street: $scope.$addVenue.game_venue.location.street,
                            city_name: $scope.$addVenue.game_venue.location.city_name,
                            flat: ($scope.$addVenue.flat)?$scope.$addVenue.game_venue.location.flat:'',
                            state: $scope.$addVenue.game_venue.location.state,
                            zip_code: $scope.$addVenue.game_venue.location.zip,
                            number_of_courts: $scope.$addVenue.game_venue.number_of_courts,
                            court_name: $scope.$addVenue.game_venue.court_name,
                            longitude: results[0].geometry.location.lng(),
                            latitude: results[0].geometry.location.lat()
                        };

                        $leagueVenuesAPI.save(data, function (res) {
                            $scope.leagueGameVenues.push(res.data);

                            $mdDialog.cancel();

                            if ($scope.gameVenueMethod == 'edit') {
                                $scope.editGame($scope.event, $scope.gameToEdit);
                            } else {
                                $scope.addGame($scope.event);
                            }

                            $$notify.create({
                                message: 'Done! Game venue added.',
                                type: 'success',
                                fontIcon: 'material',
                                icon: 'check'
                            });
                        }, function () {
                            loaded();
                            $$notify.create({
                                message: tpl('Error: Game venue not saved, try again later!', model),
                                type: 'error',
                                fontIcon: 'material',
                                icon: 'error_outline'
                            });
                        });

                    } else {
                        $$notify.create({
                            message: "Something went wrong, check zip code and try again!",
                            inverse: true,
                            type: 'error',
                            fontIcon: 'material',
                            icon: 'error_outline'
                        })
                    }
                });
            });
        }

        return false;
    };

    $scope.clearScheduleInModal = function() {

        loading();
        
        $leagueGamesAPI.get({
            leagueId: $stateParams.league_id,
            scheduled: true,
            all: true
        }, function(response) {
            $scope.games = response.data.games;

            if ($scope.games.length == 0 || typeof $scope.games != 'object') {
                return;
            }

            $scope.games.forEach(function (game) {

                if (game.scored != 0) {
                    return;
                }
                loading();

                $gamesAPI.delete({
                    gameId: game.id
                }, function() {
                    $scope.synchronize();
                });
            });
        });

		$mdDialog.hide();
	};
        
    $scope.hideModal = function() {
        $mdDialog.hide();
    };

}]);
