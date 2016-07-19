    __Wooter.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', '$authProvider', function($stateProvider, $urlRouterProvider, $locationProvider, $authProvider) {

    /**
     * Satellizer configuration that specifies which API route the JWT should be retrieved from
     * @type {string}
     */
    $authProvider.loginUrl = '/api/authenticate';

    /**
     * For any unmatched url, redirect to laravel route to checking (if no laravel route return 404)
     */
    $urlRouterProvider.otherwise(function(a, params){
        params.$$search._f = false;
        var search = (count(params.$$search) > 0)?"?"+serializeObject(params.$$search):"";
        window.location = params.$$protocol+'://'+cleanSlashes(params.$$host+'/'+params.$$path+search);
    });

    /**
     * Shared function for home route
     * @param url
     * @returns {{url: *, views: ({main}|*)}}
     */
    // var homeRoute = function (url){
    //     return { url: url, views: templater({ "main": { templateUrl: logicTemplate('home/index'), controller: getControllerName('homeController') } }) };
    // };

    var homeRoute = function(url) {
        return {
            url: url, 
            views: templater({
                'main': {
                    templateUrl: logicTemplate('landing/home'),
                    controller: getControllerName('Landing/HomeController')
                }
            })
        };
    };

    $stateProvider
    /*
     ************************************************************************
     * Home routes
     ************************************************************************
     */
        .state('index', homeRoute(''))
        .state('home', homeRoute('/'))
        // .state('home', {
        //     url: '/home',
        //     views: {
        //         'header': { templateUrl: bladeView('fake.header') },
        //         'main': {
        //             templateUrl: logicTemplate('landing/home'),
        //             controller: getControllerName('Static/HomeController')
        //         },
        //         'footer': { template: "<span></span>/" }
        //     }
        //     // views: {
        //     //     "header":{ templateUrl: logicTemplate('auth/layout/header') },
        //     //     "main": {
        //     //         templateUrl: logicTemplate('landing/about/index'),
        //     //         controller: getControllerName('Landing/AboutController'),
        //     //     },
        //     //     "footer": { template: "<span></span>" }
        //     // }
        // })
        /*
         ************************************************************************
         * Players & Team & Leagues routes
         ************************************************************************
         */
        .state('player', {
            url: '/players/:id',
            views: templater('players/player', 'Players/PlayerController')
        })
        .state('team', {
            url: '/teams/:id',
            views: templater('teams/team', 'Teams/TeamController')
        })
        .state('leagues', {
            url: '/leagues/:league_id',
            views: templater('leagues/league', 'Leagues/LeagueController')
        })
        .state('leaguesList', {
            url: '/dashboard/leagues?tab',
            views: templater('leagues/listLeagues', 'Leagues/ListLeaguesController', ['loginRequired'])
        })
        /*
         ************************************************************************
         * Conversation routes
         ************************************************************************
         */
        .state('inboxConversations', {
            url: '/inbox/:container/:mailType',
            views: templater('mailbox/mailbox', 'Mailbox/MailboxController')
        })
        .state('inboxMessages', {
            url: '/inbox/:container/conversations/:id',
            views: templater('mailbox/conversation', 'Mailbox/ConversationsController')
        })
        .state('broadcast', {
            url: '/inbox/:container/broadcasts/:id',
            views: templater('mailbox/broadcast', 'Mailbox/BroadcastsController')
        })
        /*
         ************************************************************************
         * Auth routes
         ************************************************************************
         */
        .state('login', {
            url: '/login',
            views: {
                "header":{ templateUrl: logicTemplate('auth/layout/header') },
                "main": {
                    templateUrl: logicTemplate('auth/login/index'),
                    controller: getControllerName('Auth/LoginController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })
        .state('register', {
            url: '/register',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/register/index'),
                    controller: getControllerName('Auth/RegisterController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('forgot-password', {
            url: '/forgot-password',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/forgot/index'),
                    controller: getControllerName('Auth/ForgotController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('reset-password', {
            url: '/password/reset/:token',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/reset/index'),
                    controller: getControllerName('Auth/ResetController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('verify', {
            url: '/verify-token',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/verify/index'),
                    controller: getControllerName('Auth/VerifyController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })
        .state('verifyToken', {
            url: '/verify-token/:token',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/verify/index'),
                    controller: getControllerName('Auth/VerifyController'),
                    resolve: {
                        skipIfLoggedIn: $middleware('skipIfLoggedIn')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })
        .state('firstSetup', {
            url: '/first-setup',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('auth/setup/index'),
                    controller: getControllerName('Auth/Setup/Organization'),
                    resolve: {
                        loginRequired: $middleware('loginRequired')
                    }
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('logout', pageController('/logout', function($scope){$scope.logout()}))

        .state('notAllowed', {
            url: '/not-allowed',
            views: {
                "header":{templateUrl: logicTemplate('auth/layout/header')},
                "main": {
                    templateUrl: logicTemplate('not-allowed/index')
                },
                "footer": { template: "<span></span>" }
            }
        })

        /*
         ************************************************************************
         * Landing Routes
         ************************************************************************
         */

        .state('about', {
            url: '/about',
            views: {
                // "header":{ templateUrl: logicTemplate('auth/layout/header') },
                'header': {
                    templateUrl: bladeView('fake/header'),
                    controller: function(){}
                },
                "main": {
                    templateUrl: logicTemplate('landing/about'),
                    controller: getControllerName('Landing/AboutController'),
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('test', {
            url: '/test',
            views: {
                "header":{ templateUrl: logicTemplate('auth/layout/header') },
                "main": {
                    templateUrl: logicTemplate('landing/share/videos/index'),
                    controller: getControllerName('Landing/AboutController'),
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('apparel', {
            url: '/apparel',
            views: {
                // "header":{ templateUrl: logicTemplate('auth/layout/header') },
                'header': {
                    templateUrl: bladeView('fake.header')
                },
                "main": {
                    templateUrl: logicTemplate('landing/apparel'),
                    controller: getControllerName('Landing/ApparelController')
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('contact', {
            url: '/contact', 
            views: {
                'header': { templateUrl: bladeView('fake.header')},
                'main': {
                    templateUrl: logicTemplate('landing/contact'),
                    // controller: getControllerName('Landing/ContactController')
                },
                'footer': { template: '<span></span>'}
            }
        })

        .state('referees', {
            url: '/referees',
            views: {
                'header': { templateUrl: bladeView('fake.header')},
                'main': {
                    templateUrl: logicTemplate('landing/referees'),
                    controller: getControllerName('Landing/RefereesController')
                },
                'footer': { template: '<span></span>'}
            }
        })

        .state('packages', {
            url: '/packages', 
            views: {
                'header': { templateUrl: bladeView('fake.header')},
                'main': {
                    templateUrl: logicTemplate('landing/packages'),
                    controller: getControllerName('Landing/PackagesController')
                },
                'footer': {template: '<span></span>'}
            }
        })

        .state('dreamleagues', {
            url: '/dreamleagues',
            views: {
                // "header":{ templateUrl: logicTemplate('auth/layout/header') },
                'header': {
                    templateUrl: bladeView('fake.header')
                },
                "main": {
                    templateUrl: logicTemplate('landing/dreamleagues/index'),
                    controller: getControllerName('Landing/DreamleaguesController'),
                },
                "footer": { template: "<span></span>" }
            }
        }) 

        // .state('homepage', {
        //     url: '/homepage',
        //     views: {
        //         "header":{ templateUrl: logicTemplate('auth/layout/header') },
        //         "main": {
        //             templateUrl: logicTemplate('landing/home/index'),
        //             controller: getControllerName('Landing/HomeController')
        //         },
        //         "footer": { template: "<span></span>" }
        //     }
        // })



        /*
         ************************************************************************
         * Sharing Routes
         ************************************************************************
         */


        .state('shareVideo', {
            url: '/sshare/video/:video_id',
            views: {
                "header":{ templateUrl: logicTemplate('auth/layout/header') },
                "main": {
                    templateUrl: logicTemplate('share/video/index'),
                    controller: getControllerName('Share/VideoController')
                },
                "footer": { template: "<span></span>" }
            }
        })

        .state('sharePhoto', {
            url: '/sshare/photo/:photo_id',
            views: {
                "header":{ templateUrl: logicTemplate('auth/layout/header') },
                "main": {
                    templateUrl: logicTemplate('share/photo/index'),
                    controller: getControllerName('Share/PhotoController')
                },
                "footer": { template: "<span></span>" }
            }
        })

        /*
         ************************************************************************
         * Dashboard routes
         ************************************************************************
         */
        .state('dashboard', {
            url: '/dashboard',
            views: templater('dashboard/index', 'Dashboard/DashboardController', ['loginRequired', 'isOrganization'])
        })

        .state('dashboardSchedule', {
            url: '/dashboard/leagues/:league_id/seasons/:season_id/schedule',
            views: templater('dashboard/schedule', 'Dashboard/ScheduleController', ['loginRequired', 'isOrganization'])
        })

        .state('dashboardPlayers', {
            url: '/dashboard/leagues/:league_id/players',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/players', 'Dashboard/PlayersController', ['loginRequired', 'isOrganization'])
            )
        })

        //Teams tab
        .state('dashboardTeams', {
            url: '/dashboard/leagues/:league_id/teams',

            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/teams', 'Dashboard/TeamsController', ['loginRequired', 'isOrganization'])
            )
        })

        //division sub tab
        .state('dashboardDivisions', {
            url: '/dashboard/leagues/:league_id/divisions',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/divisions', 'Dashboard/DivisionsController', ['loginRequired', 'isOrganization'])
            )
        })


        //details sub tab
        .state('dashboardDetails', {
            url: '/dashboard/leagues/:league_id/details',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/details', 'Dashboard/DetailsController', ['loginRequired', 'isOrganization'])
            )
        })

        //players tab
        .state('dashboardListPlayers', {
            url: '/dashboard/leagues/:league_id/listplayers',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/ListPlayers', 'Dashboard/ListPlayersController', ['loginRequired', 'isOrganization'])
            )
        })

        //photos tab
        .state('dashboardPhotos', {
            url: '/dashboard/leagues/:league_id/photos',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/photos', 'Dashboard/PhotosController', ['loginRequired', 'isOrganization'])
            )
        })

        //albums sub tab
        .state('dashboardAlbums', {
            url: '/dashboard/leagues/:league_id/albums',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/albums', 'Dashboard/AlbumsController', ['loginRequired', 'isOrganization'])
            )
        })

        //videos tab
        .state('dashboardVideos', {
            url: '/dashboard/leagues/:league_id/videos',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/videos', 'Dashboard/VideosController', ['loginRequired', 'isOrganization'])
            )
        })

        //categories sub tab
        .state('dashboardCategories', {
            url: '/dashboard/leagues/:league_id/categories',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/categories', 'Dashboard/CategoriesController', ['loginRequired', 'isOrganization'])
            )
        })

        //account tab
        .state('dashboardSettings', {
            url: '/dashboard/settings',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/account-setting', 'Dashboard/UserAccountController', ['loginRequired'])
            )
        })
        .state('dashboardAccount', {
            url: '/dashboard/leagues/:league_id/account',
            views: angular.extend({
                    header: {
                        templateUrl: bladeView('fake.header'),
                        controller: function(){}
                    }},
                templater('dashboard/account', 'Dashboard/AccountController', ['loginRequired'])
            )
        })
        .state('dashboardAnswers', {
            url: '/dashboard/leagues/:league_id/answers',
            views: templater('dashboard/answers', 'Dashboard/AnswersController')
        })
        .state('dashboardGames', {
            url: '/dashboard/leagues/:league_id/games',
            views: templater('dashboard/games', 'Dashboard/GamesController' /*['loginRequired', 'isOrganization']*/)
        })
        .state('dashboardStats', {
            url: '/dashboard/games/:game_id/stats',
            views: templater('dashboard/stats', 'Dashboard/GameStatsController' /*['loginRequired', 'isOrganization']*/)
        })
        .state('dashboardLeagueEdit', {
            url: '/dashboard/leagues/:league_id/edit?step',
            views: templater('dashboard/league-create-edit', 'Dashboard/League/CreateEditController', ['loginRequired', 'isOrganization'])
        })
        .state('dashboardLeagueCreate', {
            url: '/dashboard/leagues/create?step',
            views: templater('dashboard/league-create-edit', 'Dashboard/League/CreateEditController', ['loginRequired', 'isOrganization'])
        })

        /*
         ************************************************************************
         * Courts routes
         ************************************************************************
         */
        .state('courtList', {
            url: '/courts/courts-list',
            views: templater('courts/courts', 'Courts/CourtsController')
        })
        .state('courtsEdit', {
            url: '/courts/admin-edit/:location_id',
            views: templater('courts/admin-edit-court', 'Courts/EditCourtController')
        })
        .state('courtsCreate', {
            url: '/courts/admin-create',
            views: templater('courts/admin-create-court', 'Courts/CreateCourtController')
        })
        .state('courtsAdmin', {
            url: '/courts/admin',
            views: templater('courts/admin', 'Courts/AdminController')
        })
        /*
         ************************************************************************
         * Search routes
         ************************************************************************
         */
        .state('results', {
            url: '/results?search&location&sport&gender&ages&distance&sort',
            views: templater('results/results', 'Search/SearchController')
        })

        /*
         ************************************************************************
         * Error routes
         ************************************************************************
         */
        .state('404', {
            url: "/error/404?from",
            views: {
                main:{
                    controller: getControllerName('Error/404')
                },
                header: { template: "<span></span>" },
                footer: { template: "<span></span>" }
            }
        })

        .state('409', {
            url: "/error/409",
            views: {
                main:{
                    controller: function($scope){
                        redirect('error/409');
                    }
                }
            }
        })

        /*
         ************************************************************************
         * Admin Panel routes
         ************************************************************************
         */

        .state('admin', {
            url: '/admin/:code',
            views: templater('admin/admin', 'Admin/AdminController' , 'loginRequired')
        })

        .state('adminUserList', {
            url: '/admin/:code/user-list',
            views: templater('admin/userlist', 'Admin/AdminUserController' , 'loginRequired')
        })

        .state('adminApparel', {
            url: '/admin/:code/apparel',
            views: templater('admin/apparel', 'Admin/AdminApparelRequestController' , 'loginRequired')
        })

        .state('adminReviews', {
            url: '/admin/:code/reviews',
            views: templater('admin/reviews', 'Admin/AdminLeagueReviewsController' , 'loginRequired')
        })

        .state('adminContact', {
            url: '/admin/:code/contact',
            views: templater('admin/contactform', 'Admin/AdminContactController' , 'loginRequired')
        })

        .state('adminScheduleDemo', {
            url: '/admin/:code/schedule-demo',
            views: templater('admin/scheduledemo', 'Admin/AdminScheduleDemoRequestController' , 'loginRequired')
        })

        .state('adminPackages', {
            url: '/admin/:code/packages',
            views: templater('admin/package', 'Admin/AdminPackageController' , 'loginRequired')
        })

        .state('adminLeagues', {
            url: '/admin/:code/leagues',
            views: templater('admin/league', 'Admin/AdminLeagueController' , 'loginRequired')
        })

        .state('adminDreamLeagues', {
            url: '/admin/:code/dreamleagues',
            views: templater('admin/dreamleague', 'Admin/AdminDreamLeagueController' , 'loginRequired')
        })

        .state('adminVideoDemo', {
            url: '/admin/:code/videos',
            views: templater('admin/video', 'Admin/AdminVideoDemoRequestController' , 'loginRequired')
        })

        .state('adminStatsDemo', {
            url: '/admin/:code/stats',
            views: templater('admin/stats', 'Admin/AdminStatsDemoRequestController' , 'loginRequired')
        })

        .state('adminRefreeDemo', {
            url: '/admin/:code/referee',
            views: templater('admin/refree', 'Admin/AdminRefreeDemoRequestController' , 'loginRequired')
        });

    /*
     ************************************************************************
     */

    $locationProvider.html5Mode(true);
}]);
