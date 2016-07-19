    __Wooter.controller('Courts/ReviewsController', ['Page', 'Courts', '$scope', '$mdDialog', function(Page, Courts, $scope, $mdDialog){

        Courts.stylesheets(Page);
        Courts.scripts(Page);
        /*
         * @param {number} court_id -> Id of court, used to get reviews
         */
        var getReviews = function(court_id){
            //function to get reviews
            var $reviews;

            $reviews = [
                {
                    name: "Alex Aleksandrovski",
                    review: "The league that makes you feel like a professional basketball player on and off the court. With 8.5 foot rims, you will be able to throw alley-oops to your teammates, dunk over people, and score just like the guys currently in NBA.",
                    rating: 3,
                    image: "assets/images/test/profile-image.png"
                },
                {
                    name: "Alban Toci",
                    review: "The league that makes you feel like a professional basketball player on and off the court. With 8.5 foot rims, you will be able to throw alley-oops to your teammates, dunk over people, and score just like the guys currently in NBA.",
                    rating: 5,
                    image: "assets/images/test/profile-image.png"
                }
            ];

            return $reviews;
        };


        $scope.reviews = getReviews();

        $scope.getRatingByReviews = function(){
            var reviews = getReviews();
            var sum = 0;
            var num = 0;

            angular.forEach(reviews, function(value){
                if(value.rating){
                    sum += (Math.abs(value.rating) <= 5)?Math.abs(value.rating):5;
                    num += 1;
                }
            });

            return Math.round(sum/num);
        };

        $scope.getStars = function(s){
            var stars = [];
            s = (s<=5)?s:5;
            for(var i = 1; i <= 5; i++){
                if(s<=i){
                    stars.push({
                        type: "star"
                    });
                } else {
                    stars.push({
                        type: "star_border"
                    });
                }
            }

            return stars;
        };

        $scope.showReviewModal = function(ev) {
            $mdDialog.show({
                controller: 'ReviewsModalController',
                templateUrl: 'scripts/courts/modal/review.html',
                parent: angular.element(document.body),
                targetEvent: ev,
                clickOutsideToClose:true
            });
        };

    }]);
