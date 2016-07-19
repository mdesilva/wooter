__Wooter.controller('Courts/EditCourtController', ['Page', '$scope', '$window', '$rootScope', 'Courts', '$http', '$routeParams', 'Notify', '$location', '$filter', 'TimesArray', 'moment', '$mdDialog', '$mdMedia', function (Page, $scope, $window, $rootScope, Courts, $http, $routeParams, Notify, $location, $filter, TimesArray, moment, $mdDialog, $mdMedia) {

    Page.reset();
    Page.title('Courts | Wooter');
    Courts.stylesheets(Page);
    Courts.scripts(Page);
    var curr_slot_duration;
    $scope.LocationData = {};
    $scope.court = {};
    $scope.mondayActive = false;
    $scope.oneAtATime = true;
    $scope.locationId = $routeParams.locationId;
    $scope.minDate = new Date();
    $scope.upload_ready = false;
    $scope.step1Open = true;
    $scope.step2Open = false;
    $scope.step3Open = false;
    $scope.showStep2 = false;
    $scope.showStep3 = false;
    $scope.showSlotBox = false;
    $scope.show_location_info = true;
    $scope.show_add_photos = false;
    $scope.show_avalability = false;
    $scope.current_gallery_image = '';
    $scope.court.court_price = '';
    $scope.slot_day = 'monday';
    $scope.locationCategories = [];
    $scope.eventSources = [];
    $scope.events = [];
    $scope.activeDays = [];
    $scope.removedSlots = [];
    $scope.disableDates = [];
    $scope.times = TimesArray;
    $scope.mondaySlots = [];
    window['mondaySlots'] = [];
    $scope.tuesdaySlots = [];
    window['tuesdaySlots'] = [];
    $scope.wednesdaySlots = [];
    window['wednesdaySlots'] = [];
    $scope.thursdaySlots = [];
    window['thursdaySlots'] = [];
    $scope.fridaySlots = [];
    window['fridaySlots'] = [];
    $scope.saturdaySlots = [];
    window['saturdaySlots'] = [];
    $scope.sundaySlots = [];
    window['sundaySlots'] = [];
    $scope.extendedSchedule = [];
    $scope.court_types = ['basketball', 'tennis'];
    $scope.field_types = ['baseball', 'soccer', 'softball'];
    $scope.featureItems = ['Referees', 'All-Star Game', 'Stat Tracking', 'Contests', 'Commentators/Hype Man/DJ', 'Social Gatherings', 'Press Attention', 'Modified Rules', 'Scouts or Evaluators', 'Professional/Certified Coaches', 'Film Recording/Analysis', 'Premier venue', 'Jersey\'s', 'PED Testing', 'Equipments', 'Tournaments', 'Prizes', 'Playoffs'];
    $scope.majorHolidayList = [
        {name: 'New Years Day', date: '01-01'},
        {name: 'Martin Luther King Day', date: '01-19'},
        {name: 'Lincoln\'s Birthday', date: '02-12'},
        {name: 'Presidents Day', date: '02-16'},
        {name: 'Mothers Day', date: '05-10'},
        {name: 'Memorial Day', date: '05-25'},
        {name: 'Fathers Day', date: '06-21'},
        {name: 'Independence Day (observed)', date: '07-03'},
        {name: 'Labor Day', date: '09-07'},
        {name: 'Columbus Day', date: '10-12'},
        {name: 'Veterans Day', date: '11-11'},
        {name: 'Thanksgiving', date: '11-26'},
        {name: 'Christmas Day', date: '12-25'}
    ];
    $scope.selectedFeature = [];

    function adjustTimesArray(){
        if($scope.court.slot_duration==1){
            $scope.times = [];
            $window._.find(TimesArray, function(t) {
                if(t.value%1==0){
                    $scope.times.push(t);
                }
            });
        }else{
            $scope.times = TimesArray;
        }
    }
    toastr.info('Getting court data');
    $scope.getData = CourtsAPI.getLocationData($scope.locationId, function(data, status){
        toastr.clear();
        console.log(data);
        $scope.LocationData = data.data;
        var court_features = $scope.LocationData.features;

        court_features = court_features.split(',');
        $scope.selectedFeature = court_features;
        $scope.court_privacy_type = $scope.LocationData.court_privacy_type;
        $scope.court.court_price = parseInt(data.data.price);
        $scope.court.slot_duration = data.data.duration;
        curr_slot_duration = angular.copy($scope.court.slot_duration);
        if($scope.court.court_price!='' && $scope.court.slot_duration!=''){
            $scope.showStep3 = true;
            adjustTimesArray();
        }
        $scope.court.avail_start = data.data.start_date;
        $scope.court.avail_end = data.data.end_date;
        if($scope.court.avail_start!='' && $scope.court.avail_end!=''){
            $scope.showStep2 = true;
            //$scope.step1Open = false;
        }
        $scope.avail_minDate = data.data.start_date;
        $scope.avail_maxDate = data.data.end_date;
        $scope.CourtTimeSlots = data.time_slots;
        $scope.CourtManualTimeSlots = data.manual_slots;
        $scope.court_booking = data.booking;
        var CourtTimeSlots = data.time_slots;
        if(data.data.work_week!=''){
            $scope.work_week = JSON.parse(data.data.work_week);
            $scope.monday_start = $scope.work_week[0].start;
            $scope.tuesday_start = $scope.work_week[1].start;
            $scope.wednesday_start = $scope.work_week[2].start;
            $scope.thursday_start = $scope.work_week[3].start;
            $scope.friday_start = $scope.work_week[4].start;
            $scope.satarday_start = $scope.work_week[5].start;
            $scope.sunday_start = $scope.work_week[6].start;
            $scope.monday_end = $scope.work_week[0].end;
            $scope.tuesday_end = $scope.work_week[1].end;
            $scope.wednesday_end = $scope.work_week[2].end;
            $scope.thursday_end = $scope.work_week[3].end;
            $scope.friday_end = $scope.work_week[4].end;
            $scope.satarday_end = $scope.work_week[5].end;
            $scope.sunday_end = $scope.work_week[6].end;
            $scope.monday_avail = $scope.work_week[0].availability;
            $scope.tuesday_avail = $scope.work_week[1].availability;
            $scope.wednesday_avail = $scope.work_week[2].availability;
            $scope.thursday_avail = $scope.work_week[3].availability;
            $scope.friday_avail = $scope.work_week[4].availability;
            $scope.satarday_avail = $scope.work_week[5].availability;
            $scope.sunday_avail = $scope.work_week[6].availability;
        }
        if($scope.CourtTimeSlots!=''){
            console.log($scope.CourtTimeSlots);
            angular.forEach($scope.CourtTimeSlots, function(value, key) {
                if($scope.CourtTimeSlots[key]!=''){
                    var parseIt = JSON.parse($scope.CourtTimeSlots[key]);
                    var parseIt2 = JSON.parse(CourtTimeSlots[key]);
                    $scope[key+'Slots'] = parseIt;
                    window[key+'Slots'] = parseIt2;
                    // $scope[key+'Active'] = true;
                }
            });
            if($scope.CourtTimeSlots.extended_dates!=''){
                $scope.extendedSchedule = JSON.parse($scope.CourtTimeSlots.extended_dates);
                $scope.extend_schedule = true;
                if($scope.extendedSchedule.length==0){
                    extendTimeDefault($scope.avail_minDate, $scope.avail_maxDate);
                }
            }else{
                extendTimeDefault($scope.avail_minDate, $scope.avail_maxDate);
            }
            addEvents();
        }else{
            extendTimeDefault($scope.avail_minDate, $scope.avail_maxDate);
        }

        changeLocationType1($scope.LocationData.court_or_field);
        $scope.image_uploaded = data.images;
        $scope.manual_offs = data.manual;
        $scope.disabled = function(date, mode) {
            // return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 || $scope.disableDates.indexOf( $filter('date')(date, 'yyyy-MM-dd') ) !== -1 ));
            return ( mode === 'day' && ($scope.disableDates.indexOf( $filter('date')(date, 'yyyy-MM-dd') ) !== -1 ));
        };
        step1();
        initialize();

        $scope.calendarView = 'month';
        $scope.calendarDay = new Date();
    });

    var
    //scheduleEditBox = $('.schedule-edit-box'),
        modalNode = $('#schedule-location-modal'),
        step1Node = modalNode.find('.step-1'),
        step2Node = modalNode.find('.step-2'),
        step1Form = step1Node.find('.step-1-form'),
        step2Form = step2Node.find('.step-2-form'),
        mapNode = modalNode.find('.map')[0],
        xInputNode = step2Form.find('input[name=lat]'),
        yInputNode = step2Form.find('input[name=lng]'),
    // addressesSelectNode = scheduleEditBox.find('select[name=address]'),
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

    var hideModal = function ()
    {
        modalNode.modal('hide');

        afterHideModal();
    };

    var afterHideModal = function ()
    {
        step2Node.hide();
        step1Node.hide();

        //   step1Form[0].reset();
        // step2Form[0].reset();
    };

    var step1 = function () {
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

    function initialize() {
        if(location===undefined){
            //var latitude =  xInputNode.val();
            var latitude =  $scope.LocationData.lat;
            // var longitude = yInputNode.val();
            var longitude = $scope.LocationData.lng;
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

    }

    function setValues (data) {
        var latVal = step2Form.find('input[name=lat]').val(),
            lngVal = step2Form.find('input[name=lng]').val();
        $.each (data, function (i, v){
            step2Form.find(' > input[name='+v.name+']').val(v.value);
        });
        step2Form.find(' > input[name=location_id]').val($scope.LocationData.sr_no);
        console.log(location);
    }

    modalNode.on ('hide.bs.modal', function (){
        afterHideModal();
    });

    $('.button-add-address').on ('click', function (){

        showModal();
        step1();

        return false;

    });

    $('.button-edit-address').on ('click', function (){

        showModal();
        step1();

        return false;

    });

    $('.step1_submit').click(function(){
        var data = $('.step-1-form').serializeArray();
        step1Form.find('.validation-error').addClass('hide');
        //step1Node.slideUp ('fast');
        //step2Node.slideDown ('fast', function(){
        setValues(data);

        //});
    });


    $('.step2_edit').click(function(){
        var data = $('.step-1-form').serializeArray();
        step1Form.find('.validation-error').addClass('hide');
        //step1Node.slideUp ('fast');
        //step2Node.slideDown ('fast', function(){
        setValues(data);
        var data = $('.step-2-form').serialize();
        console.log(data);
        $('.step2_edit').button('loading');
        $.ajax({
            method:'POST',
            url: $rootScope.MAIN_REST_URL+'edit_location_data.php',
            data:data,
            success : function (data) {
                $('.step2_edit').button('reset');
                console.log(data);
                var jsonData = JSON.parse(data);
                if (jsonData.success == 'true')
                {
                    toastr.success('Court updated');
                    $scope.LocationData.court_privacy_type = $scope.court_privacy_type;
                    // modalNode.modal('hide');
                }else{
                    console.log(data);
                    alert('error');
                }
            }
        });
    });

    $scope.image_uploaded = [];
    $scope.upload = function(){
        toastr.info('Please wait while we upload');
        angular.element('#upload_button').button('loading');
        $scope.upload_img = CourtsAPI.uploadImage($scope.cropper.croppedImage, $scope.locationId, function( data, status){
            console.log(data);
            toastr.clear();
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
                $scope.bounds = {};
                $scope.bounds.left = 0;
                $scope.bounds.right = 400;
                $scope.bounds.top = 200;
                $scope.bounds.bottom = 0;
            }else{
                toastr.error('Some error while uploading');
            }
        });
    };

    $scope.deleteImage = function(sr_no, index){
        var r = confirm('Are you sure?');
        if(r==false){
            return;
        }else{
            toastr.info('Please wait while we delete');
            // angular.element('.delete_button').button('loading');
            $scope.upload_img = CourtsAPI.deleteImage(sr_no, function( data, status){
                console.log(data);
                toastr.clear();
                if(data.success=='true'){
                    toastr.success('Deleted');
                    // angular.element('.delete_button').button('reset');
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
            return;
        }else{
            toastr.info('Please wait while we delete');
            angular.element('.delete_vid').button('loading');
            $scope.upload_img = CourtsAPI.deleteVideo(sr_no, function( data, status){
                console.log(data);
                toastr.clear();
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

    $scope.cropper = {};
    $scope.cropper.sourceImage = null;
    $scope.cropper.croppedImage   = null;
    $scope.bounds = {};
    $scope.bounds.left = 0;
    $scope.bounds.right = 1000;
    $scope.bounds.top = 350;
    $scope.bounds.bottom = 0;

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

    $scope.changeLocationType = function(){
        if($scope.court_or_field=='court'){
            $scope.court_or_field_type=$scope.court_types[0];
            $scope.locationCategories = $scope.court_types;
        }else if($scope.court_or_field=='field'){
            $scope.court_or_field_type=$scope.field_types[0];
            $scope.locationCategories = $scope.field_types;
        }

    };
    var changeLocationType1 = function(type){
        if(type=='court'){
            $scope.court_or_field_type=$scope.court_types[0];
            $scope.locationCategories = $scope.court_types;
        }else if(type=='field'){
            $scope.court_or_field_type=$scope.field_types[0];
            $scope.locationCategories = $scope.field_types;
        }
        $scope.court_or_field_type = $scope.LocationData.court_or_field_type;
        $scope.court_or_field = $scope.LocationData.court_or_field;

    };

    $scope.preivewChanges = function(){
        $location.path('courts').search('preview', $scope.locationId);
    };
    var el = document.getElementById('image_list');
    var sortable = new Sortable(el, {


        // dragging ended
        onEnd: function (evt) {
            var tmp = '';
            $('#image_list').find('.image_list').each(function(){
                var num = $(this).attr('data-number');
                tmp = tmp+num+',';
            });
            var images = tmp.substring(0,tmp.length - 1);
            toastr.info('Updating sequence');
            $scope.update_image_seq = CourtsAPI.updateImageSeq(images, function( data, status){
                console.log(data);
                toastr.clear();
                if(data.success=='true'){
                    toastr.success('Image sequence updated');
                }else{
                    toastr.error('Some error while uploading');
                }
            });
        }
    });

    var vid_list = document.getElementById('video_list');
    var sortable1 = new Sortable(vid_list, {
        // dragging ended
        onEnd: function (evt) {
            var tmp = '';
            $('#video_list').find('.video_list').each(function(){
                var num = $(this).attr('data-number');
                tmp = tmp+num+',';
            });
            var videos = tmp.substring(0,tmp.length - 1);
            toastr.info('Updating sequence');
            $scope.update_video_seq = CourtsAPI.updateImageSeq(videos, function( data, status){
                console.log(data);
                toastr.clear();
                if(data.success=='true'){
                    toastr.success('Image sequence updated');
                }else{
                    toastr.error('Some error while uploading');
                }
            });
        }
    });
    $scope.monthArr = [{'month': 'January', 'value': 0}, {'month': 'February', 'value': 1}, {'month': 'March', 'value' : 2}, {'month': 'April', 'value' : 3}, {'month': 'May', 'value' : 4}, {'month': 'June', 'value' : 5}, {'month': 'July', 'value' : 6}, {'month': 'August', 'value' : 7}, {'month': 'September', 'value' : 8}, {'month': 'October', 'value' : 9}, {'month': 'November', 'value' : 10}, {'month': 'December', 'value' : 11}];
    $scope.availability_month = '0';
//  AVAILABILITY   //
    function getDaysInMonth(month, year) {
        // Since no month has fewer than 28 days
        var date = new Date(year, month, 1);
        var days = [];
        console.log('month', month, 'date.getMonth()', date.getMonth())
        while (date.getMonth() === month) {
            days.push(new Date(date));
            date.setDate(date.getDate() + 1);
        }
        return days;
    }

    $scope.selectMonth = function(){
        var getMonthData = getDaysInMonth(parseInt($scope.availability_month), 2015);
        console.log(getMonthData);
    };

    $scope.saveAvailability = function(){
        var start_date = $filter('date')($scope.court.avail_start, "yyyy-MM-dd");
        var end_date = $filter('date')($scope.court.avail_end, "yyyy-MM-dd");
        angular.element('#save_avail').button('loading');
        CourtsAPI.saveAvailability(start_date, end_date, $scope.locationId, function( data, status){
            toastr.clear();
            angular.element('#save_avail').button('reset');
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Updated');
                    $scope.avail_minDate = start_date;
                    $scope.avail_maxDate = end_date;
                    $scope.extendedSchedule = [];
                    extendTimeDefault(start_date, end_date);
                    $scope.events = [];
                    addEvents();
                    if($scope.court.court_price=='' || $scope.court.slot_duration==''){
                        $scope.showStep2 = true;
                        $scope.step1Open = false;
                        $scope.step2Open = true;
                    }
                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    };

    Array.prototype.remove = function(value) {
        var idx = this.indexOf(value);
        if (idx != -1) {
            return this.splice(idx, 1); // The second parameter is the number of elements to remove.
        }
        return false;
    };

    $scope.showSlotsModal = function(day){
        if($scope.activeDays.indexOf(day)===-1){
            $scope.activeDays.push(day);
            $scope[day+'Active'] = true;
        }else{
            $scope.activeDays.remove(day);
            $scope[day+'Active'] = false;
        }

        $scope.showSlotBox = ($scope.activeDays.length > 0)?true:false;

        if($scope.activeDays.length==1){
            $scope.TimeSlots = [];
            if($scope[$scope.activeDays[0]+'Slots'].length===0){
                $scope.TimeSlots.push({
                    start_time: '',
                    end_time: ''
                });
            }
            $scope.TimeSlots =  angular.copy($scope[$scope.activeDays[0]+'Slots']);

        }
        var testing, array;
        angular.forEach($scope.activeDays, function(value,index){
            if(index==0){
                array = $scope[value+'Slots'];
            }else{
                array = testing
            }
            testing = angular.copy($scope.getIntersectionOfArray(array, $scope[value+'Slots'], 'start_time', 'end_time', 'value'));

        });
        $scope.TimeSlots = testing;
        console.log($scope.activeDays);
    };

    $scope.getIntersectionOfArray = function(array1,array2, startTime, endTime, value){
        var array3 = [];
        angular.forEach(array1, function(object1,index){
            angular.forEach(array2, function(object2,index1){
                if(object1[startTime][value]==object2[startTime][value] && object1[endTime][value]==object2[endTime][value]){
                    array3.push(object2)
                }
            })
        });
        return array3;
    };

    $scope.pushNewSlot = function(){
        $scope.TimeSlots.push({
            start_time: '',
            end_time: ''
        });
        /*for(var i=0, j=$scope.activeDays; i<j; j++){

         }*/

    };

    $scope.saveTimeSlot = function(){
        var slotObj = {};
        var slotArray = [];
        /*if($scope[$scope.activeDays[0]+'Slots'].length!==0){
         var slots = JSON.stringify($scope[$scope.activeDays[0]+'Slots']);
         }else{
         var slots = '';
         }*/
        var matched = 0;
        angular.forEach($scope.activeDays, function(value,index1){
            angular.forEach($scope.TimeSlots, function(value3,index3){
                matched = 0;
                angular.forEach($scope[value+'Slots'], function(value2,index2){

                    if(value2['start_time']['value']==value3['start_time']['value'] && value2['end_time']['value']==value3['end_time']['value']){
                        matched = 1;
                    }

                });
                if(matched==0){
                    $scope[value+'Slots'].push(value3);
                }
            });
            slotObj.day = value;
            $scope[value+'Active'] = false;

            var slots = ($scope[value+'Slots'].length==0)?'':$scope[value+'Slots'];

            slotObj.slots = slots;
            slotArray.push(slotObj);
        });

        var slots = JSON.stringify(slotArray);
        console.log(slots);
        var days = $scope.activeDays.join();
        angular.element('#addSlotBtn').button('loading');
        CourtsAPI.updateTimeSlots(days, slots, $scope.locationId, function( data, status){
            angular.element('#addSlotBtn').button('reset');
            console.log(data);
            toastr.clear();
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Updated');
                    $scope.showSlotBox = false;
                    /*for(var i = 0, j=$scope.activeDays.length; i<j; i++){
                     var newSlots = $scope[$scope.activeDays[0]+'Slots'];
                     $scope[$scope.activeDays[i]+'Slots'] = angular.copy(newSlots);
                     $scope[$scope.activeDays[i]+'Active'] = false;
                     }*/
                    if($scope.CourtTimeSlots==''){
                        addCourtTimeSlots();
                    }
                    $scope.activeDays = [];
                    $scope.events = [];
                    addEvents();
                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    };

    function addCourtTimeSlots(){
        $scope.CourtTimeSlots = {};
        $scope.CourtTimeSlots.monday = '';
        $scope.CourtTimeSlots.tuesday = '';
        $scope.CourtTimeSlots.wednesday = '';
        $scope.CourtTimeSlots.thursday = '';
        $scope.CourtTimeSlots.friday = '';
        $scope.CourtTimeSlots.saturday = '';
        $scope.CourtTimeSlots.sunday = '';
    }

    $scope.removeSlot = function(index){
        var r = confirm('Are you sure?');
        if(r==true){
            angular.forEach($scope.activeDays, function(value,index1){
                angular.forEach($scope[value+'Slots'], function(value2,index2){
                    if(value2['start_time']['value']==$scope.TimeSlots[index]['start_time']['value'] && value2['end_time']['value']==$scope.TimeSlots[index]['end_time']['value']){
                        $scope[value+'Slots'].splice(index2, 1);
                    }

                });
            });
            $scope.TimeSlots.splice(index, 1);
            toastr.info('Click save to make changes');
        }
    };

    $scope.pushNewSchedule = function(){
        $scope.extendedSchedule.push({
            start_date: '',
            end_date: ''
        });
        console.log($scope.extendedSchedule);

    };

    $scope.saveExtendedSchedule = function(){
        var newArr = [];
        for(var i=0, j=$scope.extendedSchedule.length; i<j; i++){
            var newObj = {};
            newObj.start_date =  $filter('date')($scope.extendedSchedule[i].start_date, "yyyy-MM-dd");
            newObj.end_date =  $filter('date')($scope.extendedSchedule[i].end_date, "yyyy-MM-dd");
            newArr.push(newObj);
        }
        $scope.extendedSchedule = newArr;
        angular.element('#extendedScheduleBtn').button('loading');
        CourtsAPI.updateExtendedSchedule(JSON.stringify($scope.extendedSchedule), $scope.locationId, function( data, status){
            angular.element('#extendedScheduleBtn').button('reset');
            console.log(data);
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Updated');
                    $scope.events = [];
                    addEvents();
                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    };

    $scope.removeSchedule = function(index){
        var r = confirm('Are you sure?');
        if(r==true){
            $scope.extendedSchedule.splice(index, 1);
            toastr.info('Click save to make changes');
        }
    };

    $scope.saveDurationAndPrice = function(ev){
        if(isNaN($scope.court.court_price)){
            toastr.error('Please fill a valid price');
            return;
        }
        if($scope.court.slot_duration==''){
            toastr.error('Duration is required');
            return;
        }
        var clearSlots = 0;
        if($scope.CourtTimeSlots!=='' && (curr_slot_duration!==$scope.court.slot_duration)){

            // Appending dialog to document.body to cover sidenav in docs app
            var confirm = $mdDialog.confirm()
                .title('Confirm the change.')
                .textContent('Changing your slot duration will clear the time slots you have previously saved for your court. Are you sure you want to change the slot duration?')
                .targetEvent(ev)
                .ok('Confirm')
                .cancel('Cancel');
            $mdDialog.show(confirm).then(function() {
                clearSlots = 1;
                angular.forEach($scope.CourtTimeSlots, function(value, key) {
                    $scope[key+'Slots'] = [];
                    window[key+'Slots'] = [];
                });
                continueSaveDurationAndPrice(clearSlots);
            }, function() {
                return;
            });
        }else{
            continueSaveDurationAndPrice(clearSlots);
        }
    };

    function continueSaveDurationAndPrice(clearSlots){
        toastr.info('Saving price');
        angular.element('#save_price').button('loading');
        CourtsAPI.updateCourtPrice($scope.locationId, $scope.court.court_price, $scope.court.slot_duration, clearSlots, function( data, status){
            toastr.clear();
            angular.element('#save_price').button('reset');
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Price updated');
                    curr_slot_duration = angular.copy($scope.court.slot_duration);
                    if($scope.court.court_price!='' && $scope.court.slot_duration!=''){
                        $scope.step2Open = false;
                        $scope.showStep3 = true;
                        $scope.step3Open = true;
                        adjustTimesArray();
                    }else{
                        $scope.showStep3 = false;
                    }
                    if(clearSlots==1){
                        $scope.CourtTimeSlots = '';
                    }
                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    }

    $scope.manualSave = function(){
        var date = $filter('date')($scope.manual_date, "yyyy-MM-dd");
        toastr.info('Saving');
        CourtsAPI.addManualOff($scope.manual_date, $scope.manual_type, date, $scope.locationId, function( data, status){
            toastr.clear();
            console.log(data);
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Saved');
                    $scope.manual_date = '';
                    var newObj = {};
                    newObj.date = data.date;
                    newObj.newObj = data.fulldate;
                    newObj.sr_no = data.sr_no;
                    newObj.type = data.type;
                    $scope.manual_offs.push(newObj);
                    var dateObj = {};
                    dateObj.date = data.date;
                    dateObj.status = data.type;
                    $scope.events.push(dateObj);
                    $scope.disableDates.push(data.date);

                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    };

    var getDates = function(startDate, endDate, day) {
        var dates = [],
            currentDate = startDate,
            addDays = function(days) {
                var date = new Date(this.valueOf());
                date.setDate(date.getDate() + days);
                return date;
            };
        while (currentDate <= endDate) {
            var filterDate = $filter('date')(currentDate, "yyyy-MM-dd");
            var filterDay = $filter('date')(currentDate, "EEEE");
            if(filterDay==day){
                dates.push(filterDate);
            }
            currentDate = addDays.call(currentDate, 1);
        }
        return dates;
    };

    function addEvents(){
        $scope.manual_dates_pushed = [];
        for(var i=0, j=$scope.CourtManualTimeSlots.length; i<j; i++){
            var manual_slots = JSON.parse($scope.CourtManualTimeSlots[i].time_slots);
            for(var m=0, n=manual_slots.length; m<n; m++){
                var start_time = manual_slots[m].start_time.value;
                var end_time = manual_slots[m].end_time.value
                var extObj = {};
                extObj.title = "Open";
                extObj.type = "success";
                extObj.startsAt = moment($scope.CourtManualTimeSlots[i].date).add(start_time, 'hours').toDate();
                extObj.endsAt = moment($scope.CourtManualTimeSlots[i].date).add(end_time, 'hours').toDate();
                $scope.events.push(extObj);
                $scope.manual_dates_pushed.push($scope.CourtManualTimeSlots[i].date);
            }
        }


        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var days1 = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        for(var i=0, j=$scope.extendedSchedule.length; i<j; i++){
            for(var k=0, l=days.length; k<l; k++){
                var dates = getDates(new Date($scope.extendedSchedule[i].start_date), new Date($scope.extendedSchedule[i].end_date), days[k]);
                angular.forEach(dates, function(value){
                    if($scope.manual_dates_pushed.indexOf(value)===-1){
                        for(var m=0, n=$scope[days1[k]+'Slots'].length; m<n; m++){
                            var start_time = $scope[days1[k]+'Slots'][m].start_time.value;
                            var end_time = $scope[days1[k]+'Slots'][m].end_time.value;
                            var extObj = {};
                            extObj.title = "Open";
                            extObj.type = "success";
                            extObj.startsAt = moment(value).add(start_time, 'hours').toDate();
                            extObj.endsAt = moment(value).add(end_time, 'hours').toDate();
                            $scope.events.push(extObj);
                        }
                    }
                });
            }
        }
        // add holidays
        for(var i=0, j=$scope.majorHolidayList.length; i<j; i++){
            var extObj = {};
            extObj.title = $scope.majorHolidayList[i].name;
            extObj.type = "important";
            extObj.startsAt = moment($scope.majorHolidayList[i].date).toDate();
            extObj.endsAt = moment($scope.majorHolidayList[i].date).toDate();
            extObj.recursOn = 'year',
                $scope.events.push(extObj);
        }
        for(var i=0,j=$scope.court_booking.length; i<j; i++){
            var time_slot = JSON.parse($scope.court_booking[i].time_slot);
            var start_time = time_slot.start.value;
            var end_time = parseFloat(start_time)+parseFloat($scope.court_booking[i].end_time);
            var extObj = {};
            extObj.title = "Booked";
            extObj.type = "warning";
            extObj.startsAt = moment($scope.court_booking[i].date).add(start_time, 'hours').toDate();
            extObj.endsAt = moment($scope.court_booking[i].date).add(end_time, 'hours').toDate();
            $scope.events.push(extObj);
        }
    }
    function extendTimeDefault(minDate, maxDate){
        if($scope.avail_minDate!='' & $scope.avail_maxDate!=''){
            var extObj = {};
            extObj.start_date = minDate;
            extObj.end_date = maxDate;
            $scope.extendedSchedule.push(extObj);
        }
    }
    $scope.displayDate1 = function(date){
        console.log(date);
    };

    $scope.showManualSlotsModal = function(day){
        angular.element('#add_manual_time_slots').modal('show');
        $scope.ManualTimeSlots = [];
        console.log(window[day+'Slots']);
        if($scope.manual_dates_pushed.indexOf($scope.manual_date_selected)!==-1){
            for(var i=0, j=$scope.CourtManualTimeSlots.length; i<j; i++){
                if($scope.CourtManualTimeSlots[i].date==$scope.manual_date_selected){
                    $scope.ManualTimeSlots = JSON.parse($scope.CourtManualTimeSlots[i].time_slots);
                }
            }
        }else{
            var manual = window[day+'Slots'];
            if(manual.length===0){
                manual.push({
                    start_time: '',
                    end_time: ''
                });
            }
            $scope.ManualTimeSlots =  manual;
        }
    };

    $scope.saveManualTimeSlot = function(){
        var slots = JSON.stringify($scope.ManualTimeSlots);
        angular.element('#addManualSlotBtn').button('loading');
        CourtsAPI.updateManualTimeSlots(slots, $scope.locationId, $scope.manual_date_selected, function( data, status){
            angular.element('#addManualSlotBtn').button('reset');
            console.log(data);
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Updated');
                    angular.element('#add_manual_time_slots').modal('hide');
                    var extObj = {};
                    if($scope.manual_dates_pushed.indexOf($scope.manual_date_selected)!==-1){
                        for(var i=0, j=$scope.CourtManualTimeSlots.length; i<j; i++){
                            if($scope.CourtManualTimeSlots[i].date==$scope.manual_date_selected){
                                $scope.CourtManualTimeSlots[i].time_slots = slots;
                            }
                        }
                    }else{
                        extObj.date = $scope.manual_date_selected;
                        extObj.time_slots = slots;
                        $scope.CourtManualTimeSlots.push(extObj);
                    }
                    $scope.events = [];
                    addEvents();
                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });
    };
    $scope.removeManualSlot = function(index){
        var r = confirm('Are you sure?');
        if(r==true){
            $scope.ManualTimeSlots.splice(index, 1);
            //$scope[$scope.slot_day+'Slots'] = $scope.TimeSlots;
            toastr.info('Click save to make changes');
        }
    };
    $scope.pushNewManualSlot = function(){
        //$scope.ManualTimeSlots = [];
        $scope.ManualTimeSlots.push({
            start_time: '',
            end_time: ''
        });
    };


    console.log($scope.selectedFeature);
    $scope.toggle = function (item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) list.splice(idx, 1);
        else list.push(item);
    };
    $scope.exists = function (item, list) {
        return list.indexOf(item) > -1;
    };
    $scope.saveFeatures = function(){
        var features = $scope.selectedFeature.join();
        toastr.info('Saving');
        CourtsAPI.saveFeatures(features, $scope.locationId, function( data, status){
            toastr.clear();
            console.log(data);
            if(status==200){
                if(data.success=='true'){
                    toastr.success('Saved');

                }else{
                    toastr.error('Not able to save');
                }
            }else{
                toastr.error('Something went wrong')
            }
        });

    };


    $rootScope.$on('displayDate', function (event, args) {
        var date = args.date;
        $scope.manual_date_selected = $filter('date')(date, "yyyy-MM-dd");
        var filterDay = $filter('date')(date, "EEEE");
        filterDay = filterDay.toLowerCase();
        $scope.showManualSlotsModal(filterDay);

    });

}]);
