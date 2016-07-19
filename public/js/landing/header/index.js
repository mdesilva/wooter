"use strict";
landing
    .controller('MenuDropDwnCtrl', function DropDwnCtrl($mdDialog) {
        var originatorEv;
        this.openMenu = function($mdOpenMenu, ev) {
            originatorEv = ev;
            $mdOpenMenu(ev);
        };
    })

    .controller('sideNavCtrl', function($scope, $mdSidenav) {
        $scope.openLeftMenu = function() { $mdSidenav('left').toggle(); };
    })

    .controller('DropDwn', function($scope) {
        $scope.athletesdropdownlist = [
            { text:'company' },
            { text:'company' }
        ];

        $scope.comissionerdropdownlist = [
            { text:'wooter leagues' },
            { text:'search leagues' },
            { text:'find courts' },
            { text:'app' }
        ];
    });



