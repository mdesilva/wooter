__Wooter.controller('HeaderController', ['$scope', '$rootScope', '$cookies', '$window', '$http', '$q', '$stateParams', '$mdSidenav', '$mdBottomSheet', 'API', 'Autocomplete', 'STORE', 'Socket', 'Authentify', function ($scope, $rootScope, $cookies, $window, $http, $q, $stateParams, $mdSidenav, $mdBottomSheet, API, Autocomplete, STORE, Socket, Authentify) {

    var $notificationsAPI = API.exec('notifications');
    var $userAPI = API.exec('users');

    $scope.notifications = {};
    $scope.notificationsCounter = 0;

    /**
     * Get List of players
     */
    if(!isNull(Authentify.GET.user())){
        $notificationsAPI.get({}, function (response) {
            $scope.notifications = response.data;
            $scope.notificationsCounter = count(response.data);
        });

        Socket.on('broadcast:Wooter\\Events\\League\\NotifyLeagueOwnerPlayerJoinLeagueEvent' + ':' + Authentify.GET.user().id, function(data) {
            $notificationsAPI.get({}, function (response) {
                $scope.notifications = response.data;
                $scope.notificationsCounter = count(response.data);
            });
        });

        Socket.on('broadcast:Wooter\\Events\\League\\NotifyLeagueOwnerPlayerLeftLeagueEvent' + ':' + Authentify.GET.user().id, function(data) {
            $notificationsAPI.get({}, function (response) {
                $scope.notifications = response.data;
                $scope.notificationsCounter = count(response.data);
            });
        });
    }

    // Header Action and Scopes
    $scope.lang = $scope.language;

    $rootScope.authenticated = Authentify.GET.authCheck();
    // $scope.currentUser = $rootScope.User();

    $userAPI.show({
        userId: $rootScope.User().id
    }, function(resp) {
        $scope.currentUser = resp.data;
    });
    console.log('authenticated?', $rootScope.authenticated);
    console.log($scope.currentUser);

    $scope.setLanguage = function(){
        var lang = this.lang;

        $http({
            method: "POST",
            url: "/api/setLanguage",
            data: {language: lang}
        }).then(function(response){
            if(response.statusText.toLowerCase() == 'ok' && response.data.success){
                window.location.reload();
            }
        }, function(response){
           console.error(response);
        });

        return false;
    };

    $scope.clearNotifications = function() {
        $notificationsAPI.markAsConsumed({}, function (response) {
            $scope.notificationsCounter = 0;
        });
    };

    $scope.search = {
        params: {
            search: $stateParams.search
        }
    };

    $scope.showMobileMenu = function(){
        $mdSidenav('mobileMenu').toggle();
    };

    $scope.profileActions = [
        {
            icon: "dashboard",
            text: "Go to Dashboard",
            url: "#"
        },
        {
            icon: "edit",
            text: "Edit profile",
            url: "#"
        },
        {
            icon: "settings",
            text: "Security settings",
            url: "#"
        },
        {
            icon: "arrow_back",
            text: "Log out",
            url: "#"
        }
    ];
    $scope.$request = null;
    $scope.searchBar = {
        state: true,
        cache: false,
        Event: {
            search: function(query){

                var SearchDeferred = $q.defer();

                if($scope.search.params.search){
                    STORE('session', 'searchString', $scope.search.params.search);

                    if($scope.$request) { $scope.$request.abort() }

                    ($scope.$request = Autocomplete.getSearch($scope.search.params.search)).then(function(response){
                        var results = response.data;
                        console.log(results);
                        SearchDeferred.resolve(results);
                    }, function(response){
                        SearchDeferred.reject([]);
                    });
                }

                return SearchDeferred.promise;
            }
        },
        Object:{
            filter: function (query) {
                var lowercaseQuery = angular.lowercase(query);
                return function filterFn(state) {
                    return (state.name.indexOf(lowercaseQuery) === 0);
                };
            }
        }
    };

    $scope.showProfileActions = function($event){
        $('.can-no-z').addClass('no-z');
        $mdBottomSheet.show({
            templateUrl: bladeView('templates.layout.profileSheet'),
            controller: 'HeaderController',
            targetEvent: $event
        });
    };

    var w = angular.element($window);

    $scope.checkWidth = function() {
        if ($(window).width() < 950) {
            $scope.mobile = true;
        } else {
            $scope.mobile = false
        }
    };

    w.bind('resize', function() {
        console.log($(window).width());
        if ($(window).width() < 950) {
            $scope.mobile = true;
            console.log('mobile?', $scope.mobile);
        } else {
            $scope.mobile = false;
            console.log('mobile?', $scope.mobile);
        }
    });

    $scope.$watch('mobile', function() {
        if ($scope.authenticated === true) {
            $scope.mobileHeader = {
                'width': 'calc(100% - 100px)'
            };
        } else {
            $scope.mobileHeader = {
                'width':'calc(100% - 136px)'
            };
        }
    });

    $scope.menu = {
        items:{
            services: [
                {
                    text: "Videos & Statistics",
                    url: "/packages"
                },
                {
                    text: "Custom Apparel",
                    url: "http://wooterapparel.com"
                },
                {
                    text: "Social Media Marketing",
                    url: "http://snapgrowmedia.com"
                },
                {
                    text: "Sports Insurance",
                    url: "/insurance"
                },
                {
                    text: "On Demand Video",
                    url: "https://michaelsisakov.wix.com/svcgroup"
                },
                {
                    text: "Referees",
                    url: "/referees"
                }
            ],
            company: [{
                text: 'Blog',
                url: 'https://wooter.co/blog'
            }, {
                text: 'About',
                url: '/about'
            }, {
                text: 'Contact',
                url: '/contact'
            }, {
                text: 'Private Policy',
                url: '/policy'
            }, {
                text: 'Terms & Conditions',
                url: '/terms'
            }]
        }
    };
}]);
