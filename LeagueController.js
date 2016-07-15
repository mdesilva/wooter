/*
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: League Page
 * License: Wooter LLC.
 * Date: 2016.03.01
 * Description: League page controller
 *
 */
__Wooter.controller('Leagues/LeagueController', ['$scope', 'Page', '$stateParams', 'League', '$timeout', '$state', 'API', 'Authentify','$mdDialog','Notify', function ($scope, Page, $stateParams, League, $timeout, $state, API, Authentify,$mdDialog,Notify) {

    var $leaguePricesAPI = API.exec('leaguePrices');
    var $leagueReviewsAPI = API.exec('leagueReviews');
    var $leagueGameVenuesAPI = API.exec('leagueGameVenues');

    var leagueId = $stateParams.league_id;

    $leaguePricesAPI.get({leagueId: leagueId}, function (response) {
        $scope.leaguePrices = response.data;

        $scope.currentLeaguePrice = response.data[0];
    });

    $leagueReviewsAPI.get({leagueId: leagueId}, function (response) {
        $scope.leagueReviews = response.data;
    });

    $scope.stars = [];
    for (var i = 1; i < 5; i++) {
        var $data = {
            id: i,
            value: i
        };

        $scope.stars.push($data);
    }

    $scope.markers = [];
    $leagueGameVenuesAPI.get({leagueId: leagueId}, function (response) {
        $scope.leagueGameVenue = response.data[0];
        if (typeof $scope.leagueGameVenue != 'undefined' && $scope.leagueGameVenue.length > 0) {
            $scope.leagueGameVenue.center = {
                longitude: response.data[0].game_venue.location.longitude,
                latitude: response.data[0].game_venue.location.latitude
            };
        } else {
            $scope.leagueGameVenue.center = {};
        }

        response.data.forEach(function(venue) {
            $scope.markers.push({
                coords: {
                    longitude: venue.game_venue.location.longitude,
                    latitude: venue.game_venue.location.latitude
                },
                id: venue.id
            });
        });
    });

    $scope.changeLeaguePrice = function(leaguePriceId) {
        $leaguePricesAPI.show({leagueId: leagueId, leaguePriceId: leaguePriceId}, function (response) {
            $scope.currentLeaguePrice = response.data;
        });
    };

    /**
     * Create Api requests
     *
     * @type {HttpPromise}
     */
    var $request = League.createRequest($stateParams.league_id);
        $request.length = count($request);

    $$store.session.remove('slides_request', false);

    /*
	 * Clean page (title, assets, favicon badge, etc.)
	 */
	Page.reset();
	Page.title('Wooter');
    Page.stylesheets([
        'css/vendors/owl/index.css',
        'css/leagues/league.css'
    ]);
    Page.scripts([
        'js/vendors/jquery/owl/index.js',
        'js/scripts/leagues/league/index.js'
    ]);

    var Generators = {
        playerPerTeam: function (no) {
            no = Math.abs(parseInt(no));
            return (no > 0) ? (no + ( (no == 1) ? ' Player' : ' Players' ) + '/Team') : false;
        },
        trimDescription: function (txt, len) {
            len = (len)?len:54;
            var $ret = [],
                words = txt.toString().trim().split(' ');

            for(var i = 0; i < len; i++) {
                $ret.push(words[i]);
            }

            return $ret.join(' ').toString().trim() + ' ...';
        },
        aboutData: function (details, season) {
            var getRegData = function (date) {
                return moment(date).format('MMMM DD, YYYY');
            };

            var getMinutes = function (no) {
                no = Math.abs(parseInt(no));
                return (no > 0) ? ( no + ( (no == 1) ? ' Minute' : ' Minutes' ) ) : false;
            };

            return [
                {
                    name: "Players per Team:",
                    value: (details.players_per_team)?details.players_per_team:'N/A'
                },
                {
                    name: "Registration:",
                    value: getRegData(season.registration_opens_at) + ' - ' + getRegData(season.registration_closes_at)
                },
                {
                    name: "Number of Games:",
                    value: (details.games_per_team)?details.games_per_team:'N/A'
                },
                {
                    name: "Season Dates:",
                    value: getRegData(season.starts_at) + ' - ' + getRegData(season.ends_at)
                },
                {
                    name: "Max Teams:",
                    value: (season.max_teams)?season.max_teams:'N/A'
                },
                {
                    name: "Duration of Games:",
                    value: (getMinutes(details.game_duration))?getMinutes(details.game_duration):'N/A'
                }
            ];
        }
    };

    /**
     * Store requests data
     */
    $scope.requests = {};
    $scope.loaded = {};
    angular.forEach($request, function (v, k) {
        if(v && angular.isFunction(v.then)){
            v.then(function (res) {
                $scope.requests[k] = res.data.data;
            }, function (res) {
                if(parseInt(res.data.error.status_code) == 404) {
                    $state.go('404', {
                        from: 'league'
                    });
                }
            });
        }
    });

    $scope.Slider = {
        photos: {
            slides: []
        },
        videos: {
            slides: [
                { video: 'https://www.youtube.com/watch?v=m1_eGKsoA-U' },
                { video: 'https://vimeo.com/channels/staffpicks/155836252' },
                { video: 'https://www.youtube.com/watch?v=m1_eGKsoA-U' },
                { video: 'https://vimeo.com/channels/staffpicks/155836252' },
                { video: 'https://www.youtube.com/watch?v=m1_eGKsoA-U' },
                { video: 'https://vimeo.com/channels/staffpicks/155836252' }
            ]
        }
    };

    $scope.aboutDetails = [];

    $scope.$watch('requests', function () {
        if($scope.requests.league){
            if (angular.isUndefined($scope.title)) {
                $scope.title = $scope.requests.league.name;
            }

            if (angular.isUndefined($scope.sportName)) {
                $scope.sportName = $scope.requests.league.sport.name;
            }

            if (!angular.isUndefined($scope.description)) {
                var trim = Generators.trimDescription($scope.requests.league.description);

                $scope.description = trim;
                $scope.short_description = trim;
                $scope.long_description = $scope.requests.league.description;
            }

            // if (angular.isUndefined($scope.organization_logo)) {
            //     $scope.organization_logo = $scope.requests.league.organization_logo;
            // }

        }

        if($scope.requests.locations && !angular.isUndefined($scope.location)){
            $scope.location = {
                street: $scope.requests.locations[0].street,
                city: $scope.requests.locations[0].city,
                state: $scope.requests.locations[0].state,
                coordinates: {
                    latitude: $scope.requests.locations[0].latitude,
                    longitude: $scope.requests.locations[0].longitude
                }
            };
        }

        if($scope.requests.basics && angular.isUndefined($scope.basics)){
            $scope.basics = $scope.requests.basics;
            $scope.league_logo = 'img/landings/logo-v2.png';
            if ($scope.basics.logo_id != null) {
                $scope.league_logo = $scope.basics.logo.file_path;
            }
        }

        if($scope.requests.details && angular.isUndefined($scope.details)){
            $scope.details = $scope.requests.details;
            $scope.details.playersPerTeam = Generators.playerPerTeam($scope.requests.details.players_per_team);
        }

        if($scope.requests.seasons){

            if (angular.isUndefined($scope.season)) {
                $scope.season = $scope.requests.seasons[0];
                if(angular.isDefined($scope.details)){
                    $scope.aboutDetails = Generators.aboutData($scope.details, $scope.requests.seasons[0]);
                }
            }

            if (angular.isUndefined($scope.seasons)) {
                $scope.seasons = $scope.requests.seasons;
            }

            if (angular.isUndefined($scope.startDate)) {
                $scope.startDate = 'Starts' + moment($scope.requests.seasons[0].starts_at).format('MMMM D');
            }

        }

        if ($scope.requests.photos) {
            angular.forEach($scope.requests.photos.photos, function (v) {
                $scope.Slider.photos.slides.push({
                    image_id: v.image_id,
                    thumbnail_path: v.thumbnail_path,
                    file_path: v.file_path
                })
            });
            $$store.session.set('slides_request', $scope.Slider.photos.slides);
        }

        if ($scope.requests.features) {
            $scope.features = $scope.requests.features;
        }

        angular.forEach($scope.requests, function (v, k) {
            $scope.loaded[k] = true;
        });

    }, true);

    $scope.toggle_less_more = function (e) {

        var $this = $(e.target).parents(".md-button"),
            span = $(e.target),
            content = $this.parents('.section-content-holder');

        content.find('md-content').slideUp(350);

        $timeout(function () {
            if( span.text().toString().toLowerCase().indexOf('more') > -1 ) {
                $scope.description = $scope.long_description;
                span.text('Read less');
            } else if( span.text().toString().toLowerCase().indexOf('less') > -1 ) {
                $scope.description = $scope.short_description;
                span.text('Read more');
            }
        }, 400);

        content.find('md-content').delay(50).slideDown(350);

        return false;
    };

    $scope.map = {
        zoom: 12,
        options: {
            scrollwheel: false,
            mapTypeControl: true,
            mapTypeControlOptions: {
                position: 2
            }
        }
    };

    $scope.addReview = function (e) {
        $mdDialog.show({
          clickOutsideToClose: true,
          scope: $scope,        
          preserveScope: true,           
          templateUrl: logicTemplate('modals/leagues/league-review.html'),
          // controller: 'Modals/League/AddReviewController'
       });
    };

    $scope.closeModal = function (e) {
        return $mdDialog.cancel();
    }

    $scope.addLeagueReview = function (data) {
        if(count(data.$error) > 0){
            $$notify.create({
                message: 'Make sure all informations are correct!',
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        } 
        else {    
            loading();
            $leagueReviewsAPI.save({
                leagueId: leagueId, 
                review: $scope.league_review,
                stars: $scope.review_stars
            }, function (response) {
                Notify('League Review is submitted successfuly!','success');
                $mdDialog.cancel();

                $leagueReviewsAPI.get({leagueId: leagueId}, function (response) {
                    $scope.leagueReviews = response.data;
                });
                loaded();
            },
            function (response) {
                Notify('Oops! Someting went wrong. Please try again','warning');
                loaded();
            });
        }
    }

 }]);
