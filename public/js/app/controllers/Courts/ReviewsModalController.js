    __Wooter.controller('Courts/ReviewsModalController', ['Page', 'Courts', '$scope', '$mdDialog', function(Page, Courts, $scope, $mdDialog){
        
        Courts.stylesheets(Page);
        Courts.scripts(Page);
            
        $scope.reviewModel = {};

        $scope.cancel = function (){
            $mdDialog.hide();
        };

        $scope.send = function (){
            $mdDialog.hide();

            //put function to store review

        };
    }]);


