__Wooter.directive('cssbg', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attr){
			var bg = attr.cssbg;
			var centerbg = (attr.centerbg)?"background-position: center center;":"";

			element[0].setAttribute('style', "background-image:url('"+bg+"');"+centerbg);
			element[0].removeAttribute('cssbg');
		}
	};
});

__Wooter.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
});

__Wooter.directive('stars', function ($compile) {
    return {
        priority: 0,
        template: '<span class="stars"></span>',
        replace: true,
        transclude: true,
        restrict: 'E',
        scope: {
            stars: '=amount',
            full: '=allStars'
        },
        link: function($scope, $Element, $attr) {
            $scope.$watch('stars', function(){
                $Element[0].innerHTML = "";
                var stars = Math.abs($scope.stars);
                var $render = '';
                for(var i = 1; i <= 5; i++){
                    if (i <= stars){
                        $render += '<md-icon>star</md-icon>';
                    } else {
                        if($scope.full){
                            $render += '<md-icon>star_border</md-icon>';
                        }
                    }
                }
                angular.forEach($compile($render)($scope), function(value){
                    $Element[0].innerHTML += value.outerHTML;
                });
            });
        }
    };
});

__Wooter.directive('customOnChange', function() {
  return {
    templateUrl: '',
    restrict: 'A',
    link: function (scope, element, attrs) {
      var onChangeHandler = scope.$eval(attrs.customOnChange);
      element.bind('change', onChangeHandler);
    }
  };
});

__Wooter.directive('wItem', function () {
    return {
        templateUrl: 'scripts/item/witem.html',
        restrict: 'E',
        scope: {
            item: '=ngModel',
            isDetails: '=isDetails'
        }
    };
});

__Wooter.directive('fileread', function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                scope.$apply(function () {
                    scope.fileread = changeEvent.target.files[0];
                    // or all selected files:
                    // scope.fileread = changeEvent.target.files;
                });
            });
        }
    }
});

