/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: League-Create-Edit page
 * License: Wooter LLC.
 * Date: 2016.04.14
 * Description:
 *
 */
__Wooter.factory('LeagueCreateEdit', ['$window', '$http', '$q' , '$stateParams','API', function($window, $http, $q , $stateParams,API){
    var leagues = API.exec('leagues');
    var factory = {};
    var $steps = [
        "basics",
        "details",
        "gallery",
        "season",
        "pricing"
    ];
    var $stepsInfo = {
        basics: {
            title: "Enter League Basics",
            description: "This will help prospective players find you in the league hub."
        },
        details: {
            title: "Enter League Details",
            description: "This will help prospective players understand how your league functions."
        },
        gallery: {
            // title: "Add Photos or Videos",
            // description: "Add photos or videos of your facility or games. You can always add more later."
            title: "Add Photos",
            description: "Add photos of your facility or games. You can always add more later."
        },
        season: {
            title: "Create a Season",
            description: "List all the important dates that players will need to know for the upcoming season."
        },
        forms: {
            title: "Create a Registration Form",
            description: "Enter all the questions you want to ask your players when they register."
        },
        pricing: {
            title: "Enter Prices",
            description: "Create all the different prices you have for this league."
        }
    };

    factory.GET = {
        steps: function (){return $steps},
        stepsInfo: function (){return $stepsInfo},
        defaultModel: function () {
            var _o = {};
            angular.forEach($steps, function (val) { _o[val] = {}; });
            return _o;
        },
        defaultSaveObject: function () {
            var _o = {};
            angular.forEach($steps, function (val) { _o[val] = false; });
            return _o;
        },
        defaultChangesObject: function () {
            var _o = {};
            angular.forEach($steps, function (val) { _o[val] = false; });
            return _o;
        },
        savedSteps: function () {
            if($$store.local.check('saved_steps')){
                return angular.fromJson($$store.local.get('saved_steps'));
            } else {
                return factory.GET.defaultSaveObject();
            }
        },
        changedSteps: function () {
            if($$store.local.check('changed_steps')){
                return angular.fromJson($$store.local.get('changed_steps'));
            } else {
                return factory.GET.defaultSaveObject();
            }
        },
        model: function () {
            var STORE_KEY = $$store.session.get('STORE_KEY');
            // console.log('STORE_KEY'+STORE_KEY);
            // console.log($$store.local.get(STORE_KEY));
            var model = $$store.local.check(STORE_KEY)?angular.fromJson($$store.local.get(STORE_KEY)):factory.GET.defaultModel();
            // console.log(model);
            return factory.Clean.model(model);
        },
        leagueID: function () {
            if ($stateParams.league_id) { //In case of edit get league_id from the URL
                return $stateParams.league_id;
            } else {
                return ($$store.local.check('league_id'))?$$store.local.get('league_id'):undefined;
            }
        },
        seasonID: function () {
            return ($$store.local.check('season_id'))?$$store.local.get('season_id'):undefined;
        },
        dataById: function(id, data){
            if(angular.isArray(data)){
                var dd;

                angular.forEach(data, function (val, key) {
                    if(val.id == id) {
                        dd = val;
                        return false;
                    }
                });

                return dd;
            }
        }
    };

    factory.Check = {
        leagueID: function () {
            return $$store.local.check('league_id');
        },
        seasonID: function () {
            return $$store.local.check('season_id');
        },
        model: function () {
            return $$store.local.check($$store.session.get('STORE_KEY'));
        },
        continue: function () {
            return $$store.session.check('create_continue');
        }
    };

    factory.Clean = {
        model: function (model) {
            // console.log('model'+model);
            var seasonFields = [ "starts_at", "ends_at", "registration_opens_at", "registration_closes_at" ];
            if (!$stateParams.league_id) {
                angular.forEach(seasonFields, function (val) {
                    if(model.season[val] && model.season[val] != 'undefined') { 
                        model.season[val] = new Date(model.season[val]);
                    }
                });
            }
            return model;
        }
    };

    factory.Save = {
        step: function(step){
            var steps = factory.GET.savedSteps();
            steps[step] = true;
            $$store.local.set('saved_steps', steps);
        },
        change: function (step) {
            var steps = factory.GET.changedSteps();
            steps[step] = true;
            $$store.local.set('changed_steps', steps);
        },
        leagueID: function (id) {
            $$store.local.set('league_id', id);
        },
        seasonID: function (id) {
            $$store.local.set('season_id', id);
        }
    };

    factory.Destroy = {
        venueById: function(id, data){
            if(angular.isArray(data)){
                var venues = [];

                angular.forEach(data, function (val, key) {
                    if(val.id != id) {
                        venues.push(val);
                    }
                });

                return venues;
            }
        },
        imageById: function(id, data){
            if(angular.isArray(data)){
                var images = [];

                angular.forEach(data, function (val, key) {
                    if(val.id != id) {
                        images.push(val);
                    }
                });

                return images;
            }
        }
    };

    return factory;
}]);
