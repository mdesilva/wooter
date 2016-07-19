__Wooter.controller('Admin/AdminLeagueReviewsController', ['API','$scope','$mdDialog', 'Page' , '$stateParams' , '$window', function (API,$scope, $mdDialog, Page , $stateParams , $window) {
   
   	Page.reset();
	Page.title('Admin League Reviews | Wooter');
	Page.stylesheets([
        '/css/dashboard/players.css'
    ]);

    var $code = $stateParams.code;

    var $adminCode = API.exec('adminCode');
    $scope.adminCode = $adminCode;

    loading();
    $adminCode.get({code: $code}, function(response) {
        if (response.data != true) {
            $window.location.href = '/';
        }else{
            loaded();
            start();
        }
    });

    function start() {
	    /**
         * Get and define API
         */
        var $reviews = API.exec('leagueReviews');
        $scope.reviews = $reviews;

        /**
         * Get List using API Request
         */
        $reviews.getAll(function (data) {
            $scope.reviews = getAllReviews(data);

        });

        function getAllReviews($reviews) {
        	var reviews = [];
            angular.forEach($reviews.data, function (val) {
                var $reviews = {
                    league_id: val.league_id,
                    league_name: val.league_name,
                    reviewer_id: val.reviewer_id,
                    reviewer_name: val.reviewer_name,
                    organization_id: val.organization_id,
                    organization_name: val.organization_name,
                    id: val.id,
                    review: val.review,
                    date: val.created_at,
                };

                reviews.push($reviews);
            });

            return reviews;
        }
    }
	}]);
    