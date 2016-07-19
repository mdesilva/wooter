__Wooter.controller('Courts/DefaultController', ['Page', '$scope', '$mdDialog', 'Courts', function(Page, $scope, $mdDialog, Courts){
        
        Courts.stylesheets(Page);
        Courts.scripts(Page);
    /*
     * Function to get Booking Dates
     */
    function getBookingDates() {
        return [
            {
                val: '02/10/2016',
                text: '2016, Feb 10'
            },
            {
                val: '02/11/2016',
                text: '2016, Feb 11'
            },
            {
                val: '02/12/2016',
                text: '2016, Feb 12'
            },
            {
                val: '02/13/2016',
                text: '2016, Feb 13'
            }

        ]
    }

    /*
     * Function to get Booking Start time
     */
    function getBookingStartTimes() {
        var a = [];
        for (var i = 0; i <= 24; i++){
            var hour = (i < 10)?'0'+i:i;
            a.push({
                val: hour+":00",
                text: hour+":00"
            });
        }
        return a;
    }

    /*
     * Function to get Booking Durations
     */
    function getBookingDurations() {
        var a = [];
        for (var i = 30; i <= 24*60; i+=30){
            var minutes;
            if(parseInt(i/60) == i/60){
                minutes = parseInt(i/60)+((i/60>1)?" hours":" hour");
            } else {
                if(parseInt(i/60) > 0){
                    minutes = parseInt(i/60)+( (parseInt(i/60)>1)?" hours":" hour") + " and 30 minutes";
                } else {
                    minutes = "30 minutes";
                }
            }
            a.push({
                val: i,
                text: minutes
            });
        }
        return a;
    }

    /*
     * Watch Live Action for watch button click
     *
     * @param {object} item : Object with details for item selected
     */
    $scope.watchLiveAction = function(ev, item){


        $mdDialog.show({
            controller: 'DefaultController',
            templateUrl: 'scripts/courts/modal/livestream.html',
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });

    };

    $scope.hide = function(){
        $mdDialog.hide();
    };

    $scope.bookingDates = getBookingDates();
    $scope.bookingStartTimes = getBookingStartTimes();
    $scope.bookingDurations = getBookingDurations();


    // $scope.booking = {};

    $scope.selectHalfHourtBooking = function ($e) {

        $e.target.classList.toggle('is-selected');

        return false;
    };

   /* $scope.features = [
        {
            img: "images/icons/feature-shirt.png",
            text: "Jersey and Shorts"
        },
        {
            img: "images/icons/feature-court.png",
            text: "Game Highlights"
        },
        {
            img: "images/icons/feature-court.png",
            text: "Game Highlights"
        },
        {
            img: "images/icons/feature-tactics.png",
            text: "Advanced Stats"
        },
        {
            img: "images/icons/feature-tactics.png",
            text: "Advanced Stats"
        },
        {
            img: "images/icons/feature-tactics.png",
            text: "Advanced Stats"
        }
    ];*/

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

}]);

