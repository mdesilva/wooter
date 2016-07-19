__Wooter.controller('HeaderControllerLogin', ['$scope', '$cookies', '$http', '$q', '$stateParams', '$mdSidenav', '$mdBottomSheet', 'API', 'Autocomplete', 'STORE', 'Socket', 'Authentify', function ($scope, $cookies, $http, $q, $stateParams, $mdSidenav, $mdBottomSheet, API, Autocomplete, STORE, Socket, Authentify) {

   

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

    $scope.menu = {
        items:{
           
            company: [
                {
                    text: "Blog",
                    url: "https://wooter.co/blog"
                },
                {
                    text: "About",
                    url: "/about"
                },
                {
                    text: "Contact",
                    url: "/contact"
                },
                {
                    text: "Privacy Policy",
                    url: "/policy"
                },
                {
                    text: "Terms & Conditions",
                    url: "/terms"
                }
            ],
            
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
            ]
        }
    }
}]);
