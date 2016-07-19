/**
 * @ngdoc function
 * @name wooterApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Main home page controller of the wooterApp.
 * @author harsh.r
 */
__Wooter.controller('Courts/AdminController', ['Page', '$scope', '$window', '$rootScope', 'Courts', '$http', '$location', 'filterFilter', 'Notify', function (Page, $scope, $window, $rootScope, Courts, $http, $location, filterFilter, Notify) {
    
        Page.reset();
	Page.title('Courts | Wooter');
        Courts.stylesheets(Page);
        Courts.scripts(Page);
              
        $scope.Locations = [];
       
        $scope.maxSize = 5;
        $scope.getData = Courts.getLocationsAdmin(function(data, status){

        $scope.Locations = data.data;
         // pagination controls
          $scope.totalItems = $scope.Locations.length;
            $scope.currentPage = 1;
            $scope.totalItems = $scope.Locations.length;
            $scope.entryLimit = 100; // items per page
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);

            var new_loc_arr = [];
            for(var n=0, m=data.data.length; n<m; n++){
              if(data.data[n].neighborhood==''){
                new_loc_arr.push(data.data[n]);
              }
            }
            $scope.addZip = function(){
              var count = 0;
            for(var i=0, k=new_loc_arr.length; i<k; i++){
              (function(i){
              setTimeout(function() {
                console.log(new_loc_arr[i].sr_no);
                count++;
              var latlng = new google.maps.LatLng(new_loc_arr[i].lat, new_loc_arr[i].lng);
              var geocoder = new google.maps.Geocoder();
              geocoder.geocode({'latLng': latlng}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          for (var j = 0; j < results[0].address_components.length; j++) {
                              if (results[0].address_components[j].types[0] == 'neighborhood'){
                                  var neighborhood = results[0].address_components[j].short_name;
                                  console.log(new_loc_arr[i].sr_no+' :  '+neighborhood);
                                  //var address = results[0].formatted_address;
                                /*$scope.getData = CourtsAPI.postZipCode(neighborhood, new_loc_arr[i].sr_no, function(data2, status2){
                                  console.log(data2);
                                  console.log(count);
                                });*/
                                }
                          }
                      }
                  } else {
                      console.log("Geocoder failed due to: " + status);
                  }

              });
              

            }, i*3000);
        
            

            })(i);
            }
       }

       //$scope.addZip();

      });

  $scope.editLocation = function(sr_no){
    $location.path('courts/admin/edit/'+sr_no);
  }

  $scope.createCourt = function(){
    $location.path('courts/admin/create/');
  }

  $scope.deleteCourt = function(sr_no){
    var r = confirm('Are you sure you want to delete this court?');
    if(r==false){
        return;
    }else{
    toastr.info('Please wait while we delete');
    angular.element('.delete_court').button('loading');
    $scope.upload_img = CourtsAPI.deleteCourt(sr_no, function( data, status){
        console.log(data);
        toastr.clear();
        angular.element('.delete_court').button('reset');
        if(data.success=='true'){
            toastr.success('Deleted');
            for(var i=0, j=$scope.Locations.length; i<j; i++){
              if($scope.Locations[i].sr_no==sr_no){
            console.log(sr_no);
                $scope.Locations.splice(i, 1);
                $scope.totalItems--;
                break;
              }
            }
            $scope.search = {};
        }else{
            toastr.error('Some error while deleting');
        }
      });
}
  }
  
 /*$scope.viewby = 10;

  $scope.currentPage = 4;
  $scope.itemsPerPage = $scope.viewby;
  $scope.maxSize = 5; //Number of pager buttons to show

  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    console.log('Page changed to: ' + $scope.currentPage);
  };

$scope.setItemsPerPage = function(num) {
  $scope.itemsPerPage = num;
  $scope.currentPage = 1; //reset to first paghe
}
$scope.searchLocation = {};

  $scope.resetFilters = function () {
    // needs to be a function or it won't trigger a $watch
    $scope.searchLocation = {};
  };

  $scope.$watch('searchLocation', function (newVal, oldVal) {
    $scope.filtered = filterFilter($scope.Locations, newVal);
    $scope.totalItems = $scope.filtered.length;
    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);
    $scope.currentPage = 1;
  }, true);*/

  $scope.search = {};

  $scope.resetFilters = function () {
    // needs to be a function or it won't trigger a $watch
    $scope.search = {};
  };
  // $watch search to update pagination
  $scope.$watch('search', function (newVal, oldVal) {
    $scope.filtered = filterFilter($scope.Locations, newVal);
    $scope.totalItems = $scope.filtered.length;
    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);
    $scope.currentPage = 1;
  }, true);

}]);  
