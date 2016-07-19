/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Results Page
 * License: Wooter LLC.
 * Date: 2016.01.25
 * Description: Results Page
 *
 */
__Wooter.controller('Search/SearchController', ['$scope', 'Page', '$stateParams', 'ZIP', 'CONFIGS', '$cookies', '$http', '$filter', 'STORE', function ($scope, Page, $stateParams, ZIP, CONFIGS, $cookies, $http, $filter, STORE) {

    /*
     * Clean all previous Assets
     */
    Page.reset();

    /*
     * Add stylesheet
     */
    Page.stylesheets(['css/results.css']);

    /*
     * Get zip value
     */
    var $zip = ZIP.get();


    /*
     * Generate Ages options
     */
    function generateAges(){
        var a = 0,
            b = [{
                val: 'all',
                text: 'All Ages'
            }];

        while(a <= 50){
            b.push({
                val: a+'-'+(a+9),
                text: a+' - '+(a+9)
            });

            a += 10;
        }

        b.push({
            val: '60+',
            text: '60+'
        });

        return b;
    }


    /*
     * Generate Distance options
     */
    function generateDistance(){
        var a = ['2.5', '5', '10', '25'];
        var b = [];

        angular.forEach(a, function(value){
            b.push({
                val: value,
                text: value+' Miles'
            });
        });

        b.push({
            val: '10000',
            text: '50+ Miles'
        });

        return b;
    }

    /*
     * Generate Genders options
     */
    function generateGenders(){
        return [
            { val: 'male', text: "Male" },
            { val: 'female', text: "Female" },
            { val: 'all', text: "All Genders" }
        ];
    }

    /*
     * Generate Sort methods
     */
    function generateSortMethods(){
        var a = ['distance', 'price'];
        var b = [];

        angular.forEach(a, function(value){
            b.push({
                val: value+'-asc',
                text: capitalize(value+' Ascending')
            });
            b.push({
                val: value+'-desc',
                text: capitalize(value+' Descending')
            });
        });

        return b;
    }

    /*
     * Generate Sports options
     */
    function generateSports(){
        var a = [
            'football',
            'hockey',
            'basketball',
            'tennis',
            'baseball',
            'soccer',
            'kickball',
            'softball',
            'bowling',
            'dodgeball',
            'volleyball'
        ];

        var b = [{
            val: 'all',
            text: "All Sports"
        }];

        angular.forEach(a, function(value){
            b.push({
                val: value,
                text: capitalize(value)
            })
        });

        return b;
    }

    /*
     * Delete null/undefined/empty values
     */
    function cleanParams (obj){
        var ret = [];
        if (check_type(obj, 'object')) {

            angular.forEach(obj, function(val, key){
                if (obj[key]) {
                    ret[key] = val;
                }
            });

            ret.length = count(ret);
        }

        return ret;
    }

    $scope.search = {
        /*
         * Default values for search
         */
        defaults: {
            ages: "all",
            distance: "10000",
            gender: "all",
            location: $zip,
            search: "",
            sort: "distance-asc",
            sport: "all"
        }
    };

    /*
     * Form Model
     */
    $scope.search.params = angular.extend($scope.search.defaults, cleanParams($stateParams));

    // For multiple sports select
    //$scope.search.params.sports = $scope.search.params.sports.split(',');

    /*
     * Engine, start creating search event
     */
    $scope.execSearch = function(){
        Search.setLocation($scope.search.params);
    };

    $scope.Input ={
        leave: function($e){
            if (window.temp.inputVal && $e.target.value != window.temp.inputVal) {
                $scope.execSearch()
            }
        },
        open: function($e){
            window.temp = {
                inputVal: $e.target.value
            }
        },
        key: function($e){
            if($e.which == 13){
                $e.target.blur()
            }
        }
    };

    $scope.results = {};

    $scope.filters = {};
    $scope.filters.genders = generateGenders();
    $scope.filters.ages = generateAges();
    $scope.filters.distances = generateDistance();
    $scope.filters.sort = generateSortMethods();
    $scope.filters.sports = generateSports();

    $scope.getAgesOf = function(min, max){
        var vmin = (min > max)?max:min,
            vmax = (min > max)?min:max,
            $ret;

        if(vmax == 99){
            if(vmin > 3){
                $ret = 'Ages '+vmin+'+';
            } else {
                $ret = "All Ages"
            }
        } else {
            $ret = 'Ages '+vmin+'-'+vmax;
        }

        return $ret;
    };

    $scope.getDeadlineOf = function(d){
        var $ret = new Date(d);
        var year = $filter('date')($ret, 'yyyy');
        $ret = $filter('date')($ret, 'MMM dd');
        $ret += ", " +year;

        return 'Deadline: '+$ret;
    };

    $scope.coords = {};

    $scope.getCoordinates = function(){
        return $scope.coords;
    };

    $scope.getDistanceOf = function(lat, lon){

        var mile = 1.609344;

        var toRad = function (v){
            return v * Math.PI / 180;
        };

        var coordsUser = $scope.getCoordinates();

        var coordsResult = {
            latitude: lat,
            longitude: lon
        };

        /*
         * Earth Radius
         */
        var R = 6371;

        var dLat = toRad(coordsResult.latitude - coordsUser.latitude);
        var dLon = toRad(coordsResult.longitude - coordsUser.longitude);
        var lat1 = toRad(coordsUser.latitude);
        var lat2 = toRad(coordsResult.latitude);

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);

        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        var d = R * c;

        return (d/mile).toFixed(1) + " mi";

    };

    $scope.openLeague = function(e){
        window.location = '/league/'+parseInt(e);
        return false;
    };

    var Filter = {
        Clean: {
            ages: function(ages){
                ages = ages.split('-');
                if (ages.length == 1) {
                    ages = {
                        min_age: 60,
                        max_age: 99
                    }
                } else {
                    ages = {
                        min_age: ages[0],
                        max_age: ages[1]
                    }
                }
                return ages;
            }
        }
    };

    /*
     * Identifiers for loader and message container
     */
    var loader = '#resultsSection .loader';
    var errorContainer = '#messageErrorSection';

    /*
     * Control Loader
     */
    var LOADER = {
        show: function(el){
            var ele = document.querySelector(el);
            ele.classList.add('show');
        },
        hide: function(el){
            var ele = document.querySelector(el);
            ele.classList.remove('show');
        },
        toggle: function(el){
            var ele = document.querySelector(el);
            ele.classList.toggle('show');
        }
    };

    /*
     * Control Error message
     */
    var ERROR = {
        show: function(el){
            var ele = document.querySelector(el);
            ele.classList.add('db');
            LOADER.hide(loader);
            setTimeout(function(){
                ele.classList.add('show');
            },50);
        },
        hide: function(el){
            var ele = document.querySelector(el);
            ele.classList.remove('show');
            setTimeout(function(){
                ele.classList.remove('db');
            },50);
        }
    };

    var Search = {
        /*
         * Api route to search request
         */
        apiRoute: '/api/search',
        /*
         * Method to Cache params into window url
         */
        setLocation: function (data) {
            window.location.hash = '#/results?'+serializeObject(data);
        }
    };

    /*
     * Object to get data instance with params for search request
     */
    Search.getParams = function (str) {
        var coords = $scope.getCoordinates();
        var ages = Filter.Clean.ages(str.ages);

        return {
            name: STORE().session.get('searchString'),
            zip: str.location,
            minAge: ages.min_age,
            maxAge: ages.max_age,
            longitude: coords.longitude,
            latitude: coords.latitude,
            distance: str.distance,
            sport: str.sport,
            gender: str.gender
        };
    };

    /*
     * Put Data from request to result container
     *
     * @param {object} $data
     */
    Search.putData = function($data){

        Page.favicon.badge.setBadge($data.data.length);

        if($data.data.length > 0){
            debugger;
            $scope.results = $data.data;

            setTimeout(function(){
                LOADER.hide(loader);
                ERROR.hide(errorContainer);
            }, 200);

        } else {

            $scope.results = [];

            setTimeout(function(){
                ERROR.show(errorContainer);
            }, 200);

        }

    };

    /*
     * Primary method to execute search request
     */
    Search.execSearch = function(){
        var params = Search.getParams($scope.search.params);
        Page.title( ( (params.name)?params.name+' - ':'' ) + 'Results  |  Wooter');

        LOADER.show(loader);

        /*
         * Api Request
         */
        $http({
            url: Search.apiRoute,
            method: "POST",
            data: params
        }).then(function success(res){
            Search.putData(res.data);
        }, function error(res){
            ERROR.show(errorContainer)
        });

    };


    /*
     * Create search request when page open (or link data is changed)
     * executed just if coordonates have setted
     */
    var checkingCoords = setInterval(function () {
        if(window.$$store.local.check('coords')){
            $scope.coords = angular.fromJson(window.$$store.local.get('coords'));
            Search.execSearch();
            clearInterval(checkingCoords);
        }
    }, 50);

}]);
