/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: /#/dashboard/leagues/create?step=pricing Add price Controller
 * License: Wooter LLC.
 * Date: 2016.04.13
 * Description:
 *
 */
__Wooter.controller('Modals/League/Create-Edit/AddPriceController', ['$scope', 'API', function ($scope, API) {

    var $api = API.exec('leaguePrices');

    if (count($scope.$addPrice) == 0) {
        $scope.$addPrice = {
            edit: false
        };
    }

    function save(model){
        loading();
        
        var $cfg = angular.extend({
            leagueId: $scope.leagueID,
            league_id: $scope.leagueID
        }, model);
        $scope.prices = ($scope.prices)?$scope.prices:[];
        $api.save($cfg, function (res) {
            $scope.prices.push(res.data);
            $scope.cacheLeagueData();
            loaded();
            $$notify.create({
                message: 'Done! Price added.',
                type: 'success',
                fontIcon: 'material',
                icon: 'check'
            });
        }, function () {
            loaded();
            $$notify.create({
                message: tpl('Error: Price not saved, try again later!', model),
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        });
    }

    function edit(model){
        loading();
        var $cfg = angular.extend({
            leagueId: $scope.leagueID,
            leaguePriceId: model.id
        }, model);
        $scope.prices = ($scope.prices)?$scope.prices:[];

        console.log($cfg);

        $api.put($cfg, function(res) {
            $scope.action('update', 'price', {});
            $scope.cacheLeagueData();
            loaded();
            $$notify.create({
                message: 'Done! Price updated.',
                type: 'success',
                fontIcon: 'material',
                icon: 'check'
            });
        }, function () {
            loaded();
            $$notify.create({
                message: tpl('Error: Price not updated, try again later!', model),
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        });
    }


    $scope.addPrice = function (er) {
        if(count(er.$error) > 0){
            $$notify.create({
                message: 'Make sure all informations are correct!',
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        } else {
            var $data =  {
                league_id: $scope.leagueID,
                name: $scope.$addPrice.name,
                price: $scope.$addPrice.price,
                description: $scope.$addPrice.description,
                url: $scope.$addPrice.url,
                currency_id: 1
            };

            if(angular.isDefined($scope.$addPrice.id)){
                $data.id = $scope.$addPrice.id;
            }

            if ($scope.$addPrice.edit) {
                edit($data);
            } else {
                save($data);
            }

            $scope.cacheLeagueData();
            $scope.closeModal();
            $scope.$addPrice = {};
        }

        return false;
    };




}]);
