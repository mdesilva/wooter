/**
 * @ngdoc function
 * @name wooterApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Main home page controller of the wooterApp.
 * @author harsh.r
 */

__Wooter.controller('Courts/CourtsController', ['Page', '$scope', '$window', 'TimesArray', '$rootScope', '$http', 'Courts', 'Notify', '$location', 'filterFilter', function (Page, $scope, $window, TimesArray, $rootScope, $http, Courts, Notify, $location, filterFilter) {

    Page.reset();
    Page.title('Courts | Wooter');
    Courts.stylesheets(Page);
    Courts.scripts(Page);
    
    var vm = this;
        vm.searchObj = {};

        vm.datePickerOpened = false;
        vm.times = TimesArray;

        vm.city = 'New york';
     
    var map,
        bounds = new google.maps.LatLngBounds(),
        mapOptions = {
            mapTypeId: 'roadmap'
        };

    var userLocationSet = false;
    var userPos = '';
    var markerCluster='';

    var styles = Courts.styles;


    /************* NEW GOOGLE CODE **************/
    var search = $location.search();

    vm.locationData = [];
    $scope.markers = [];
    $scope.markers1 = [];
    $scope.maxSize = 5;
    $scope.genderObj = {};
    $scope.genderOpen = false;
    $scope.searchCourtActive = false;
    $scope.gettingResult = true;
    $scope.searchCourt = '';
    $scope.privacy_type = '';
    $scope.privacy_type_array = Courts.models.privacy;
    $scope.distance_array = Courts.models.distance;
    $scope.distance = '';
    $scope.LAT = 0;
    $scope.LNG = 0;
    $scope.preview = search.preview;

    var getImage = function(){
        return {
            url: 'assets/images/map-marker.png',
            scaledSize: new google.maps.Size(40, 30),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 0)
        };
    };
    var image1 = getImage(),
        image2 = getImage();

    function ZoomControl(controlDiv, map) {
        var controlWrapper = document.createElement('div');
            controlWrapper.style.backgroundColor = 'white';

            controlWrapper.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
            controlWrapper.style.cursor = 'pointer';
            controlWrapper.style.textAlign = 'center';
            controlWrapper.style.padding = '3px 5px';
            controlWrapper.style.marginRight = '5px';
            controlWrapper.style.borderRadius = '3px';

        var zoomOutButton = document.createElement('div');
            zoomOutButton.innerHTML = '<i class="fa fa-undo fa-fw" style="font-size:20px;"></i>';

        controlDiv.style.padding = '5px';
        controlDiv.appendChild(controlWrapper);
        controlWrapper.appendChild(zoomOutButton);
        google.maps.event.addDomListener(zoomOutButton, 'click', function() { map.setZoom(map.getZoom() - 5) });
    }

    function LocationControl(controlDiv, map) {
        var currentLocation = document.createElement('div');
            currentLocation.innerHTML = '<i class="fa fa-map-marker fa-fw" style="font-size:20px;"></i>';

        var controlWrapper = document.createElement('div');
            controlWrapper.style.backgroundColor = 'white';

            controlWrapper.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
            controlWrapper.style.cursor = 'pointer';
            controlWrapper.style.textAlign = 'center';
            controlWrapper.style.padding = '3px 5px';
            controlWrapper.style.marginLeft = '5px';
            controlWrapper.style.borderRadius = '3px';
            controlWrapper.appendChild(currentLocation);

        controlDiv.appendChild(controlWrapper);
        controlDiv.style.padding = '5px';

        google.maps.event.addDomListener(currentLocation, 'click', geolocate);
    }

    /**
     * Initialize Function
     */
    (function(){
        var latlng = new google.maps.LatLng(40.81750,-73.84553);
        var mapOptions = {
            zoom: 6,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: styles
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        var zoomControlDiv = document.createElement('div');
            zoomControlDiv.index = 1;
            
        var zoomControl = new ZoomControl(zoomControlDiv, map);

        var locationControlDiv = document.createElement('div');
        var locationControl = new LocationControl(locationControlDiv, map);
            locationControlDiv.index = 1;

        map.setTilt(45);
        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(zoomControlDiv);
        map.controls[google.maps.ControlPosition.LEFT_TOP].push(locationControlDiv);
        markerCluster = new MarkerClusterer(map);
        
    })();

    /**
     * Set Map On all
     * @param map
     */
    function setMapOnAll(map) {
        for (var i = 0; i < $scope.markers1.length; i++) {
            $scope.markers1[i].setMap(map);
        }
    }

    /**
     * Clear All markers from map
     */
    function clearMarkers() {
        setMapOnAll(null);
    }

    /**
     * Delete Markers
     */
    function deleteMarkers() {
        if($scope.markers1.length > 0){
            markerCluster.clearMarkers();
            clearMarkers();
            $scope.markers = [];
            $scope.markers1 = [];
            fetch_locations(bounds, map, $scope.distance);
        }else{
            fetch_locations(bounds, map, $scope.distance);
        }
    }

    /**
     * Geolocate function
     */
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {

                if(userLocationSet === false){
                    var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                        accuracy = position.coords.accuracy;

                    userLocationSet = true;
                    userPos = pos;

                    var marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        icon: 'images/blue_dot.png'
                    });

                    var circle = new google.maps.Circle({
                        map: map,
                        radius: accuracy,    // 10 miles in metres
                        fillColor: '#00acec',
                        strokeWeight: 0,
                        center: pos
                    });

                    circle.bindTo('center', marker, 'position');
                }
                map.panTo(userPos);
                map.setZoom(20);
            });
        }
    }

    /**
     * Function to get all locations
     *
     * @param bounds
     * @param map
     * @param distance
     */
    function fetch_locations(bounds, map, distance){
        Notify('Getting Courts!');
        
        $scope.courts = Courts;
        $scope.courts.getCourtsByLocation(distance, $scope.LAT, $scope.LNG)
                     .success(function(response){
                        Notify().clear();
                        if(response.data){

                            var mapData = response.data,
                                i;
                            vm.locationData = response.data_new;
                            $scope.gettingResult = false;
                            $scope.totalItems = vm.locationData.length;
                            $scope.currentPage = 1;
                            $scope.totalItems = vm.locationData.length;
                            $scope.entryLimit = 10; // items per page
                            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);



                            for(i=0, j=mapData.length; i<j; i++){
                                var marker_data = [mapData[i].address, mapData[i].lat, mapData[i].lng, mapData[i].sr_no];
                                $scope.markers.push(marker_data);

                            }

                            var infoWindow = new google.maps.InfoWindow(),
                                marker;

                            for(i = 0; i < $scope.markers.length; i++) {
                                var position = new google.maps.LatLng($scope.markers[i][1], $scope.markers[i][2]);
                                bounds.extend(position);

                                marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                    icon: image,
                                    title: $scope.markers[i][0]
                                });

                                $scope.markers1.push(marker);

                                marker['customInfo'] = $scope.markers[i][3];

                                google.maps.event.addListener(marker, 'click', (function(marker) {
                                    return function() {

                                        angular.forEach(vm.locationData, function(item) {
                                            if (item.court_data.sr_no === marker.customInfo) {

                                                $scope.$apply(function () {
                                                    vm.selectedItem = item;
                                                    vm.selectedWorkWeek = (item.court_data.work_week != '')?JSON.parse(item.court_data.work_week):[];
                                                });

                                            }
                                        });

                                        map.setZoom(20);
                                        map.setCenter(marker.getPosition());
                                    }
                                })(marker, i));

                                google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                                    return function() {
                                        marker.setIcon(image2);
                                    }
                                })(marker, i));

                                google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
                                    return function() {
                                        marker.setIcon(image);
                                    }
                                })(marker, i));

                            }

                            map.fitBounds(bounds);
                            map.setCenter(bounds.getCenter());
                            markerCluster.addMarkers($scope.markers1);

                            if($scope.preview!==undefined){
                                angular.forEach(vm.locationData, function(item) {
                                    if (item.court_data.sr_no === $scope.preview) {

                                        var coords = new google.maps.LatLng(
                                            item.court_data.lat,
                                            item.court_data.lng
                                        );

                                        map.setZoom(20);
                                        map.setCenter(coords);

                                        vm.selectedItem = item;
                                    }
                                });
                            }

                        }else{
                            Notify().clear();
                            Notify('Something went wrong!', 'error');
                        }
        });

        /*$scope.inmate_post_detail = Courts.getLocations(distance, $scope.LAT, $scope.LNG, function(data, status){

            Notify().clear();

            if(status == 200){
                if(data.success=='true'){

                    var mapData = data.data,
                        i;
                    vm.locationData = data.data_new;
                    $scope.gettingResult = false;
                    $scope.totalItems = vm.locationData.length;
                    $scope.currentPage = 1;
                    $scope.totalItems = vm.locationData.length;
                    $scope.entryLimit = 10; // items per page
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);



                    for(i=0, j=mapData.length; i<j; i++){
                        var marker_data = [mapData[i].address, mapData[i].lat, mapData[i].lng, mapData[i].sr_no];
                        $scope.markers.push(marker_data);

                    }

                    var infoWindow = new google.maps.InfoWindow(),
                        marker;

                    for(i = 0; i < $scope.markers.length; i++) {
                        var position = new google.maps.LatLng($scope.markers[i][1], $scope.markers[i][2]);
                        bounds.extend(position);

                        marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            icon: image,
                            title: $scope.markers[i][0]
                        });

                        $scope.markers1.push(marker);

                        marker['customInfo'] = $scope.markers[i][3];

                        google.maps.event.addListener(marker, 'click', (function(marker) {
                            return function() {

                                angular.forEach(vm.locationData, function(item) {
                                    if (item.court_data.sr_no === marker.customInfo) {

                                        $scope.$apply(function () {
                                            vm.selectedItem = item;
                                            vm.selectedWorkWeek = (item.court_data.work_week != '')?JSON.parse(item.court_data.work_week):[];
                                        });

                                    }
                                });

                                map.setZoom(20);
                                map.setCenter(marker.getPosition());
                            }
                        })(marker, i));

                        google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                            return function() {
                                marker.setIcon(image2);
                            }
                        })(marker, i));

                        google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
                            return function() {
                                marker.setIcon(image);
                            }
                        })(marker, i));

                    }

                    map.fitBounds(bounds);
                    map.setCenter(bounds.getCenter());
                    markerCluster.addMarkers($scope.markers1);

                    if($scope.preview!==undefined){
                        angular.forEach(vm.locationData, function(item) {
                            if (item.court_data.sr_no === $scope.preview) {

                                var coords = new google.maps.LatLng(
                                    item.court_data.lat,
                                    item.court_data.lng
                                );

                                map.setZoom(20);
                                map.setCenter(coords);

                                vm.selectedItem = item;
                            }
                        });
                    }

                }else{
                    Notify().clear();
                    Notify('Something went wrong!', 'error');
                }
            }else{
                Notify().clear();
                Notify('Something went wrong!', 'error');
            }
        });*/
    }

    /************* NEW GOOGLE CODE END **************/
    $scope.showList = function(){
        vm.selectedItem = undefined;
        //map.setZoom(4);
        map.fitBounds(bounds);
        map.setCenter(bounds.getCenter());
    };

    $scope.totalDisplayed = 20;

    $scope.loadMore = function () {
        $scope.totalDisplayed += 20;
    };


    vm.getDetails = function(item) {
        var coords = new google.maps.LatLng(
            item.court_data.lat,
            item.court_data.lng
        );
        map.setZoom(20);
        map.setCenter(coords);
        vm.selectedItem = item;
        console.log(item);
        if(item.court_data.work_week!=''){
            vm.selectedWorkWeek = JSON.parse(item.court_data.work_week);
        }else{
            vm.selectedWorkWeek = [];
        }

    };

    vm.showList = $scope.showList;

    vm.clearFilters = function() {
        vm.searchObj = {};
    };

    /*function init(locations) {
        $scope.$watch('courts.filteredItems', function() { }, true);

        $scope.$watch('courts.searchObj.start', function() {
            if (vm.searchObj.start) {
                if (!vm.searchObj.date) {
                    vm.searchObj.date = new Date();
                }
                if (!vm.searchObj.end || vm.searchObj.end.value <= vm.searchObj.start.value) {
                    vm.searchObj.end = $window._.find(TimesArray, function(time) {
                        return time.value > vm.searchObj.start.value;
                    });
                }
            }
        });

        $scope.$watch('courts.searchObj.end', function() {
            if (vm.searchObj.end) {
                if (!vm.searchObj.date) {
                    vm.searchObj.date = new Date();
                }
                if (!vm.searchObj.start || vm.searchObj.start.value >= vm.searchObj.end.value) {
                    vm.searchObj.start = $window._.findLast(TimesArray, function(time) {
                        return time.value < vm.searchObj.end.value;
                    });
                }
            }
        });
    }*/

    $scope.toggleGender = function(){
        if($scope.genderOpen==false){
            $scope.genderObj = {
                'display': 'block',
                'margin-top': '30px',
                'opacity': '1',
                '-webkit-transition': 'all 1s',
                '-moz-transition': 'all 1s',
                '-ms-transition': 'all 1s',
                '-o-transition': 'all 1s',
                'transition': 'all 1s'
            };
            $scope.genderOpen = true;
        }else{
            $scope.genderObj = {
                'display': 'none',
                'margin-top': '0px',
                'opacity': '0',
                '-webkit-transition': 'all 1s',
                '-moz-transition': 'all 1s',
                '-ms-transition': 'all 1s',
                '-o-transition': 'all 1s',
                'transition': 'all 1s'
            };
            $scope.genderOpen = false;
        }
    };

    // New court search
    $scope.search = {};

    $scope.resetFilters = function () {
        $scope.search = {};
        $scope.distance = '';
    };
    function successFunction(position) {
        $scope.LAT = position.coords.latitude;
        $scope.LNG = position.coords.longitude;
        deleteMarkers();
    }

    function errorFunction(){
        if($scope.distance!=''){
            //toastr.error("Unable to get current location. Please allow to share your location.");
        }else{
            deleteMarkers();
        }
    }
    $scope.$watch('search', function (newVal, oldVal) {
        $scope.filtered = filterFilter(vm.locationData, newVal);
        $scope.totalItems = $scope.filtered.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);
        $scope.currentPage = 1;
    }, true);

    $scope.$watch('distance', function (newVal) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        }

    });
    
    $rootScope.$on('headerCourtSearch', function(events, args){
        $scope.search=args;
        /*angular.forEach(vm.locationData, function(value){
         if(value.court_data.name==args || ){
         $scope.item.time_slots[filterDay] = value.time_slots;
         }
         });*/

    });

    $scope.dateFilter = function(){
        var data_array = [];
        var inputDate = new Date($scope.myDate);
        var inputDate = inputDate.setHours(0,0,0,0);
        angular.forEach(vm.locationData, function(value){
            var compareDate = new Date(value.court_data.end_date);
            if(inputDate<=compareDate.setHours(0,0,0,0)){
                console.log(inputDate);
                data_array.push(value);
            }
        });
        $scope.filtered = data_array;
        $scope.totalItems = $scope.filtered.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);
        $scope.currentPage = 1;
        console.log($scope.filtered);
    }

    $scope.filterFn = function(element){
        // return element.court_data.name.match(/^Ma/) ? true : false;
    }

    // end search

    /*$scope.$watch('searchCourt', function(){
     if($scope.searchCourt!=''){
     $scope.searchCourtActive = true;
     console.log($scope.searchCourtActive);
     }else{
     $scope.searchCourtActive = false;
     }
     })*/

}]);