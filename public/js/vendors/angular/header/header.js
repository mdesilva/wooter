'use strict';

angular.module('wooterApp').controller('SideNavCtrl', function ($scope, $timeout, $mdSidenav, $log) {
        $scope.toggleLeft = buildDelayedToggler('left');
        $scope.courtData = [];
        /**
         * Supplies a function that will continue to operate until the
         * time is up.
         */
        function debounce(func, wait, context) {
            var timer;
            return function debounced() {
                var context = $scope,
                    args = Array.prototype.slice.call(arguments);
                $timeout.cancel(timer);
                timer = $timeout(function() {
                    timer = undefined;
                    func.apply(context, args);
                }, wait || 10);
            };
        }
        /**
         * Build handler to open/close a SideNav; when animation finishes
         * report completion in console
         */
        function buildDelayedToggler(navID) {
            return debounce(function() {
                $mdSidenav(navID)
                    .toggle()
                    .then(function () {
                        $log.debug("toggle " + navID + " is done");
                    });
            }, 200);
        }
        function buildToggler(navID) {
            return function() {
                $mdSidenav(navID)
                    .toggle()
                    .then(function () {
                        $log.debug("toggle " + navID + " is done");
                    });
            }
        }
    })

    .controller('LeftCtrl', function ($scope, $timeout, $mdSidenav, $log) {
        $scope.close = function () {
            $mdSidenav('left').close()
                .then(function () {
                    $log.debug("close LEFT is done");
                });
        };
    })

    .controller('DropDwn', function($scope) {

    $scope.athletesdropdownlist = [
        {
            text:'company'
        },
        {
            text:'company'
        }
    ];

    $scope.comissionerdropdownlist = [
        {
            text:'wooter leagues'
        },
        {
            text:'search leagues'
        },
        {
            text:'find courts'
        },
        {
            text:'app'
        }
    ];



    })
    .controller('navsearchController',function($scope, $rootScope, restApi, $q, $http, $timeout, $location){
         $scope.mobilesearch=true;
         var self = this;
         self.testing = [];
            // list of `state` value/display objects
            self.querySearch   = querySearch;
        $scope.$watch('searchCourt', function(){
            $rootScope.$broadcast('headerCourtSearch', $scope.searchCourt);
        })

        /*$scope.searchTextChange = function(text){
        if(text.length<1){
            return;
        }
        restApi.searchCourt(text, function( data, status){
        if(data.success=='true'){
            $scope.courtData = data.data;
        }else{
            alert('Some error');
        }
      });
    }*/
    $scope.searchTextChange = function(text){

    }

    function querySearch (query) {
        var results = getData(query);
        var deferred = $q.defer();
        $timeout(function () { deferred.resolve(
            self.testing
        ); },1000, false);
        return deferred.promise;

    }
    function getData(query){
        return $http.post($rootScope.MAIN_REST_URL+'searchCourt.php?text='+query, {}, {
              headers : {
                'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'
            }
            }).success(function(data){
                self.testing = data.data
                return data.data;
            });
    }

    $scope.selectedItemChange = function(item){
        if(item!==undefined){
            $location.url('/courts?preview='+item.sr_no);
        }
    }

    });