(function() {
    'use strict';
    /**
     * <w-court ng-model="item" is-details="true" click-action="someActionToCallOnClick" />
     * Directive for item details.
     * @author harsh.r
     */
    __Wooter.directive('wCourt', ['TimesArray', '$window', '$filter', '$rootScope', 'CourtsAPI', 'toastr', 'TimesArrayHour', '$sce', '$mdDialog', function (TimesArray, $window, $filter, $rootScope, CourtsAPI, toastr, TimesArrayHour, $sce, $mdDialog) {
        return {
            templateUrl: 'scripts/courts/wcourt.html',
            restrict: 'E',
            scope: {
                item: '=ngModel',
                workWeek: '=workWeek',
                isDetails: '=',
                clickAction: '='
            },
            link: function($scope) {
                $scope.times = TimesArray;
                $scope.minDate = new Date();
                $scope.cantBook = true;
                $scope.disabled = true;
                $scope.startTimeDisplay = '';
                $scope.endTimeDisplay = '';
                $scope.totalPrice = '';
                $scope.timesSelect = [];
                $scope.selectionStarted = false;
                $scope.firstSelect;
                $scope.isReadonly = true;
                $scope.max = 5;
                $scope.activeCourtIndex;

                $scope.isShowingExtra = function(index){
                    return  $scope.activeCourtIndex === index;
                };
                if($scope.item!==undefined){
                    $scope.rate = Math.ceil(parseInt($scope.item.court_data.total_rating)/20);
                    $scope.rating_size = Math.ceil(parseInt($scope.item.court_data.size_rating)/5);
                    $scope.rating_basket = Math.ceil(parseInt($scope.item.court_data.basket_rating)/5);
                    $scope.rating_surface = Math.ceil(parseInt($scope.item.court_data.court_rating)/5);
                    $scope.rating_ambience = Math.ceil(parseInt($scope.item.court_data.other_rating)/5);
                }
                $scope.getMiles = function(distace){
                    if(distace>1){
                        var km = Math.ceil(parseInt(distace));
                        var final_val = Math.ceil(km * .6214);
                        final_val = final_val+' mi';
                    }else{
                        var m = Math.ceil(distace*100);
                        var final_val = m+' m';
                    }
                    return final_val;
                };
                $scope.showMore = function(sr_no){
                    $('.extraCourtInfo').slideUp('fast');
                    if($('#extraInfo'+sr_no).is(':visible')){
                        $('#extraInfo'+sr_no).slideUp('fast');
                    }else{
                        $('#extraInfo'+sr_no).slideDown('fast');
                    }

                }
                $scope.durationArrayMain = [{value:0.5, name: '30 minutes'}, {value:1, name: '1 hour'}, {value:1.5, name:'1.5 hours'}, {value:2, name:'2 hours'}, {value:2.5, name: '2.5 hours'}, {value:3, name:'3 hours'}, {value:3.5, name:'3.5 hours'}, {value:4, name:'4 hours'}, {value:4.5, name:'4.5 hours'}, {value:5, name:'5 hours'}, {value:5.5, name:'5.5 hours'}, {value:6, name:'6 hours'}, {value:6.5, name:'6.5 hours'}, {value:7, name:'7 hours'}, {value:7.5, name:'7.5 hours'}, {value:8, name:'8 hours'}, {value:8.5, name:'8.5 hours'}, {value:9, name:'9 hours'}, {value: 9.5, name:'9.5 hours'}, {value:10, name:'10 hours'}];
                var durationArrayMain = [{value:0.5, name: '30 minutes'}, {value:1, name: '1 hour'}, {value:1.5, name:'1.5 hours'}, {value:2, name:'2 hours'}, {value:2.5, name: '2.5 hours'}, {value:3, name:'3 hours'}, {value:3.5, name:'3.5 hours'}, {value:4, name:'4 hours'}, {value:4.5, name:'4.5 hours'}, {value:5, name:'5 hours'}, {value:5.5, name:'5.5 hours'}, {value:6, name:'6 hours'}, {value:6.5, name:'6.5 hours'}, {value:7, name:'7 hours'}, {value:7.5, name:'7.5 hours'}, {value:8, name:'8 hours'}, {value:8.5, name:'8.5 hours'}, {value:9, name:'9 hours'}, {value: 9.5, name:'9.5 hours'}, {value:10, name:'10 hours'}];
                var durationArrayHourMain = [{value:1, name: '1 hour'}, {value:2, name:'2 hours'}, {value:3, name:'3 hours'}, {value:4, name:'4 hours'}, {value:5, name:'5 hours'}, {value:6, name:'6 hours'}, {value:7, name:'7 hours'}, {value:8, name:'8 hours'}, {value:9, name:'9 hours'}, {value:10, name:'10 hours'}];
                $scope.searchObj = {
                    //date: new Date()
                };
                function adjustTimesArray(){
                    if($scope.item.court_data.duration==1){
                        $scope.times = TimesArrayHour;
                        $scope.durationArray = [];
                        $window._.find($scope.durationArrayMain, function(t) {
                            if(t.value%1==0){
                                $scope.durationArray.push(t);
                            }
                        });
                    }else{
                        $scope.durationArray = $scope.durationArrayMain;
                        $scope.times = TimesArray;
                    }
                }

                function changeDuration(time){
                    var counter = 0;
                    for(var i=0, j=$scope.time_slots_available.length; i<j; i++){
                        if($scope.time_slots_available[i].value>=time){
                            if($scope.time_slots_available[i].booked==true || $scope.time_slots_available[i].not_available==true){
                                break;
                            }else{
                                counter++;
                            }
                        }
                    }
                    $scope.durationArray = [];
                    for(var i=0; i<counter; i++){
                        if($scope.item.court_data.duration==1){
                            $scope.durationArray.push(durationArrayHourMain[i]);
                        }else{
                            $scope.durationArray.push(durationArrayMain[i]);
                        }
                    }
                    //$scope.searchObj.end = $scope.durationArray[0];
                }

                $scope.$watch('isDetails', function(){
                    if($scope.isDetails==true){

                        $scope.noTimeSlot = false;
                        $scope.cantBook = true;
                        $scope.searchObj = {
                            date: new Date()
                        };
                        $scope.dateSelected();
                        $scope.rate = Math.ceil(parseInt($scope.item.court_data.total_rating)/20);
                        $scope.rating_size = Math.ceil(parseInt($scope.item.court_data.size_rating)/5);
                        $scope.rating_basket = Math.ceil(parseInt($scope.item.court_data.basket_rating)/5);
                        $scope.rating_surface = Math.ceil(parseInt($scope.item.court_data.court_rating)/5);
                        $scope.rating_ambience = Math.ceil(parseInt($scope.item.court_data.other_rating)/5);
                        //new
                        var features = $scope.item.court_data.features;
                        if(features!=''){
                            $scope.courtFeatures = features.split(',');
                        }else{
                            $scope.courtFeatures = '';
                        }
                    }else{
                        //$('.extraCourtInfo').hide();
                        // $scope.item.images = $scope.item.images;
                    }
                });
                $scope.$watch('searchObj.date', function() {
                    $scope.times.forEach(function(t) {
                        t.selected = false;
                    });
                }, true);
                $scope.$watch('searchObj.start', function() {
                    if($scope.searchObj.start!==undefined && $scope.searchObj.start!=='' && $scope.searchObj.end!==undefined && $scope.searchObj.end!==''){
                        $scope.cantBook = false;
                    }
                });
                $scope.$watch('searchObj.end', function() {
                    if($scope.searchObj.start!==undefined && $scope.searchObj.start!=='' && $scope.searchObj.end!==undefined && $scope.searchObj.end!==''){
                        $scope.cantBook = false;
                    }
                });
                $scope.$watch('searchObj.start', function() {
                    if (!$scope.searchObj.start || $scope.booking) { return; }
                    $scope.cantBook = false;

                    if($scope.searchObj.end=='' || $scope.searchObj.end==undefined){
                        $scope.cantBook = false;
                    }else{
                        $scope.time_slots_available.forEach(function(t) {
                            var timeDuration = parseFloat($scope.searchObj.end.value);
                            $scope.totalPrice = timeDuration*parseFloat($scope.item.court_data.price);
                            timeDuration = parseFloat($scope.searchObj.start.value)+timeDuration;
                            if (t.value >= $scope.searchObj.start.value && t.value < timeDuration) {
                                if (!$scope.cantBook && t.booked) { $scope.cantBook = true; }
                                else { t.selected = true; }
                            } else {
                                t.selected = false;
                            }
                        });

                        // Get duration according to available slots..
                        changeDuration($scope.searchObj.start.value);
                        // end

                    }

                }, true);
                $scope.$watch('searchObj.end', function() {
                    if (!$scope.searchObj.end || $scope.booking) { return; }
                    $scope.cantBook = false;
                    $scope.time_slots_available.forEach(function(t) {
                        var timeDuration = parseFloat($scope.searchObj.end.value);
                        $scope.totalPrice = timeDuration*parseFloat($scope.item.court_data.price);
                        timeDuration = parseFloat($scope.searchObj.start.value)+timeDuration;
                        if(timeDuration>$scope.time_slots_available[$scope.time_slots_available.length-1].end){
                            $scope.cantBook = true;
                            return;
                        }
                        if (t.value >= $scope.searchObj.start.value && t.value < timeDuration) {
                            if (!$scope.cantBook && t.booked) { $scope.cantBook = true; }
                            else { t.selected = true; }
                        } else {
                            t.selected = false;
                        }
                    });
                }, true);
                $scope.mouseMoveOnOuter = function(event) {
                    if ($scope.x) {
                        var deltaX = $scope.x - event.clientX;
                        if (deltaX > 0) {
                            $scope.direction = 'left';
                        } else {
                            $scope.direction = 'right';
                        }
                    }
                    $scope.x = event.clientX;
                };
                
                $scope.bookSlot = function(time) {
                    var duration;
                    if (!$scope.booking) { return; }
                    if (time.booked) { $scope.booking = false; return; }
                    if (time.not_available) { $scope.booking = false; return; }
                    var timeArr = time.range.split(' - ');
                    var start = $window._.find($scope.times, function(t) {
                        if(timeArr[0]==t.name){
                            return t.start;
                        }
                    });
                   // $scope.searchObj.start = start;
                    var end = $window._.find($scope.times, function(t) {
                        if(timeArr[1]==t.name){
                            if($scope.searchObj.start==undefined || $scope.selectionStarted==false){
                                duration = t.start-start.start;
                            }else{
                                if($scope.direction==='left'){
                                    changeDuration(start.value);
                                    if($scope.item.court_data.duration==1){
                                        duration = $scope.firstSelect-(t.start-2);
                                    }else{
                                        duration = $scope.firstSelect-(t.start-1);
                                    }
                                }else{
                                    duration = t.start-$scope.searchObj.start.value;
                                }
                            }
                            return t.start;
                        }
                    });

                    end = $window._.find($scope.durationArray, function(t1) {
                        if(duration==t1.value){
                            return t1;
                        }
                    });
                    $scope.totalPrice = duration*parseFloat($scope.item.court_data.price);
                    if($scope.selectionStarted == false){
                        $scope.searchObj.start = start;
                        $scope.searchObj.end = end;
                        time.selected = true;
                        $scope.firstSelect = start.value;
                    }else{
                        if ($scope.direction) {
                            if ($scope.direction === 'left') {

                                if (!time.selected) {
                                    if (!$scope.searchObj.end) {
                                        $scope.searchObj.end = end;
                                    }
                                    $scope.searchObj.start = start;
                                    changeDuration();
                                    $scope.searchObj.end = end;
                                    time.selected = true;
                                } else {
                                    $scope.searchObj.end = end;
                                    time.selected = false;
                                    $scope.time_slots_available[time.index + 1].selected = false;
                                }
                            } else {
                                if (!time.selected) {
                                    if (!$scope.searchObj.start) {
                                        $scope.searchObj.start = start;
                                    }
                                    $scope.searchObj.end = end;
                                    time.selected = true;
                                } else {
                                    $scope.searchObj.start = start;
                                    time.selected = false;
                                    $scope.time_slots_available[time.index - 1].selected = false;
                                }
                            }
                        } else {
                            time.selected = true;
                        }
                    }
                    console.log($scope.searchObj.start);
                    $scope.selectionStarted = true;
                    changeDuration($scope.searchObj.start.value);
                };
                $scope.startBooking = function() {
                    $scope.time_slots_available.forEach(function(t) {
                        t.selected = false;

                    });
                    $scope.booking = true;
                    $scope.selectionStarted = false;
                };
                $scope.makeBooking = function(){
                    $scope.cantBook = true;
                    var dateObj = JSON.stringify($scope.searchObj);
                    var filterDay = $filter('date')($scope.searchObj.date, "yyyy-MM-dd");
                    CourtsAPI.bookCourt(filterDay, dateObj, $scope.item.court_data.sr_no, $scope.searchObj.start.name, $scope.searchObj.end.value,  function( data, status){
                        $scope.cantBook = false;
                        if(status==200){
                            if(data.success=='true'){
                                toastr.success('Court booked');
                                var obj = {};
                                obj.date = filterDay;
                                obj.time_slot = dateObj;
                                obj.start_time = $scope.searchObj.start.name;
                                obj.end_time = $scope.searchObj.end.value;
                                $scope.item.booking.push(obj);
                                $scope.dateSelected();
                            }else{
                                toastr.error('Not able to save');
                            }
                        }else{
                            toastr.error('Something went wrong')
                        }
                    });

                };

                $scope.dateSelected = function(){
                    adjustTimesArray();
                    $scope.timesSelect = [];
                    $scope.totalPrice = '';
                    var filterDay = $filter('date')($scope.searchObj.date, "EEEE");
                    var filterDate = $filter('date')($scope.searchObj.date, "yyyy-MM-dd");
                    var count = 0;
                    filterDay = filterDay.toLowerCase();
                    angular.forEach($scope.item.manual_slots, function(value){
                        if(filterDate==value.date){
                            $scope.item.time_slots[filterDay] = value.time_slots;
                        }
                    });
                    if($scope.item.time_slots!=''){
                        $scope.time_slots_available = [];
                        var time_slots_available = $scope.item.time_slots[filterDay];
                        if(time_slots_available.trim()!=''){
                            time_slots_available = JSON.parse(time_slots_available);
                            if(time_slots_available.length!=0){
                                for(var i=0, j=time_slots_available.length; i<j; i++){
                                    var obj = {};
                                    var booked = false;
                                    var startVal = time_slots_available[i].start_time.value;
                                    var endVal = time_slots_available[i].end_time.value;
                                    // add missing time slots
                                    if(i>0){
                                        if(parseInt(startVal)-time_slots_available[i-1].end_time.value!==0){
                                            angular.forEach($scope.times, function(v){
                                                if(v.value>=time_slots_available[i-1].end_time.value && v.value<startVal){
                                                    v.not_available = true;
                                                    $scope.time_slots_available.push(v);
                                                }
                                            });
                                        }
                                    }
                                    // end add missing time slots
                                    angular.forEach($scope.times, function(value){
                                        var obj = {};
                                        var booked = false;
                                        if(value.value>=startVal && value.value<endVal){
                                            angular.forEach($scope.item.booking, function(value1){
                                                if(filterDate == value1.date){
                                                    var bookParse = JSON.parse(value1.time_slot);
                                                    var bookingDuration = parseFloat(value1.end_time);
                                                    bookingDuration = parseFloat(bookParse.start.value)+bookingDuration;
                                                    if(value.value>=bookParse.start.value && value.value<bookingDuration){
                                                        booked = true;
                                                    }
                                                }
                                            });
                                            var start = $window._.find($scope.times, function(t) {
                                                if(value.start==t.start){
                                                    return t.name;
                                                }
                                            });
                                            var end = $window._.find($scope.times, function(t) {
                                                if(value.end==t.start){
                                                    return t.name;
                                                }
                                            });
                                            obj.range = start.name+' - '+end.name;
                                            obj.start = value.start;
                                            obj.value = value.value;
                                            obj.index = count;
                                            obj.name = value.name;
                                            obj.end = value.end;
                                            obj.booked = booked;
                                            obj.not_available = false;
                                            if($scope.item.court_data.duration==1){
                                                if(obj.value%1==0){
                                                    $scope.time_slots_available.push(obj);
                                                    $scope.timesSelect.push(obj);
                                                }
                                            }else{
                                                $scope.time_slots_available.push(obj);
                                                $scope.timesSelect.push(obj);
                                            }
                                            count++;
                                        }else if(value.value==endVal){
                                            /*var start = $window._.find($scope.times, function(t) {
                                             if(value.start==t.start){
                                             return t.name;
                                             }
                                             });
                                             var end = $window._.find($scope.times, function(t) {
                                             if(value.end==t.start){
                                             return t.name;
                                             }
                                             });
                                             obj.range = start.name+' - '+end.name;
                                             obj.start = value.start;
                                             obj.value = value.value;
                                             obj.index = count;
                                             obj.name = value.name;
                                             obj.end = value.end;
                                             obj.booked = booked;
                                             obj.not_available = false;
                                             $scope.timesSelect.push(obj);*/
                                        }
                                    });
                                }
                                //  Modify time_slots_available array to contain full time with missing time slots marked as booked
                                $scope.time_slots_available_new = [];

                                var start_time_name = $scope.time_slots_available[0].range;
                                start_time_name = start_time_name.split(' - ');
                                $scope.startTimeDisplay = start_time_name[0];
                                var end_time_name = $scope.time_slots_available[$scope.time_slots_available.length-1].range;
                                end_time_name = end_time_name.split(' - ');
                                $scope.endTimeDisplay = end_time_name[1];
                                angular.forEach($scope.time_slots_available, function(value){
                                    angular.forEach($scope.times, function(value1){
                                    });
                                });
                                $scope.noTimeSlot = false;
                            }else{
                                $scope.noTimeSlot = true;
                            }
                        }else{
                            $scope.noTimeSlot = true;
                        }
                    }else{
                        $scope.noTimeSlot = true;
                    }
                };

                $scope.trustSrc = function(src) {
                    return $sce.trustAsResourceUrl(src);
                };
                // new code
                $scope.watchLiveAction = function(ev, item){

                    $mdDialog.show({
                        controller: 'DefaultController',
                        templateUrl: 'scripts/courts/modal/livestream.html',
                        parent: angular.element(document.body),
                        targetEvent: ev,
                        clickOutsideToClose:true
                    });

                };

                $scope.viewImagePopup = function(ev, image){
                    $mdDialog.show({
                        templateUrl: 'scripts/courts/modal/image.html',
                        parent: angular.element(document.body),
                        targetEvent: ev,
                        locals: {
                           image: image
                         },
                        controller: DialogController,
                        clickOutsideToClose:true
                    });

                };
                function DialogController($scope, $mdDialog, image) {
                  $scope.image = image;
                  $scope.hide = function(){
                        $mdDialog.hide();
                    };
                }

        


        // $scope.booking = {};

        $scope.selectHalfHourtBooking = function ($e) {

            $e.target.classList.toggle('is-selected');

            return false;
        };


        $scope.leagues = [
            {
                img: "images/test-img-gallery.png",
                logo: "images/test-img-logo.png",
                text: {
                    league: "8.5  Foot Basketball League",
                    company: "Dream Leagues Elite"
                }
            },
            {
                img: "images/test-img-gallery.png",
                logo: "images/test-img-logo.png",
                text: {
                    league: "8.5  Foot Basketball League",
                    company: "Dream Leagues Elite"
                }
            },
            {
                img: "images/test-img-gallery.png",
                logo: "images/test-img-logo.png",
                text: {
                    league: "8.5  Foot Basketball League",
                    company: "Dream Leagues Elite"
                }
            }
        ];
            }
        };
    }]).directive('disableAnimation', function($animate){
        return {
            restrict: 'A',
            link: function($scope, $element, $attrs){
                $attrs.$observe('disableAnimation', function(value){
                    $animate.enabled(!value, $element);
                });
            }
        };
    });
})();
