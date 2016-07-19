/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: /#/dashboard/leagues/create?step=basics Add Venue Modal
 * License: Wooter LLC.
 * Date: 2016.04.13
 * Description:
 *
 */
__Wooter.controller('Modals/League/Create-Edit/AddVenueController', ['$scope', 'uiGmapGoogleMapApi', 'API', 'LeagueCreateEdit', '$state', function ($scope, uiGmapGoogleMapApi, API, LeagueCreateEdit, $state) {

    var $api = API.exec('leagueGameVenues');

    if ($scope.$addVenue && $scope.$addVenue.edit == false) {
        $scope.$addVenue = {
            game_venue: {
                location: {}
            },
            edit: false,
            number_of_courts: 1
        };
    }

    if (angular.isUndefined($scope.$addVenue)) {
        $scope.$addVenue = {
            game_venue: {
                location: {}
            },
            edit: false,
            number_of_courts: 1
        };
    }

    function updateWhereId(id, data, venues) {
        var dd = [];

        angular.forEach(venues, function (val) {
            if (parseInt(val.id) == parseInt(id)) {
                dd.push(data);
            } else {
                dd.push(val);
            }
        });

        return dd;
    }

    function save(model, after){
        var venueCFG = {
            leagueId: $scope.leagueID,
            name: model.name,
            zip_code: model.zip,
            street: model.street,
            full_address: model.full_address,
            country_id: model.country_id,
            city_name: model.city_name,
            state: model.state,
            flat: model.flat,
            number_of_courts: model.number_of_courts,
            longitude: model.longitude,
            latitude: model.latitude
        };
        loading();
        $scope.venues = ($scope.venues)?$scope.venues:[];
        $api.save(venueCFG, function (res) {
            $scope.venues.push(res.data);
            after();
            loaded();
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
    }

    function edit(model, after){
        loading();

        var venueCFG = {
            leagueId: $scope.leagueID,
            gameVenueId: model.game_venue_id,
            name: model.name,
            zip_code: model.zip,
            street: model.street,
            full_address: model.full_address,
            country_id: model.country_id,
            city_name: model.city_name,
            state: model.state,
            flat: model.flat,
            number_of_courts: model.number_of_courts,
            longitude: model.longitude,
            latitude: model.latitude,
            gameVenuesId: model.id
        };

        $api.put(venueCFG, function (res) {
            $scope.action('update', 'venues', {});
            after();
            loaded();
            $$notify.create({
                message: 'Done! Game venue updated.',
                type: 'success',
                fontIcon: 'material',
                icon: 'check'
            });
        }, function () {
            loaded();
            $$notify.create({
                message: tpl('Error: Game venue not edited, try again later!', model),
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        });
    }

    function getLastID(venues) {
        return venues[parseInt(_.last(_.keys(venues)))].id+1;
    }

    $scope.addVenue = function (er) {
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

                        var $data =  {
                            id: $scope.$addVenue.id,
                            name: $scope.$addVenue.game_venue.location.name,
                            full_address: fullAddress($scope.$addVenue),
                            country_id: $scope.$addVenue.game_venue.location.country_id,
                            street: $scope.$addVenue.game_venue.location.street,
                            city_name: $scope.$addVenue.game_venue.location.city_name,
                            flat: ($scope.$addVenue.flat)?$scope.$addVenue.game_venue.location.flat:'',
                            state: $scope.$addVenue.game_venue.location.state,
                            zip: $scope.$addVenue.game_venue.location.zip,
                            number_of_courts: $scope.$addVenue.game_venue.number_of_courts,
                            court_name: $scope.$addVenue.game_venue.court_name,
                            longitude: results[0].geometry.location.lng(),
                            latitude: results[0].geometry.location.lat()
                        };

                        if ($scope.$addVenue.edit) {
                            $data.game_venue_id = $scope.$addVenue.game_venue.id;
                            edit($data, function () {
                                $scope.cacheLeagueData();
                                $scope.closeModal();
                            });
                        } else {
                            save($data, function () {
                                $scope.cacheLeagueData();
                                $scope.closeModal();
                                if($scope.$addVenueData){
                                    $scope.showModal($scope.$addVenueData.event, $scope.$addVenueData.from);
                                }
                            });
                        }

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

}]);
