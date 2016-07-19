/*
 * Created by Eric Rho.
 * User: slack: erho87, skype: eric.rho
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description: Generating games
 *
 */
__Wooter.controller('Dashboard/ScheduleController', ['$scope', '$rootScope', '$stateParams', '$q', '$mdDialog','Page', 'API', 'Users', 'Weekdays', function ($scope, $rootScope, $stateParams, $q, $mdDialog, Page, API, Users, Weekdays) {
    loading();
    /*
     * Clean page (title, assets, favicon badge, etc.)
     */
    Page.reset();

    /*
     * Set Title Page
     */
    Page.title('Wooter | Schedule');

    /*
     * Set stylesheets
     */
    Page.stylesheets(['/css/dashboard/schedule.css', '/css/dashboard/management.css']);

    /*
     * Put here Action and Scopes
     */

    $scope.league_id = $stateParams.league_id;
    
    var gamesRequest = {
        leagueId: $stateParams.league_id,
        game_status: 'scheduled',
        limit: 10
    };

    /*
     * Get APIs
     */

    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leagueDivisionsAPI = API.exec('leagueDivisions');
    var $leagueVenuesAPI = API.exec('leagueGameVenues');
    var $leaguesAPI = API.exec('leagues');
    var $leagueGamesAPI = API.exec('leagueGames');
    var $leagueSeasonsAPI = API.exec('leagueSeasons');
    /*
     * Get/Set Data
     */

    $leaguesAPI.show({
        leagueId: $stateParams.league_id
    }, function(response) {
        var league = response.data;
        $scope.leagueName = league.name;
        $scope.league = response.data;
    });

    $leagueTeamsAPI.get({
        leagueId: $stateParams.league_id,
        all: true
    }, function(response) {
        $scope.teams = response.data.teams;
        $scope.numTeams = $scope.teams.length;
        $scope.synchronize();
    });
    
    $leagueSeasonsAPI.get({
        leagueId: $stateParams.league_id
    }, function(response) {
        $scope.season = response.data[0];
    });

     


    /**
    $seasonWeeksAPI.get({
        regularId: $stateParams.season_id
    }, function(response) {
          $scope.weeks = response.data;
    });
     */

    $leagueDivisionsAPI.get({
        leagueId: $stateParams.league_id
    }, function(response) {
        $scope.divisions = response.data;
    });

    $scope.synchronize = function(filters) {

        loading();

        $scope.filters = filters;

        $leagueGamesAPI.get(gamesRequest, function(response) {
            $scope.games = response.data.games;
            $scope.pages = response.data.pages;

            $scope.years = {};
            loaded();
            if ($scope.games.length == 0 || typeof $scope.games != 'object') {
                return;
            }

            $scope.games.forEach(function(game) {

                if (game.scored != 0) {
                    return;
                }

                if (typeof $scope.filters != 'undefined') {
                    if (typeof $scope.filters.team_to_filter != 'undefined'){
                        if (game.home_team_id != $scope.filters.team_to_filter && game.visiting_team_id != $scope.filters.team_to_filter) {
                            return;
                        }
                    }
                    if (typeof $scope.filters.venue_to_filter != 'undefined') {
                        if (game.game_venue.id != $scope.filters.venue_to_filter) {
                            return;
                        }
                    }
                }

                if (typeof $scope.years[game.year] == 'undefined') {
                    $scope.years[game.year] = {};

                    $scope.years[game.year].year = game.year;
                    $scope.years[game.year].weeks = {};
                }

                if (typeof $scope.years[game.year].weeks[game.week.week_of_year] == 'undefined') {
                    $scope.years[game.year].weeks[game.week.week_of_year] = {};

                    $scope.years[game.year].weeks[game.week.week_of_year].week_of_year = game.week.week_of_year;
                    $scope.years[game.year].weeks[game.week.week_of_year].start_day = game.week.start_day;
                    $scope.years[game.year].weeks[game.week.week_of_year].start_month = game.week.start_month;
                    $scope.years[game.year].weeks[game.week.week_of_year].end_day = game.week.end_day;
                    $scope.years[game.year].weeks[game.week.week_of_year].end_month = game.week.end_month;
                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day = {};

                }

                if (typeof $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day] == 'undefined') {
                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day] = {};

                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day].day = game.day;
                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day].month = game.month;
                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day].year = game.year;
                    $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day].games = [];
                }

                $scope.years[game.year].weeks[game.week.week_of_year].games_by_day[game.day].games.push(game);

            });
            //loaded();

        });

    };

        /**

        if ($scope.games.length > 0) {
            console.log('games exist');
            for (var i = 0; i < $scope.games.length; i++) {
            $scope.games[i].datetimeJs = $scope.ConvertDateToJsFormate($scope.games[i].datetime);
            date = $scope.games[i].date.split("/");
            $scope.games[i].dateTime = $scope.games[i].datetime;
            }

            $scope.games.sort(sortBy('week', {
                name: 'datetimeJs'
            }));

            $scope.setupSchedule();
            $scope.counter = 0;

            for (var w = 0; w < $scope.lengthWeeks; w++) {
                for (var d = 0; d < 7; d++) {
                    for (var s = 0; s < $scope.matches[w].schedule[d].slots.length; s++) {

                        $scope.games.map(function(game) {
                            if (game.dateTime === $scope.matches[w].schedule[d].slots[s].dateTime) {
                                $scope.matches[w].schedule[d].showWeek = true;
                                $scope.matches[w].schedule[d].slots[s].showGame = true;
                                $scope.matches[w].schedule[d].slots[s].game = game;
                            }
                        });

                        $scope.weeks.map(function(week) {
                            if ((week.start_date <= $scope.matches[w].schedule[d].slots[s].dateTime) &&
                                (week.end_date >= $scope.matches[w].schedule[d].slots[s].dateTime)) {
                                $scope.matches[w].weekId = week.id;
                            }
                        });
                    }
                }
            }
        } else {
            console.log('no games');
        }
         */


    $leagueVenuesAPI.get({
        leagueId: $stateParams.league_id,
        all: true
    }, function(response) {
        $scope.venues = response.data;
    });

    $scope.createSchedule = false;

    /**
    $scope.genScheduleAction = function() {
        $scope.createSchedule = true;
    };

    $scope.undoThing = function() {
        $scope.createSchedule = false;
    };
   

    $scope.$watch('pickDivision', function(divId) {
        $scope.currentDivision = divId;
        $leagueDivisionsAPI.get({
            leagueId: $stateParams.league_id,
            divisionId: $scope.currentDivision
        }, function(response)  {
            $scope.currentDivision = response.data;
            $scope.availTeams = [];
            if ($scope.teams) {
                for (var t = 0; t < $scope.teams.length; t++) {
                    if ($scope.teams[t] && $scope.teams[t].divisions[0] && $scope.teams[t].divisions[0].id === $scope.currentDivision.id) {
                        $scope.availTeams.push($scope.teams[t]);
                    } else if ($scope.currentDivision.length === $scope.divisions.length) {
                        $scope.availTeams.push($scope.teams[t]);
                    }
                }
            }
        });
    });



    $scope.$watch('gamesPerTeamPerWeek', function() {
        // console.log('GAMES PER WEEK = ', $scope.gamesPerTeamPerWeek);
    });
    */

    /*
     * HARD SET DATA FOR THE TIME BEING
     */
    //$scope.gamesPerTeamPerWeek;
    //$scope.gamesPerWeek = $scope.numTeams / 2;
    // $scope.games = [];
    // $scope.week = 1;
    //$scope.dates = [];
    /*
     * END HARD SET DATA
     */

    $scope.addGame = function(ev) {
        $mdDialog.show({
            parent: angular.element(document.body),
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/addGame.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };

    $scope.editGame = function(ev, game) {
        $scope.gameToEdit = game;
        $scope.dateToEdit = new Date(game.time.date);
        $scope.timeToEdit = new Date(game.time.date);

        $mdDialog.show({
            parent: angular.element(document.body),
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/editGame.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };

    $scope.deleteGame = function(ev, game) {
        $scope.gameIdToDelete = game.id;

        var parentEl = angular.element(document.body);
        $mdDialog.show({
            parent: parentEl,
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/deleteGame.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };

    $scope.clearSchedule = function(ev) {
        $scope.gamesToDelete = $scope.games;
        $mdDialog.show({
            parent: angular.element(document.body),
            controller: getControllerName('Modals/Dashboard/GamesModalController'),
            templateUrl: logicTemplate('modals/dashboard/schedule/clearSchedule.html'),
            scope: $scope,
            preserveScope: true,
            targetEvent: ev,
            clickOutsideToClose: true
        });
    };

    $scope.filter = function() {

    }


    /**
    $scope.otherThing = false;
    $scope.allGames = [];
    $scope.genSchedule = function() {

        $scope.setupSchedule();

        // Temporary placeholder
        if ($scope.gamesPerTeamPerWeek * ($scope.availTeams.length / 2) > $scope.timeSlots.length) {
            alert('There are not enough timeslots to support this schedule');
            return;
        } else if ($scope.gamesPerTeamPerWeek <= 0 || $scope.gamesPerTeamPerWeek === undefined) {
            alert('You have not yet set how many games each team will play each week');
            return;
        }

        // End temporary placeholder

        $seasonWeeksAPI.get({
            regularId: $stateParams.season_id
        }, function(response) {
            $scope.regularCompetitionWeeks = response.data;
            if ($scope.regularCompetitionWeeks) {
                for (var i = 0; i < $scope.regularCompetitionWeeks.length; i++) {
                    $seasonWeeksAPI.delete({
                        regularId: $stateParams.season_id,
                        competitionWeekId: $scope.regularCompetitionWeeks[i].id
                    }, function(response) {
                        console.log('DELETED WEEK', response.data);
                    });
                }
            }
        });

        for (var w = 0; w < $scope.lengthWeeks; w++) {
            var year = $scope.startDate.getFullYear(),
                month = $scope.startDate.getMonth(),
                day = $scope.startDate.getDate();
            (function(w) {

                weekStartDate = $scope.ConvertDateToSqlFormate($scope.matches[w].schedule[0].day);
                weekEndDate = $scope.ConvertDateToSqlFormate($scope.matches[w].schedule[6].day);

                $week = {
                    stage_id: $stateParams.season_id,
                    // stage_type: 'Wooter\\SeasonCompetition',
                    stage_type: 'Wooter\\RegularStage',
                    name: 'Week ' + (w + 1),
                    starts_at: weekStartDate,
                    ends_at: weekEndDate
                };

                $seasonWeeksAPI.save({
                    regularId: $stateParams.season_id
                }, $week, function(res) {
                    var weekId = res.data.id;
                    $scope.weeks.push($week);
                    $scope.createGames(w, weekId);
                });
            })(w);
        }
        $scope.createSchedule = false;
        $scope.otherThing = true;

        return;
    };

    $scope.weekSchedule = function() {
        $scope.weekGames = [];
        for (var i = 0; i < $scope.gamesPerTeamPerWeek; i++) {
            for (var j = 0; j < $scope.availTeams.length / 2; j++) {
                var team_1 = $scope.availTeams[j];

                if (($scope.availTeams.length - j) === $scope.availTeams.length) {
                    var team_2 = $scope.availTeams[($scope.availTeams.length - 1)];
                } else {
                    team_2 = $scope.availTeams[($scope.availTeams.length - (j + 1))];
                }
                var matchUp = [];
                matchUp.push({
                    home_team: team_1,
                    visiting_team: team_2
                });
                $scope.weekGames.push(matchUp);
            }
            $scope.rotate();
        }
    };

    $scope.createGames = function(w, weekId) {
        $scope.weekSchedule();
        for (var d = 0; d < 7; d++) {

            var currentDay = $scope.matches[w].schedule[d].day;
            var matchDate =  $scope.matches[w].schedule[d].date;

            for (var s = 0; s < $scope.matches[w].schedule[d].slots.length; s++) {
                $scope.matches[w].weekId = weekId;
                $scope.matches[w].schedule[d].slots[s].teams = $scope.weekGames.shift();

                if ($scope.matches[w].schedule[d].slots[s].teams) {
                    $scope.matches[w].schedule[d].showWeek = true;
                    $scope.matches[w].schedule[d].slots[s].showGame = true;
                    var time = $scope.matches[w].schedule[d].slots[s].slot.starts_at;

                    gameDate = matchDate + " " + time;

                    $requestData = {
                        home_team_id: $scope.matches[w].schedule[d].slots[s].teams[0].home_team.id,
                        visiting_team_id: $scope.matches[w].schedule[d].slots[s].teams[0].visiting_team.id,
                        location_id: $scope.matches[w].schedule[d].slots[s].slot.game_venue.id,
                        game_structure_id: 1,
                        sport_id: $scope.league.sport_id,
                        competition_week_id: $scope.matches[w].weekId,
                        stage_id: $stateParams.season_id,
                        stage_type: 'Wooter\\RegularStage',
                        time: gameDate
                    };

                    $gamesAPI.save({
                    }, $requestData, function(res) {
                        console.log('GAME ADDED', res);
                    });

                    var game = $requestData;

                    game.home_team = $scope.matches[w].schedule[d].slots[s].teams[0].home_team.name;
                    game.visiting_team = $scope.matches[w].schedule[d].slots[s].teams[0].visiting_team.name;

                    $scope.games.push(game);
                    $scope.matches[w].schedule[d].slots[s].game = game;
                }
            }
        }
    };

    $scope.setupSchedule = function() {
        $scope.matches = [];

        for (var w = 0; w < $scope.lengthWeeks; w++) {

            var year = $scope.startDate.getFullYear(),
                month = $scope.startDate.getMonth(),
                day = $scope.startDate.getDate();

            $scope.matches.push({
                week: (w + 1),
                weekId: "",
                schedule: []
            });
            for (var d = 0; d < 7; d++) {
                var currentDay = new Date(year, month, day + (w * 7) + d);
                var slotDate = $scope.ConvertDateToSqlFormate(new Date(year, month, day + (w * 7) + d));

                $scope.matches[w].schedule.push({
                    showWeek:false,
                    day: currentDay,
                    date: slotDate,
                    slots: []
                });

                if ($scope.matches[w].schedule[d].day.getDay() === 0) {
                    if($scope.sundaySlots) {
                        for (var a = 0; a < $scope.sundaySlots.length; a++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.sundaySlots[a], dateTime:slotDate+ " "+$scope.sundaySlots[a].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[a].game = '';
                            $scope.matches[w].schedule[d].slots[a].showGame = false;
                            //$scope.matches[w].schedule[d].show = true;
                        }
                    }
                }  else if ($scope.matches[w].schedule[d].day.getDay() === 1) {
                    if ($scope.mondaySlots) {
                        for (var b = 0; b < $scope.mondaySlots.length; b++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.mondaySlots[b], dateTime:slotDate+ " "+$scope.mondaySlots[b].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[b].game = '';
                            //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[b].showGame = false;
                        }
                    }
                } else if ($scope.matches[w].schedule[d].day.getDay() === 2) {
                    if ($scope.tuesdaySlots) {
                        for (var c = 0; c < $scope.tuesdaySlots.length; c++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.tuesdaySlots[c], dateTime:slotDate+ " "+$scope.tuesdaySlots[c].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[c].game = '';
                            //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[c].showGame = false;
                        }
                    }
                } else if ($scope.matches[w].schedule[d].day.getDay() === 3) {
                    if($scope.wednesdaySlots) {
                        for (var e = 0; e < $scope.wednesdaySlots.length; e++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.wednesdaySlots[e], dateTime:slotDate+ " "+$scope.wednesdaySlots[e].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[e].game = '';
                           //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[e].showGame = false;
                        }
                    }
                } else if ($scope.matches[w].schedule[d].day.getDay() === 4) {
                    if ($scope.thursdaySlots) {
                        for (var f = 0; f < $scope.thursdaySlots.length; f++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.thursdaySlots[f], dateTime:slotDate+ " "+$scope.thursdaySlots[f].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[f].game = '';
                            //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[f].showGame = false;
                        }
                    }
                } else if ($scope.matches[w].schedule[d].day.getDay() === 5) {
                    if ($scope.fridaySlots) {
                        for (var g = 0; g < $scope.fridaySlots.length; g++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.fridaySlots[g], dateTime:slotDate+ " "+$scope.fridaySlots[g].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[g].game = '';
                            //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[g].showGame = false;
                        }
                    }
                } else {
                    if ($scope.saturdaySlots) {
                        for (var h = 0; h < $scope.saturdaySlots.length; h++) {
                            $scope.matches[w].schedule[d].slots.push({slot: $scope.saturdaySlots[h], dateTime:slotDate+ " "+$scope.saturdaySlots[h].starts_at, teams: []});
                            $scope.matches[w].schedule[d].slots[h].game = '';
                            //$scope.matches[w].schedule[d].show = true;
                            $scope.matches[w].schedule[d].slots[h].showGame = false;

                        }
                    }
                }
            }
        }
    };

    $scope.hideModal = function() {
        $mdDialog.hide();
    };

    $scope.shuffleTeams = function() {
        var currentIndex = ($scope.numTeams - 1),
            tempValue, randomIndex;
        for (f = currentIndex; f > 0; f--) {
            randomIndex = Math.floor(Math.random() * currentIndex);
            tempValue = $scope.teams[currentIndex];
            $scope.teams[currentIndex] = $scope.teams[randomIndex];
            $scope.teams[randomIndex] = tempValue;
        }
    };

    $scope.rotate = function() {
        $scope.availTeams.move([$scope.availTeams.length - 1], 1);
    };

    Array.prototype.move = function(oldInd, newInd) {
        if (newInd >= this.length) {
            var k = newInd - this.length;
            while ((k--) +1) {
                this.push(undefined);
            }
        }
        this.splice(newInd, 0, this.splice(oldInd, 1)[0]);
    };

    Date.prototype.toMySQLFormat = function() {
        return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
    };

    var twoDigits = function(d) {
        if (0 <= d && d < 10) return '0' + d.toString();
        if (-10 < d && d < 0) return '-0' + (-1 * d).toString();
        return d.toString();
    };

    $scope.ConvertDateToJsFormate = function(mysqlDate) {
        var t, result = null;

        if ( typeof mysqlDate === 'string' ) {
            t = mysqlDate.split(/[- :]/);
            //when t[3], t[4] and t[5] are missing they defaults to zero
            result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
        }
        return result;
    };

    $scope.ConvertDateToSqlFormate = function(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    };


     */
    
    /**
     * Get games by offset
     * @param gamesRequest
     * @param offset
     */
    var getGamesByOffset = function(gamesRequest, offset) {
        
        gamesRequest.offset = offset;
        $scope.synchronize();
        /*$leagueGamesAPI.get(gamesRequest, function (response) {
            $scope.synchronize(response.data);
        });*/
    };
    
    var gamesOffset = 0;
    $scope.gamesIndex = 1;
    
    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        loading();

        $scope.gamesIndex++;
        gamesOffset += 10;
                
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        loading();

        $scope.gamesIndex = $scope.pages;
        gamesOffset = ($scope.pages * 10) - 10;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        loading();

        $scope.gamesIndex--;
        gamesOffset -= 10;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };

    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        loading();

        $scope.gamesIndex = 1;
        gamesOffset = 0;
        
        getGamesByOffset(gamesRequest, gamesOffset);
    };
    
    $scope.getGamesByTeamId = getGamesByOffset;
    $scope.navNext = navNext;
    $scope.navLast = navLast;
    $scope.navPrev = navPrev;
    $scope.navFirst = navFirst;
}]);
