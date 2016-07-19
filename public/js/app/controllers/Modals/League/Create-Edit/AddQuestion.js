/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio@gmail.com
 * For: /#/dashboard/leagues/create?step=question Add Question Controller
 * License: Wooter LLC.
 * Date: 2016.04.13
 * Description:
 *
 */
__Wooter.controller('Modals/League/Create-Edit/AddQuestion', ['$scope', 'API', function ($scope, API) {

    var $api = API.exec('leagueRegistrationQuestions');

    if (count($scope.$timeSlot) == 0) {
        $scope.$timeSlot = {
            edit: false
        };
    }

    function save(model){
        loading();
        
        var $cfg = angular.extend({
            leagueId: $scope.leagueID,
            league_id: $scope.leagueID,
            season_id: $scope.seasonID,
            seasonId: $scope.seasonID
        }, model);
        $scope.timeSlots = ($scope.timeSlots)?$scope.timeSlots:[];
        
        $api.save($cfg, function (res) {
            $scope.timeSlots.push(res.data);
            $scope.cacheLeagueData();
            loaded();
            $$notify.create({
                message: 'Done! Time Slot added.',
                type: 'success',
                fontIcon: 'material',
                icon: 'check'
            });
        }, function () {
            loaded();
            $$notify.create({
                message: tpl('Error: Time Slot not saved, try again later!', model),
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
            seasonTimeslot: model.id
        }, model);
        $scope.timeSlots = ($scope.timeSlots)?$scope.timeSlots:[];

        console.log($cfg);

        $api.update($cfg, function (res) {
            $scope.cacheLeagueData();
            loaded();
            $$notify.create({
                message: 'Done! Time Slot updated.',
                type: 'success',
                fontIcon: 'material',
                icon: 'check'
            });
        }, function () {
            loaded();
            $$notify.create({
                message: tpl('Error: Time Slot not updated, try again later!', model),
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        });
    }


    $scope.addQuestion = function (er) {
        if(count(er.$error) > 0){
            $$notify.create({
                message: 'Make sure all informations are correct!',
                type: 'error',
                fontIcon: 'material',
                icon: 'error_outline'
            });
        } else {
            var $data =  {
                league_season_id: $scope.$timeSlot.league_season_id,
                weekday_id: $scope.$timeSlot.weekday_id,
                starts_at: $scope.$timeSlot.starts_at,
                finish_at: $scope.$timeSlot.finish_at,
                league_game_venue_id: $scope.$timeSlot.league_game_venue_id
            };

            if(angular.isDefined($scope.$timeSlot.id)){
                $data.id = $scope.$timeSlot.id;
            }

            if ($scope.$timeSlot.edit) {
                edit($data);
            } else {
                save($data);
            }

            $scope.cacheLeagueData();
            $scope.closeModal();
        }

        return false;
    };

}]);
