/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Courts App
 * License: Wooter LLC.
 * Date: 2016.03.07
 * Description: API Factory used on Courts app
 *
 */
__Wooter.factory('Courts', ['$http', '$q', '$rootScope', function($http, $q, $rootScope){
        
        var courts = {};
        var $this = courts;
        
        courts.courts;
        
        courts.getCourts = function(request) {
            return $http.get($this.buildUrl(request))
                        .success(function(response){
                            alert(response.data[0].name);
                            $this.courts = response.data;
            });
        };
        
        courts.getCourtsByLocation = function(distance, latitude, longitude){
            var request = $this.getCourtsRequest();
            request.distance = distance ? distance : 0;
            request.latitude = latitude;
            request.longitude = longitude;
            return $this.getCourts(request);
        };
        
        courts.getLocations = function (distance, lat, lng, callback){
            $http({
                method: 'GET',
                params: {
                    distance: distance,
                    lat: lat,
                    lng: lng
                },
                url: $rootScope.MAIN_REST_URL+'get_locations.php',
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.getLocationsAdmin = function (callback){
            $http({
                method: 'GET',
                url: $rootScope.MAIN_REST_URL+'get_locations_admin.php',
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.getLocationData = function (id, callback){
            $http({
                method: 'GET',
                url: $rootScope.MAIN_REST_URL+'get_location_data.php',
                params: {
                    id: id
                }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.changeEmail = function (UserId, password, EmailAddress, UserName, callback){
            $http({
                method: 'POST',
                url: $rootScope.Main_Url+'user/emailaddress',
                data: 'UserId='+UserId+'&Password='+password+'&EmailAddress='+EmailAddress+'&UserName='+UserName,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.uploadImage = function (image_avail, locationId, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'upload.php',
                data: 'image='+image_avail+'&location_id='+locationId,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.deleteImage = function (sr_no, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'delete_image.php',
                data: 'sr_no='+sr_no,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.deleteVideo = function (sr_no, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'delete_video.php',
                data: 'sr_no='+sr_no,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.createCourt = function (data, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'add_location_data.php',
                data: data,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.postZipCode = function (neighborhood, sr_no, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_zipcode.php',
                data: 'sr_no='+sr_no+'&neighborhood='+neighborhood,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.addVideo = function (video, locationId, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'addVideo.php',
                data: 'video='+video+'&location_id='+locationId,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateImageSeq = function (images, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_image_seq.php',
                data: 'images='+images,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateVideosSeq = function (videos, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_video_seq.php',
                data: 'videos='+videos,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateWorkWeek = function (id, work_week, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_work_week.php',
                data: 'court_id='+id+'&work_week='+work_week,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateCourtPrice = function (id, price, duration, clearSlots, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_price.php',
                data: 'court_id='+id+'&price='+price+'&duration='+duration+'&clearSlots='+clearSlots,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.addManualOff = function (fulldate, type, date, id, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'add_manual_off.php',
                data: 'fulldate='+fulldate+'&type='+type+'&date='+date+'&court_id='+id,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.saveAvailability = function (start_date, end_date, id, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_availability.php',
                data: 'start_date='+start_date+'&end_date='+end_date+'&court_id='+id,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateTimeSlots = function (day, slots, id, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_time_slots.php',
                data: 'day='+day+'&slots='+slots+'&court_id='+id,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateExtendedSchedule = function (schedule, id, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_extended_schedule.php',
                data: 'schedule='+schedule+'&court_id='+id,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.updateManualTimeSlots = function (slots, id, date, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'update_manual_time_slots.php',
                data: 'slots='+slots+'&court_id='+id+'&date='+date,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.bookCourt = function (date, dateObj, court_id, start_time, end_time, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'book_court.php',
                data: 'date='+date+'&court_id='+court_id+'&time_slot='+dateObj+'&start_time='+start_time+'&end_time='+end_time,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.deleteCourt = function (sr_no, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'delete_court.php',
                data: 'sr_no='+sr_no,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.getPhotos = function (callback){
            $http({
                method: 'POST',
                url: 'https://wooter.co/hackathon/getLeagueImages',
                //data: {token: "87u10389uj98fojsd89fus98mSDFMSLKJ", league_id:1406}
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.saveFeatures = function (features, court_id, callback){
            $http({
                method: 'POST',
                url: $rootScope.MAIN_REST_URL+'saveFeatures.php',
                data: 'features='+features+'&court_id='+court_id,
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                //data: {token: "87u10389uj98fojsd89fus98mSDFMSLKJ", league_id:1406}
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        courts.searchCourt = function (text, callback){
            $http({
                method: 'GET',
                params: {
                    text: text
                },
                url: $rootScope.MAIN_REST_URL+'searchCourt.php',
            }).success(function(data, status, headers, config){
                callback(data, status);
            }).error(function(data, status, headers, config){
                callback(data, status);
            });
        };
        
        /*
         * Return standard request object for courts
         */
    
        courts.getCourtsRequest = function() {
            var request = {};
            
            request.url       = 'courts';
            request.distance  = 0;
            request.latitude  = 0;
            request.longitude = 0;
            request.offset    = 0;
            request.limit     = 20;
            
            return request;
        };
            
        /*
         * Build url from request object
         * @param request
         */
        
        courts.buildUrl = function(request) {
            var url = 'api';
            for(var param in request) {
                url += '/' + request[param];
            }
            return url;
        };
        
        courts.styles = [{"featureType":"water","elementType":"all","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"on"}]},{"featureType":"water","elementType":"labels","stylers":[{"hue":"#7fc8ed"},{"saturation":55},{"lightness":-6},{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"hue":"#83cead"},{"saturation":1},{"lightness":-15},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#f3f4f4"},{"saturation":-84},{"lightness":59},{"visibility":"on"}]},{"featureType":"landscape","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbbbbb"},{"saturation":-100},{"lightness":26},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-35},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#ffcc00"},{"saturation":100},{"lightness":-22},{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"hue":"#d7e4e4"},{"saturation":-60},{"lightness":23},{"visibility":"on"}]}];

        courts.models = {
            privacy: [{'name': 'Public', 'value': 'public'}, {'name':'Private', 'value': 'private'}],
            distance: [{'name':'Any', 'value': ''}, {'name': '5 Miles', 'value':5}, {'name':'10 Miles', 'value': 10}, {'name':'100 Miles', 'value': 100}, {'name':'500 Miles', 'value': 500} ]
        };
        
        courts.stylesheets = function(Page) {
            Page.stylesheets([
                'css/vendor/angular-ui-select/dist/select.min.css',
                'css/vendor/angular_material/css/angular_material.min.css',
                'css/vendor/animate.css/animate.min.css',
                'css/vendor/angular-growl-v2/build/angular-growl.min.css',
                'css/vendor/font-awesome/css/font-awesome.min.css',
                'css/styles/angular-toastr.min.css',
                'css/styles/ng-img-crop.css',
                'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
                'css/styles/angular_bootstrap_lightbox.css',
                'css/vendor/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.css',
                'css/styles/gallery.css',
                'css/styles/main.css',
                'css/styles/header.css'
            ]);           
        };
        
        courts.scripts = function(Page){
            Page.scripts([
                'js/vendors/vendor/jquery/dist/jquery.min.js',
                'js/vendors/vendor/angular/angular.min.js',
                'js/vendors/vendor/bootstrap-sass-official/assets/javascripts/bootstrap.min.js',
                'js/vendors/vendor/angular-animate/angular-animate.min.js',
                'js/vendors/vendor/angular-cookies/angular-cookies.min.js',
                'js/vendors/vendor/angular-resource/angular-resource.min.js',
                'js/vendors/vendor/angular-route/angular-route.min.js',
                'js/vendors/vendor/angular-sanitize/angular-sanitize.min.js',
                'js/vendors/vendor/angular-ui-select/dist/select.min.js',
                'js/vendors/vendor/angular-growl-v2/build/angular-growl.min.js',
                'js/vendors/vendor/angular_material/js/angular_material.min.js',
                'js/vendors/vendor/lodash/lodash.min.js',
                'js/vendors/vendor/moment/moment.js',
                'js/vendors/vendor/angular-bootstrap-calendar/dist/js/angular-bootstrap-calendar-tpls.min.js',
                'js/vendors/angular/angular_aria.min.js',
                'js/vendors/angular/interact.min.js',
                'js/vendors/angular/ui-bootstrap-tpls.min.js',
                'js/vendors/angular/angular-toastr.js',
                'js/vendors/angular/angular-file-upload.min.js',
                'js/vendors/angular/angular-img-cropper.min.js',
                //'js/vendors/vendor/jquery/dist/jquery.min.js',
                'js/vendors/angular/ng-videosharing-embed.min.js',
                //'js/vendors/angular/geolocation-marker.js',
                'js/vendors/angular/markerclusterer.js',
                'js/vendors/angular/header/header.js',
                'js/vendors/angular/header/angular-dropdowns.js',
                'https://maps.googleapis.com/maps/api/js?key=AIzaSyC0jvXRmR2SkzVpH6_KJ7CILtiQMo7AYv4&signed_in=true&libraries=places',
                'http://rubaxa.github.io/Sortable/Sortable.js',
                'http://rubaxa.github.io/Sortable/ng-sortable.js'
            ]);
        };
        
        return courts;
}]);



