/**
 * @ngdoc function
 * @name wooterApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Main home page controller of the wooterApp.
 * @author harsh.r
 */

__Wooter.controller('Courts/CreateCourtController', ['Page', '$scope', '$window', '$rootScope', 'Courts', '$http', 'Notify', function (Page, $scope, $window, $rootScope, Courts, $http, Notify) {

    Page.reset();
    Page.title('Courts | Wooter');
    Courts.stylesheets(Page);
    Courts.scripts(Page);

    $scope.LocationData = {};

    $scope.locationCategories = [];
    $scope.court_types = ['basketball', 'tennis'];
    $scope.field_types = ['baseball', 'soccer', 'softball'];
    $scope.show_location_info = true;
    $scope.court_privacy_type = 'public';
    $scope.editLocation = function(sr_no){


        var
            scheduleEditBox = $('.schedule-edit-box'),
            modalNode = $('#schedule-location-modal'),
            step1Node = modalNode.find('.step-1'),
            step2Node = modalNode.find('.step-2'),
            step1Form = step1Node.find('.step-1-form'),
            step2Form = step2Node.find('.step-2-form'),
            mapNode = modalNode.find('.map')[0],
            xInputNode = step2Form.find('input[name=lat]'),
            yInputNode = step2Form.find('input[name=lng]'),

            addressesSelectNode = scheduleEditBox.find('select[name=address]'),

            location,
            map;
        var showModal = function () {
            modalNode.modal('show');

            $(document). one ('keyup', function (e){
                if (e.keyCode == 27) {
                    modalNode.modal('hide');
                }
            });
        };
        location = new google.maps.LatLng(40.86386, -73.90598);
        var hideModal = function ()
        {
            modalNode.modal('hide');

            afterHideModal();
        };

        var afterHideModal = function ()
        {
            step2Node.hide();
            step1Node.hide();

            step1Form[0].reset();
            step2Form[0].reset();
        };

        var step1 = function () {
            step1Node.slideDown('fast');
            var input = (document.getElementsByClassName('street'));
            var autocomplete = new google.maps.places.Autocomplete(input[0]);
            /*var autocomplete = new google.maps.places.Autocomplete(
             * @type {!HTMLInputElement} (document.getElementById('street_address')),
             {types: ['geocode']});*/

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var streetInputNode = step1Form.find('input[name=street]');
                var cityInputNode = step1Form.find('input[name=city]');
                var stateInputNode = step1Form.find('input[name=state]');
                var zipInputNode = step1Form.find('input[name=zip]');

                var data = autocomplete.getPlace();
                console.log(data);
                step2Form.find('input[name=name]').val( streetInputNode.val() );
                location = data.geometry.location;
                streetInputNode.empty();

                $.each(data.address_components, function (i, v){
                    $.each(v.types, function (index, value){

                        switch (value) {
                            case 'street_number' :
                                streetInputNode.val(v.short_name);
                                break;
                            case 'route' :
                                streetInputNode.val(streetInputNode.val() + ' ' +v.short_name);
                                break;
                            case 'locality' :
                                cityInputNode.val(v.short_name);
                                break;
                            case 'administrative_area_level_1' :
                                stateInputNode.val(v.short_name);
                                break;
                            case 'postal_code' :
                                zipInputNode.val(v.short_name);
                                break;
                        }

                    });
                });
                initialize();
                return false;
            });
        };

        var getLatLng = function (){
            var geocoder = new google.maps.Geocoder();
            var address = step1Form.find('input[name=street]').val();
            var test = '';
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    test = new google.maps.LatLng(latitude, longitude);
                    alert(test);
                    return test;
                }
            });
        };

        /**
         * Initialize function
         */
        (function () {

            if(location===undefined){
                var latitude =  xInputNode.val();
                var longitude = yInputNode.val();
                location = new google.maps.LatLng(latitude, longitude);
            }

            var mapOptions = {
                center: location,
                zoom: 17
            };
            map = new google.maps.Map(mapNode,
                mapOptions);

            var marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: location
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                xInputNode.val(marker.getPosition().lat());
                yInputNode.val(marker.getPosition().lng());
            });

        })();


        function setValues (data) {
            var latVal = step2Form.find('input[name=lat]').val(),
                lngVal = step2Form.find('input[name=lng]').val();
            $.each (data, function (i, v){
                step2Form.find(' > input[name='+v.name+']').val(v.value);
            });
            console.log(location);
            /*if(location!==undefined){
             xInputNode.val(location.lat());
             yInputNode.val(location.lng());
             initialize();
             }else{
             if(latVal==''){
             var geocoder = new google.maps.Geocoder();
             var address = step2Form.find(' > input[name=street]').val();

             geocoder.geocode( { 'address': address}, function(results, status) {

             if (status == google.maps.GeocoderStatus.OK) {
             var latitude = results[0].geometry.location.lat();
             var longitude = results[0].geometry.location.lng();
             xInputNode.val(latitude);
             yInputNode.val(longitude);
             }
             initialize();
             });
             }else{

             initialize();
             }
             }*/
        }

        modalNode.on ('hide.bs.modal', function (){
            afterHideModal();
        });

        $('.button-add-address').on ('click', function (){
            $scope.show_add_photos = false;
            $scope.cropper.sourceImage = null;
            $scope.cropper.croppedImage  = null;
            angular.element('#fileInput').val(null);

            $scope.$apply();
            showModal();
            step1();

            return false;

        });


        $('.step1_submit').click(function(){
            var data = $('.step-1-form').serializeArray();
            step1Form.find('.validation-error').addClass('hide');
            step1Node.slideUp ('fast');
            step2Node.slideDown ('fast', function(){

                setValues(data);

            });
        });
        $scope.locationId = '';
        $('.step2_submit').click(function(){
            var data = $('.step-1-form').serializeArray();
            step1Form.find('.validation-error').addClass('hide');
            setValues(data);
            var data1 = $('.step-2-form').serialize();
            $('.step2_submit').button('loading');
            /* $.ajax({
             method:'POST',
             url: $rootScope.MAIN_REST_URL+'add_location_data.php',
             data:data,
             success : function (data) {
             $('.step2_submit').button('reset');
             console.log(data);
             var jsonData = JSON.parse(data);
             if (jsonData.success == 'true')
             {
             locationId = data.court_id;
             toastr.success('done');
             var r = confirm('Do you want to add images to the court?');
             if(r==true){
             $scope.show_add_photos = true;
             }
             hideModal();

             }else{
             console.log(data);
             toastr.error('error');
             }
             }
             });*/

            $scope.create_court = CourtsAPI.createCourt(data1, function( data, status){
                console.log(data);
                $('.step2_submit').button('reset');
                if(status==200){
                    if(data.success=='true'){
                        $scope.locationId = data.court_id;
                        toastr.success('done');
                        /*var r = confirm('Do you want to add images to the court?');
                         if(r==true){*/
                        $scope.show_location_info = false;
                        $scope.show_add_photos = true;
                        //}
                        //hideModal();
                    }else{
                        console.log(data);
                        toastr.error('error');
                    }
                }else{
                    toastr.error('something went wrong');
                }
            });
        });
        $scope.image_uploaded = [];
        $scope.upload = function(){
            toastr.info('Please wait while we upload');
            angular.element('#upload_button').button('loading');
            $scope.upload_img = CourtsAPI.uploadImage($scope.cropper.croppedImage, $scope.locationId, function( data, status){
                console.log(data);
                if(data.success=='true'){
                    $scope.upload_ready = false;
                    toastr.success('Uploaded');
                    //$scope.resImageDataURI = '//:0';
                    $scope.cropper.sourceImage = null;
                    $scope.cropper.croppedImage  = null;
                    angular.element('#fileInput').val(null);
                    angular.element('#upload_button').button('reset');
                    angular.element('#add_photo_modal').modal('hide');
                    var upload_obj = {};
                    upload_obj.image = data.image;
                    upload_obj.sr_no = data.sr_no;
                    upload_obj.type = data.type;
                    $scope.image_uploaded.push(upload_obj);
                }else{
                    toastr.error('Some error while uploading');
                }
            });
        };

        $scope.deleteImage = function(sr_no, index){
            var r = confirm('Are you sure?');
            if(r==false){

            }else{
                toastr.info('Please wait while we delete');
                angular.element('.delete_button').button('loading');
                $scope.upload_img = CourtsAPI.deleteImage(sr_no, function( data, status){
                    console.log(data);
                    if(data.success=='true'){
                        toastr.success('Deleted');
                        angular.element('.delete_button').button('reset');
                        $scope.image_uploaded.splice(index, 1);
                    }else{
                        toastr.error('Some error while uploading');
                    }
                });
            }
        };
        $scope.deleteVideo = function(sr_no, index){
            var r = confirm('Are you sure?');
            if(r==false){

            }else{
                toastr.info('Please wait while we delete');
                angular.element('.delete_vid').button('loading');
                $scope.upload_img = CourtsAPI.deleteVideo(sr_no, function( data, status){
                    console.log(data);
                    if(data.success=='true'){
                        toastr.success('Deleted');
                        angular.element('.delete_vid').button('reset');
                        $scope.image_uploaded.splice(index, 1);
                    }else{
                        toastr.error('Some error while uploading');
                    }
                });
            }
        };

        $scope.addVideo = function(){
            angular.element('#addVideoBtn').button('loading');
            $scope.upload_video = CourtsAPI.addVideo($scope.videoUrl, $scope.locationId, function( data, status){
                console.log(data);
                if(data.success=='true'){
                    angular.element('#addVideoBtn').button('reset');
                    toastr.success('Uploaded');
                    //$scope.resImageDataURI = '//:0';
                    angular.element('#addVideoModal').modal('hide');
                    var upload_obj = {};
                    upload_obj.image = data.image;
                    upload_obj.sr_no = data.sr_no;
                    upload_obj.type = data.type;
                    $scope.image_uploaded.push(upload_obj);
                }else{
                    toastr.error('Some error while adding');
                }
            });
        };
        var handleFileSelect=function(evt) {
            angular.element('#add_photo_modal').modal('show');

        };
        angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);
        $scope.add_new_photo = function(){
            angular.element('#add_photo_modal').modal('show');
        };
        $scope.clickFile = function(){
            angular.element('#fileInput').trigger('click');

        };
        $scope.viewGallery = function(image){
            $scope.current_gallery_image = image;
            angular.element('#view_photo_modal').modal('show');
        };
        angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);

        $scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 400;
        $scope.bounds.top = 200;
        $scope.bounds.bottom = 0;
        $scope.changeLocationType = function(){
            if($scope.court_or_field=='court'){
                $scope.court_or_field_type=$scope.court_types[0];
                $scope.locationCategories = $scope.court_types;
            }else if($scope.court_or_field=='field'){
                $scope.court_or_field_type=$scope.field_types[0];
                $scope.locationCategories = $scope.field_types;
            }

        };
        step1();
    };

}]);
