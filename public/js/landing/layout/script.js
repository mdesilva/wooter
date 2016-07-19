landing.controller('HeaderController', function($scope) {

$scope.package = 'test';

$scope.name = '';
$scope.email = '';
$scope.phone = '';
$scope.address1 = '';
$scope.address2 = '';

$scope.organization = '';
$scope.sport = '';


$scope.pro = function(){
   $scope.package = 'Pro';
   $scope.checked1 = true;
   $scope.checked2 = false;
   $scope.checked3 = false;
}
 
$scope.elite = function(){
   $scope.package = 'Elite';
   $scope.checked1 = false;
   $scope.checked2 = true;
   $scope.checked3 = false;
}  

$scope.legend = function(){
   $scope.package = 'Legend';
   $scope.checked1 = false;
   $scope.checked2 = false;
   $scope.checked3 = true;
}

});
