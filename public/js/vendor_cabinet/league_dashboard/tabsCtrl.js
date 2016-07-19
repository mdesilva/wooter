landing.controller("tabsCtrl", ['$scope', function($scope) {

  $scope.tabs = [{
    name: "teams"
  }, {
    name: "players"
  }, {
    name: "schedule"
  }, {
    name: "scores/stat"
  }, {
    name: "photos"
  }, {
    name: "videos"
  }, {
    name: "news"
  }, {
    name: "preview"
  }, {
    name: "edit"
  }];

  $scope.months = [{
    name: "jan"
  }, {
    name: "Feb"
  }, {
    name: "mar"
  }, {
    name: "apr"
  }, {
    name: "may"
  }, {
    name: "june"
  }, {
    name: "july"
  }, {
    name: "august"
  }, {
    name: "sep"
  }, {
    name: "oct"
  }, {
    name: "nov"
  }, {
    name: "dec"
  }];

}]);