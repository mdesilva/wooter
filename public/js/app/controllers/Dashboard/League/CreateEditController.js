/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: Leagues
 * License: Wooter LLC.
 * Date: 2016.04.12
 * Description: Create Edit leagues
 *
 */
__Wooter.controller('Dashboard/League/CreateEditController', ['$scope', 'Page', '$state', '$stateParams', '$timeout', '$interval', '$mdDialog', 'API', 'Authentify', 'LeagueCreateEdit', 'Weekdays', 'DayHours','$location','$http', function ($scope, Page, $state, $stateParams, $timeout, $interval, $mdDialog, API, Authentify, LeagueCreateEdit, Weekdays, DayHours,$location,$http) {

    if($stateParams.step){
        $stateParams.step = $stateParams.step.toString().toLowerCase();
    }

    if(LeagueCreateEdit.GET.steps().indexOf($stateParams.step) == -1){
        $state.go($state.current.name, {step: LeagueCreateEdit.GET.steps()[0]});
    } else {
        Page.reset();
        Page.css(['css/dashboard/league-create-edit.css']);



        /* ------------------------------------------------- Vars ------------------------------------------------------- */

        var STORE_KEY = isState('edit', function (state, val) {
            $ret = (val)?'league_edit_model':'league_create_model';
            $$store.session.set('STORE_KEY', $ret);
            return $ret;
        });

        var $api = {
            leagues: API.exec('leagues'),
            sports: API.exec('sports'),
            features: API.exec('features'),
            countries: API.exec('countries'),
            weekdays: API.exec('weekdays'),
            leagueBasics: API.exec('leagueBasics'),
            leagueDetails: API.exec('leagueDetails'),
            leagueFeatures: API.exec('leagueFeatures'),
            leagueGameVenues: API.exec('leagueGameVenues'),
            leaguePhotos: API.exec('leaguePhotos'),
            leaguePrices: API.exec('leaguePrices'),
            leagueSeasons: API.exec('leagueSeasons')
        };

        $scope.isState = isState;

        $scope.currentState = $scope.isState();
        $scope.leagueID = LeagueCreateEdit.GET.leagueID();

        if ($scope.currentState == 'dashboardLeagueEdit') {
            $api.leagueSeasons.get({
                leagueId: $scope.leagueID
            }, function (res) {
                $scope.seasonID = res.data[0].id;
            });
        } else {
            $scope.seasonID = LeagueCreateEdit.GET.seasonID();
        }

        $scope.steps = LeagueCreateEdit.GET.steps();
        $scope.hours = DayHours;

        var sports = $api.sports.get();
        var features = $api.features.get();
        var countries = $api.countries.get();
        var weekdays = $api.weekdays.get();

        var $actions = {
            venues: {
                add: function (data) {
                    $scope.$addVenue.number_of_courts = true;
                    $scope.$addVenue.edit = false;
                    showModal(data.event, 'add-venue');
                },
                edit: function (data) {
                    $scope.$addVenue = LeagueCreateEdit.GET.dataById(data.id, $scope.venues);

                    $scope.$addVenue.edit = true;
                    showModal(data.event, 'add-venue');
                },
                delete: function (data) {
                    $api.leagueGameVenues.delete({
                        leagueId: $scope.leagueID,
                        gameVenueId: data.id
                    }, function (res) {
                        angular.element('.venue-'+data.id).slideUp(500, function () {
                            $(this).remove();
                            $scope.$apply();
                            cacheData();
                        });
                    }, function (res) {
                        $$notify.create('Game Venue couldn\'t delete!', 'error');
                    });
                },
                update: function (data) {
                    if(LeagueCreateEdit.GET.leagueID()){
                        $scope.venuesError = false;
                        $scope.venuesLoading = true;
                        $api.leagueGameVenues.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {
                            $scope.venues = res.data;
                            $scope.venuesLoading = false;
                        }, function (res) {
                            $scope.venuesError = true;
                            $scope.venuesLoading = false;
                        });
                    }
                }
            },
            price: {
                add: function (data) {
                    showModal(data.event, 'add-price');
                },
                edit: function (data) {
                    $scope.$addPrice = LeagueCreateEdit.GET.dataById(data.id, $scope.prices);
                    $scope.$addPrice.edit = true;
                    showModal(data.event, 'add-price');
                },
                delete: function (data) {
                    $api.leaguePrices.delete({
                        leagueId: $scope.leagueID,
                        priceId: data.id
                    }, function (res) {
                        angular.element('.price-'+data.id).slideUp(500, function () {
                            $(this).remove();
                            ACTION('update', 'price', {});
                        });
                    }, function (res) {
                        $$notify.create('Price couldn\'t delete!', 'error');
                    });
                },
                update: function (data) {
                    $scope.pricesError = false;
                    $scope.pricesLoading = true;
                    $api.leaguePrices.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {
                        $scope.prices = res.data;
                        $scope.pricesLoading = false;
                    }, function (res) {
                        $scope.pricesError = true;
                        $scope.pricesLoading = false;
                    });
                }
            },
            images: {
                delete: function (data) {

                    $api.leaguePhotos.delete({
                        leagueId: $scope.leagueID,
                        photoId: data.imageId
                    }, function () {
                        var img = angular.element('li.image-'+data.id);
                        img.find('a').css('width', img.find('a').outerWidth());
                        img.find('a').css('height', img.find('a').outerHeight());
                        img.addClass('removing');

                        $timeout(function () {
                            img.addClass('remove');
                            $timeout(function () {
                                img.remove();
                                $scope.$step.model.gallery.images.photos = LeagueCreateEdit.Destroy.imageById(data.id, $scope.$step.model.gallery.images.photos);
                                $scope.$apply();
                                cacheData();
                            }, 300);
                        }, 300);

                    }, function(){
                        $$notify.create('Something went wrong!', 'error');
                    })
                }
            },
            basics: {
                update: function (data) {
                    if(LeagueCreateEdit.GET.leagueID()){
                        $api.leagueBasics.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {
                            $scope.$step.model.basics = res.data;

                        }, function (res) {
                        });
                    }
                }
            },
            details: {
                update: function (data) {
                    if(LeagueCreateEdit.GET.leagueID()){
                        $api.leagueDetails.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {
                            $scope.$step.model.details = res.data;

                        }, function (res) {
                        });
                    }
                }
            },
            features: {
                update: function (data) {
                    if(LeagueCreateEdit.GET.leagueID()){
                        $api.leagueFeatures.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {

                            $scope.$step.model.features = [];

                            if (res.data instanceof Array) {
                                res.data.forEach(function(leagueFeature) {
                                    $scope.$step.model.features[leagueFeature.feature_id] = true;
                                })
                            } else {
                                $scope.$step.model.features[res.data.feature_id] = true;
                            }
                        }, function (res) {
                        });
                    }
                }
            },
            season: {
                update: function (data) {
                    
                    if(LeagueCreateEdit.GET.leagueID()){
                        $api.leagueSeasons.get({leagueId: LeagueCreateEdit.GET.leagueID()}, function (res) {
                            $scope.$step.model.season = res.data[0];

                            $scope.$step.model.season.starts_at = new Date(res.data[0].starts_at);
                            $scope.$step.model.season.ends_at = new Date(res.data[0].ends_at);
                            $scope.$step.model.season.registration_opens_at = new Date(res.data[0].registration_opens_at);
                            $scope.$step.model.season.registration_closes_at = new Date(res.data[0].registration_closes_at);

                        }, function (res) {
                        });
                    }
                }
            }
        };

        var $methods = {
            save: {
                basics: function(model, step, after){
                    var request = {
                        name: model.league_name,
                        sport_id: model.sport
                    };

                    $api.leagues.save(request, function (res) {
                        var $data = res.data;
                        $scope.leagueID = $data.id;
                        var logo = document.getElementById('logo').files[0];

                        LeagueCreateEdit.Save.leagueID($data.id);
                        LeagueCreateEdit.Save.seasonID($data.seasons[0].id);

                        var basicsCFG = {
                            leagueId: $scope.leagueID,
                            min_age: model.min_age,
                            max_age: model.max_age,
                            gender: model.gender,
                            logo: logo
                        };

                        $api.leagueBasics.save(basicsCFG, function (res) {
                            LeagueCreateEdit.Save.step(step);
                            
                            $scope.$step.model.basics = res.data;
                            $$store.session.set('create_continue', true);
                            cacheData();
                            after();
                        }, function () {
                            loaded();
                            $$notify.create('Something went wrong!', 'error');
                        })
                    }, function () {
                        loaded();
                        $$notify.create('Something went wrong!', 'error');
                    });
                },
                details: function (model, step, after) {
                    var request = {
                        leagueId: LeagueCreateEdit.GET.leagueID(),
                        description: model.description,
                        number_of_teams: model.number_of_teams,
                        players_per_team: model.players_per_team,
                        games_per_team: model.games_per_team,
                        game_duration: model.game_duration
                    };

                    $api.leagueDetails.save(request, function (res) {
                        $scope.$step.model[step].detailsId = res.data.id;
                        cacheData();
                        LeagueCreateEdit.Save.step(step);
                        after();
                    }, function () {
                        loaded();
                        $$notify.create('Something went wrong, data not stored, try again later!', 'error');
                    });
                },
                gallery: function (model, step, after) {
                    LeagueCreateEdit.Save.step(step);
                    after();
                },
                season: function(model, step, after){
                    var request = {
                        leagueId: LeagueCreateEdit.GET.leagueID(),
                        seasonId: LeagueCreateEdit.GET.seasonID(),
                        name: model.name,
                        starts_at: normalizeDatepicker(model.starts_at),
                        ends_at: normalizeDatepicker(model.ends_at),
                        registration_opens_at: normalizeDatepicker(model.registration_opens_at),
                        registration_closes_at: normalizeDatepicker(model.registration_closes_at),
                        max_teams: model.max_teams,
                        max_free_agents: model.max_free_agents
                    };

                    $api.leagueSeasons.put(request, function (res) {
                        LeagueCreateEdit.Save.step(step);
                        after();
                    }, function (res) {
                        loaded();
                        $$notify.create('Something went wrong!', 'error');
                    });
                },
                pricing: function (model, step, after) {
                    LeagueCreateEdit.Save.step(step);
                    after();
                }
            },
            edit: {
                basics: function(model, step, after){
                    
                    if (angular.isUndefined(model)) {
                        var request = {
                            leagueId: $scope.leagueID,
                            name: $scope.$step.model.basics.league_name,
                            sport_id: $scope.$step.model.basics.sport
                        };
                    } else {
                        var request = {
                            leagueId: $scope.leagueID,
                            name: model.league_name,
                            sport_id: model.sport
                        };
                    }

                    $api.leagues.put(request, function (res) {
                        var $data = res.data;
                        $scope.leagueID = $data.id;
                        var logo = document.getElementById('logo').files[0];

                        if (angular.isUndefined(model)) { 
                            var basicsCFG = {
                                leagueId: $scope.leagueID,
                                min_age: $scope.$step.model.basics.min_age,
                                max_age: $scope.$step.model.basics.max_age,
                                gender: $scope.$step.model.basics.gender,
                                _method: "PUT",
                                logo: logo
                            };
                        } else {
                            var basicsCFG = {
                                leagueId: $scope.leagueID,
                                min_age: model.min_age,
                                max_age: model.max_age,
                                gender: model.gender,
                                _method: "PUT",
                                logo: logo
                            };
                        }

                        $api.leagueBasics.put(basicsCFG, function(res) {
                            LeagueCreateEdit.Save.step(step);
                            LeagueCreateEdit.Save.leagueID($data.id);
                            after();
                        }, function () {
                            loaded();
                            $$notify.create('Something went wrong!', 'error');
                        })
                    }, function () {
                        loaded();
                        $$notify.create('Something went wrong!', 'error');
                    });
                },
                details: function (model, step, after) {
                    if (angular.isUndefined(model)) {
                        var request = {
                            leagueId: LeagueCreateEdit.GET.leagueID(),
                            description: $scope.$step.model.details.description,
                            number_of_teams: $scope.$step.model.details.number_of_teams,
                            players_per_team: $scope.$step.model.details.players_per_team,
                            games_per_team: $scope.$step.model.details.games_per_team,
                            game_duration: $scope.$step.model.details.game_duration
                        };
                    } else {
                        var request = {
                            leagueId: LeagueCreateEdit.GET.leagueID(),
                            description: model.description,
                            number_of_teams: model.number_of_teams,
                            players_per_team: model.players_per_team,
                            games_per_team: model.games_per_team,
                            game_duration: model.game_duration
                        };
                    }

                    $api.leagueDetails.put(request, function (res) {
                        cacheData();
                        LeagueCreateEdit.Save.step(step);
                        after();
                    }, function () {
                        loaded();
                        $$notify.create('Something went wrong, data not stored, try again later!', 'error');
                    });
                },
                gallery: function (model, step, after) {
                    LeagueCreateEdit.Save.step(step);
                    after();
                },
                season: function(model, step, after){
                    var request = {
                        leagueId: $scope.leagueID,
                        seasonId: $scope.seasonID,
                        name: $scope.$step.model.season.name,
                        starts_at: normalizeDatepicker($scope.$step.model.season.starts_at),
                        ends_at: normalizeDatepicker($scope.$step.model.season.ends_at),
                        registration_opens_at: normalizeDatepicker($scope.$step.model.season.registration_opens_at),
                        registration_closes_at: normalizeDatepicker($scope.$step.model.season.registration_closes_at),
                        max_teams: $scope.$step.model.season.max_teams,
                        max_free_agents: $scope.$step.model.season.max_free_agents
                    };

                    $api.leagueSeasons.put(request, function (res) {
                        LeagueCreateEdit.Save.step(step);
                        after();
                    }, function (res) {
                        loaded();
                        $$notify.create('Something went wrong!', 'error');
                    });
                },
                pricing: function (model, step, after) {
                    LeagueCreateEdit.Save.step(step);
                    after();
                }
            }
        };

        /* -------------------------------------------------- Functions ------------------------------------------------- */

        function showModal($event, $modal, data){
            closeModal();
            var body = angular.element(document.body);
            var $ctrl, $close;
            switch ($modal){
                case 'add-venue':
                    $ctrl = 'Modals/League/Create-Edit/AddVenueController';

                    if(data){
                        $scope.$addVenueData = angular.extend({
                            event: $event
                        }, data);
                    }
                    $close = function () {
                        $scope.$addVenue = {
                            game_venue: {
                                location: {}
                            },
                            edit: false,
                            number_of_courts: 1
                        };
                    };
                    break;
                case 'add-time-slot':
                    $ctrl = 'Modals/League/Create-Edit/AddTimeSlotController';
                    if(data){
                        $scope.$timeSlotData = angular.extend({
                            event: $event
                        }, data);
                    }
                    $close = function () {
                        $scope.$timeSlot = {};
                    };
                    break;
                case 'add-question':
                    $ctrl = 'Modals/League/Create-Edit/AddQuestionController';
                    $close = function () {
                        $scope.$addQuestion = {};
                    };
                    break;
                case 'add-price':
                    $ctrl = 'Modals/League/Create-Edit/AddPriceController';
                    $close = function () {
                        $scope.$addPrice = {};
                    };
                    break;
            }

            if(LeagueCreateEdit.GET.leagueID()){
                
                $mdDialog.show({
                    parent: body,
                    targetEvent: $event,
                    templateUrl: logicTemplate('dashboard/layout/league-create-edit/steps/modals/'+$modal+'.html'),
                    preserveScope: true,
                    clickOutsideToClose: true,
                    escapeToClose: true,
                    scope: $scope,
                    onRemoving: $close,
                    controller: getControllerName($ctrl)
                });
            } else {
                $mdDialog.show(
                    $mdDialog.alert()
                        .parent(body)
                        .clickOutsideToClose(true)
                        .title('Create a League')
                        .textContent('You don\'t have a league, if want to continue first create league!')
                        .ariaLabel('Alert No League')
                        .ok('Ok')
                        .theme('wooter-red')
                        .targetEvent($event)
                );
            }
        }

        function closeModal(){
            return $mdDialog.cancel();
        }

        function getStep(id){
            if(angular.isNumber(id)){
                return LeagueCreateEdit.GET.steps()[id]
            } else {
                return (angular.isUndefined($stateParams.step) || $stateParams.step == 'true')?'basics':$stateParams.step;
            }
        }

        function getDefaultStep(){
            return getStep(0);
        }

        function getState(){
            return $state.current.name;
        }

        function isState (state, fn){
            if (state) {
                if(fn && angular.isFunction(fn)){
                    return fn(state, (getState().toLowerCase().indexOf(state.toString()) > -1));
                } else {
                    return (getState().toLowerCase().indexOf(state.toString()) > -1);
                }
            } else {
                return getState();
            }
        }

        function stepClick (st){
            if(st != $scope.steps[st] && !$scope.leagueID){
                if(getStep() != st.step){
                    loading();
                }
                cacheData();
                $timeout(function () {
                    $state.go(getState(), st);
                }, 1000);
            }
        }

        /**
         * Action Helper
         * @param action
         * @param section
         * @param data
         * @constructor
         */
        function ACTION (action, section, data) {
            $actions[section][action](data);
        }

        function cacheData(){
            $$store.local.store(STORE_KEY, $scope.$step.model);
        }

        function getFeatures(rest, features){
            var $k = 0, $ret = [];
            angular.forEach(features, function(value){
                if($k%2 == rest){
                    $ret.push({
                        text: value.name,
                        id: value.id,
                        index: $k
                    });
                }
                $k += 1;
            });
            return $ret;
        }

        function isStep(id, fn){
            if(getStep() == getStep(id)){
                fn(getStep());
            }
        }

        function isSaved(step) {
            if(step){
                return LeagueCreateEdit.GET.savedSteps()[step];
            } else {
                return false;
            }
        }

        function $save(fn){
            var step = getStep();
            if(step != 'gallery' && step != 'pricing'){
                $$notify.create({
                    message: "Saving step information ...",
                    type: 'info',
                    fontIcon: "material",
                    icon: "autorenew"
                });
            }

            var currentState = $scope.currentState;
            
            if (currentState == 'dashboardLeagueEdit' || isSaved(step)) {
                $methods.edit[step](LeagueCreateEdit.GET.model()[step], step, fn);
            } else {
                $methods.save[step](LeagueCreateEdit.GET.model()[step], step, fn);
            }
        }

        function saveFeature(id) {
            var feature = $scope.$step.model.features[id];

            if(feature){
                $api.leagueFeatures.save({
                    leagueId: $scope.leagueID,
                    feature_id: id
                }, function (res) {
                    $scope.$step.model.features[id] = true;
                    cacheData();
                }, function (res) {
                    $scope.$step.model.features[id] = false;
                    $$notify.create('Can\'t save this feature, try again later!', error);
                    cacheData();
                });
            } else {
                $api.leagueFeatures.delete({
                    leagueId: $scope.leagueID,
                    featureId: id
                }, function (res) {
                    $scope.$step.model.features[id] = false;
                    cacheData();
                }, function (res) {
                    $scope.$step.model.features[id] = true;
                    $$notify.create('Can\'t delete this feature, try again later!', error);
                    cacheData();
                });
            }
        }

        function showControls() {
            return $scope.leagueID?true:false;
        }

        function saveOnly(e) {
            if(count(e.$error) > 0){
                $$notify.create({
                    message: 'Please, fill all the necessary fields',
                    type: 'error',
                    fontIcon: 'material',
                    icon: 'error_outline'
                });
                e.$setDirty();
                e.$setSubmitted();
                e.$commitViewValue();
            } else {
                loading();
                cacheData();
                $save(function () {
                    $$notify.create({
                        message: "The data was successfully saved",
                        type: 'success',
                        fontIcon: "material",
                        icon: "check"
                    });
                    loaded();
                });
            }
        }

        function isLeagueCreated() {
            return (LeagueCreateEdit.GET.leagueID())?true:false;
        }
        function isSeasonCreated() {
            if ($scope.currentState == 'dashboardLeagueEdit') {
                return true;
            }
            return (LeagueCreateEdit.GET.seasonID())?true:false;
        }

        function cleanTime(hours) {
            var $hours = [];

            angular.forEach(hours, function (val) {
                if( (val.toLowerCase().indexOf('am') > -1) || (val.toLowerCase().indexOf('pm') > -1) ){
                    if ((val.toLowerCase().indexOf('am') > -1)) {
                        val = val.split(':');
                        val[0] = twoDigit(val[0]);
                    } else {
                        val = val.split(':');
                        val[0] = twoDigit(((parseInt(val[0]) != 12)?parseInt(val[0])+12:parseInt(val[0])));
                    }
                    val = val.join(':');
                    val = val.toLowerCase().split('am').join('').trim();
                    val = val.toLowerCase().split('pm').join('').trim();
                    $hours.push(val);
                }
            });

            return $hours;
        }

        function cleanHour(hour, amPM) {
            amPM = (angular.isDefined(amPM))?amPM:true;
            if(hour){
                hour = hour.split(':');
                var am_pm = (parseInt(hour[0]) >= 12)?'pm':'am';
                if(amPM){
                    hour[0] = (parseInt(hour[0]) > 12)?parseInt(hour[0])-12:hour[0];
                    return hour[0]+":"+hour[1]+" "+am_pm.toUpperCase();
                } else {
                    return hour[0]+":"+hour[1];
                }
            }
        }

        function finalStep () {
            return getStep(count($scope.steps)-1);
        }

        function finishSave() {
            if(count($scope.prices) != 0){

                $$store.session.destroy('create_continue');
                $$store.local.destroy('league_create_model');
                $$store.local.destroy('league_id');
                $$store.local.destroy('season_id');
                $$store.local.destroy('saved_steps');

                $mdDialog.show({
                    parent: angular.element('body'),
                    templateUrl: logicTemplate('dashboard/layout/league-create-edit/steps/modals/finish.html'),
                    preserveScope: true,
                    clickOutsideToClose: true,
                    escapeToClose: true,
                    scope: $scope
                });

            } else {
                $$notify.create({
                    message: 'Add a price to you league!',
                    type: 'error',
                    fontIcon: 'material',
                    icon: 'error_outline'
                });
            }
        }

        /* -------------------------------------------------------------------------------------------------------------- */

        var photoDropzone;



        $scope.cacheLeagueData = function () {
            if ($scope.$step.model.season.starts_at != null) {
                $scope.$step.model.season.start_label = true;
            }

            if ($scope.$step.model.season.ends_at != null) {
                $scope.$step.model.season.end_label = true;
            }

            if ($scope.$step.model.season.registration_opens_at != null) {
                $scope.$step.model.season.registration_open_label = true;
            }

            if ($scope.$step.model.season.registration_closes_at != null) {
                $scope.$step.model.season.registration_close_label = true;
            }

            cacheData();
        };

        $scope.showModal = showModal;
        $scope.closeModal = closeModal;
        $scope.finalStep = finalStep;
        $scope.action = ACTION;
        $scope.stepClick = stepClick;
        $scope.isSaved = isSaved;
        $scope.saveFeature = saveFeature;
        $scope.saveOnly = saveOnly;
        $scope.isLeagueCreated = isLeagueCreated;
        $scope.isSeasonCreated = isSeasonCreated;
        $scope.cleanTime = cleanTime;
        $scope.cleanHour = cleanHour;
        $scope.showControls = showControls;

        $scope.actualStep = getStep();
        $scope.stepID = $scope.steps.indexOf(getStep());



        $scope.$photoLoader = {
            show: false,
            done: false,
            message: 'Uploading photos ...',
            value: 0
        };

        $scope.$loaders = {
            photo: {
                reset: function () {
                    $scope.$photoLoader = {
                        show: false,
                        done: false,
                        message: 'Uploading photos ...',
                        theme: 'blue',
                        value: 0
                    };
                    $scope.$apply();
                },
                setVal: function (val) {
                    $scope.$photoLoader.value = val;
                    $scope.$apply();
                },
                setMessage: function (message) {
                    $scope.$photoLoader.message = message;
                    $scope.$apply();
                },
                success: function (message) {
                    $scope.$photoLoader.message = message;
                    $scope.$photoLoader.success = true;
                    $scope.$loaders.photo.done();
                    $scope.$apply();
                },
                error: function (message) {
                    $scope.$photoLoader.message = message;
                    $scope.$photoLoader.error = true;
                    $scope.$loaders.photo.done();
                    $scope.$apply();
                },
                show: function () {
                    $scope.$photoLoader.show = true;
                    $scope.$apply();
                },
                hide: function () {
                    $scope.$photoLoader.show = false;
                    $scope.$apply();
                },
                done: function () {
                    $timeout(function () {
                        $scope.$photoLoader.done = true;
                        $scope.$apply();
                        $timeout(function () {
                            $scope.$loaders.photo.hide();
                        }, 200)
                    }, 4000);
                }
            }
        };

        $scope.$step = {};
        $scope.$step.data = LeagueCreateEdit.GET.stepsInfo();
        $scope.$step.model = LeagueCreateEdit.GET.model();
        $scope.$step.content = logicTemplate('dashboard/layout/league-create-edit/steps/' + getStep() + '.html');
        $scope.$step.title = $scope.$step.data[getStep()].title;
        $scope.$step.description = $scope.$step.data[getStep()].description;

        // console.log($scope.$step.model);

        $scope.util = {
            href: function(id){
                var url = $state.current.url;
                url = url.replace('?step', ('?step='+getStep(id)));
                url = url.replace(/:league_id/g, $stateParams.league_id);
                url = '/#'+url;

                return ( $scope.$step.data[getStep(id)].saved || $scope.$steps.isActive(id) )?url.toString():'javascript:void(0)'
            }
        };

        $scope.$steps = {
            now: function(){
                return $scope.steps.indexOf(getStep());
            },
            isActive: function (index) {
                var url = '/#'+$location.url();
                return angular.equals($scope.$steps.getLinkById(index) , url);
                // return $scope.$steps.getLinkById(index) == '/'+window.location.hash;
            },
            getLinkById: function(id){
                var url = $state.current.url;
                // console.log('getLinkById'+url);
                url = url.replace('?step', ('?step='+getStep(id)));
                url = url.split(':league_id').join($stateParams.league_id);

                return '/#'+url;
            },
            start: function(){
                $state.go(getState(), {step: $scope.steps[0]});
                return false;
            },
            nextStep: function(e){
            
                if(count(e.$error) > 0){
                    $$notify.create({
                        message: 'Make sure all informations are correct!',
                        type: 'error',
                        fontIcon: 'material',
                        icon: 'error_outline'
                    });
                    e.$setDirty();
                    e.$setSubmitted();
                    e.$commitViewValue();
                } else {
                    loading();
                    cacheData();
                    $save(function () {
                        if(getStep() != 'pricing' && getStep() != 'gallery'){
                            $$notify.create({
                                message: "Awesome, information was saved!",
                                type: 'success',
                                fontIcon: "material",
                                icon: "check"
                            });
                        }
                        if(getStep() != 'pricing'){
                            $state.go(getState(), {step: $scope.steps[($scope.$steps.now()+1)]});
                        } else {
                            finishSave();
                            loaded();
                        }
                    });
                }
                return false;
            },
            prevStep: function(){
                loading();
                cacheData();
                $timeout(function () {
                    $state.go(getState(), {step: $scope.steps[($scope.$steps.now()-1)]});
                }, 1000);
                return false;
            }
        };

        Page.title('League '+( (isState('edit'))?'Edit':'Create' )+' | Wooter');

        $timeout(loaded, 1000);

        isStep(0, function () {
            $api.countries.get(function (response) {
                $scope.countries = response.data;
                $scope.defaultCountry = 236;
            });

            $api.sports.get(function (response) {
                $scope.sports = response.data;
            });

            ACTION('update', 'basics', {});
            ACTION('update', 'venues', {});
        });

        isStep(1, function () {
            if(angular.isUndefined($scope.leagueID)){
                $scope.$steps.start()
            }
            $api.features.get(function (response) {
                $scope.features = {
                    sectionLeft: getFeatures(1, response.data),
                    sectionRight: getFeatures(0, response.data)
                };
            });

            ACTION('update', 'details', {});
            ACTION('update', 'features', {});
        });

        isStep(2, function (step) {
            if(angular.isUndefined($scope.leagueID)){
                $scope.$steps.start()
            }

            $api.leaguePhotos.get({
                leagueId: LeagueCreateEdit.GET.leagueID()
            }, function (res) {
                $scope.$step.model[step].images = res.data;
            });
            function fnPhotoDropzone() {
                
                $scope.$step.model[step].images = (angular.isUndefined($scope.$step.model[step].images))?[]:$scope.$step.model[step].images;
                if(angular.element("#add-photos-dropzone a").length > 0){
                    photoDropzone = angular.element("#add-photos-dropzone .handler");
                    var configs = {
                        url: "/api/leagues/"+$scope.leagueID+"/photos",
                        method: 'post',
                        maxFilesize: 5,
                        clickable: true,
                        paramName: 'photo',
                        uploadMultiple: true,
                        acceptedFiles: "image/*",
                        previewContainer: false,
                        maxfilesreached: 10,
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Authorization": "Bearer "+Authentify.token()
                        },
                        init: function () {
                            this.on('addedfile', function () {
                                $scope.$loaders.photo.reset();
                                $scope.$loaders.photo.show();
                            });
                        },
                        sending: function(file, xhr, formData){
                            formData.append('league_id', $scope.leagueID);
                            formData.append('fromCreate', true);
                        },
                        successmultiple: function (file, response) {
                            if (angular.isUndefined($scope.$step.model[step].images.photos)) {
                                $scope.$step.model[step].images.photos = [];
                            }
                            
                            angular.forEach(response.data, function (val) {
                                $scope.$step.model[step].images.photos.push({
                                    id: val.id,
                                    image_id: val.image_id,
                                    thumbnail_path:val.thumbnail_path
                                });
                            });

                            cacheData();

                            $scope.$loaders.photo.success('Done! Your photo was successfully uploaded.');
                        },
                        completemultiple: function () {
                            // $scope.$loaders.photo.success('Done! Your photo was successfully uploaded.');
                        },
                        error: function (file, res) {
                            if(res.error){
                                $scope.$loaders.photo.error(res.error.message);
                            } else {
                                if(res.indexOf('too big') > -1){
                                    $scope.$loaders.photo.error('Error: Too big, maximum upload size is 5MB');
                                } else {
                                    $scope.$loaders.photo.error('Error: There was a problem uploading your photos');
                                }
                            }
                        },
                        totaluploadprogress: function (procent) {
                            procent = parseInt(procent);
                            $scope.$loaders.photo.setVal(procent);
                        }
                    };

                    if(LeagueCreateEdit.GET.leagueID()){
                        photoDropzone.dropzone(configs);
                    } else {
                        photoDropzone.on('click', function (e) {
                            e.preventDefault();
                            $mdDialog.show(
                                $mdDialog.confirm()
                                    .title('Create a League')
                                    .textContent('You don\'t have a league, if want to continue first create league!')
                                    .ariaLabel('Dialog No League')
                                    .targetEvent(e)
                                    .ok('Create league')
                                    .cancel('Cancel')
                                    .theme('wooter-red')
                            ).then(function() {
                                $scope.$steps.start();
                            });

                            return false;
                        });
                    }
                }
            }

            $scope.$on('$includeContentLoaded', function (e, file) {
                if($scope.$step.content == file){
                    fnPhotoDropzone();
                }
            })
        });

        isStep(3, function () {
            if(angular.isUndefined($scope.leagueID)){
                $scope.$steps.start()
            }

            $scope.weekdays = Weekdays.all();

            ACTION('update', 'season', {});
        });

        isStep(4, function () {
            if(angular.isUndefined($scope.leagueID)){
                $scope.$steps.start()
            }
            ACTION('update', 'price', {});
        });

        isStep(5, function () {
            if(angular.isUndefined($scope.leagueID)){
                $scope.$steps.start()
            }
            ACTION('update', 'price', {});
        });

        angular.element('.back-face').trigger('hover');

        if(LeagueCreateEdit.Check.model() && LeagueCreateEdit.Check.leagueID() && !LeagueCreateEdit.Check.continue()){
            // console.log('create league model');
            $mdDialog.show(
                $mdDialog.confirm()
                    .title('You have a league created ...')
                    .textContent('Want to continue with this league?')
                    .ariaLabel('Dialog Created League')
                    .ok('Yes')
                    .cancel('No')
                    .theme('wooter-red')
            ).then(function() {
                $$store.session.set('create_continue', true);
                $scope.$steps.start();
            }, function () {
                var id = $$store.local.get('league_id');
                $$store.local.destroy('league_create_model');
                $$store.local.destroy('league_id');
                $$store.local.destroy('season_id');
                $$store.local.destroy('saved_steps');
                API.exec('leagues').delete({id: id});
                $state.reload();
            });
        }
    }
}]);
