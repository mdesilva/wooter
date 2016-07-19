<style>
    
.md-scroll-mask{
    display:none!important;
}

.league_legends{
    color: rgba(255,255,255,.8);
    text-decoration: none;
}



.league_legends:hover{
    color: white!important;
    text-decoration: none;
    cursor: pointer;  
}

.avatar_drop:hover{
    background: #ddd;
}

.avatar_link, .avatar_link:hover{
    text-decoration: none!important;
    color:black;
}

</style>

<div class="header-container page-anim" ui-view="header" id="header" ng-controller="HeaderController">
    <div id="primaryHeader" class="md-whiteframe-2dp">
        <md-toolbar ng-init='checkWidth()'>
            <div class="desktop tablet">
                <div class="left">
                    <a href="/" class="" style="float: left;" >
                        <img style="height: 75px; padding-left: 30px;" ng-src="@{{asset('img/landings/logo-v2.png')}}" alt="Wooter">
                    </a>
                    <p style="float: left; padding: 20px 20px;">
                        <a href="/">
                            <img style="height: 15px;width: 120px;" ng-src="@{{asset('img/landings/logo_text.png')}}" alt="Wooter Logo">
                        </a>
                    </p>
                </div>

                <!-- IF USER NOT LOGGED -->
                <div ng-show='authenticated === false' class="right">
                    <style>
                        .signup_button {
                            background: #ff3847;
                            padding: 10px 15px;
                            color: white;
                            border-radius: 5px; 
                            text-decoration: none;}

                        .signin_button{
                            background: transparent;
                            color: white;
                            text-decoration: none;
                        }

                        .signup_button:hover, .signin_button:hover {
                            color: white;  
                            text-decoration: none;
                        }
                    </style>

                    <div class="box pad-left border-left" style='width: 230px;'>
                        <div style='margin-left: 10px;'>
                              <md-button md-no-ink style='border-bottom: none!important;'><a class='signin_button' href="/#/login">SIGN IN</a></md-button>
                              <md-button md-no-ink style='border-bottom: none!important;'><a class='signup_button' href="/#/register">SIGN UP</a></md-button>  
                        </div>
                    </div>
                    <div class="box" ng-repeat="(key, value) in menu.items" style="margin: 0 15px;">
                        <md-menu md-offset="0 72px">
                                <md-button style='border-bottom: none!important;' ng-click="showMenu($mdOpenMenu, $event)" class="mdm" aria-label="@{{ key }}">@{{ key }} <md-icon class="material-icons" aria-label="dropdown">arrow_drop_down</md-icon></md-button>
                            <md-menu-content class="min-width-180 header-dd-menu">
                            <md-menu-item ng-repeat="(k, v) in value"><md-button style='color: (0,0,0,.8);' href="@{{ v.url }}">@{{ v.text }}</md-button></md-menu-item>
                            </md-menu-content>
                        </md-menu>
                    </div>
                </div>

                <!-- IF USER LOGGED IN -->
                <div ng-show='authenticated === true' class="right">
                    <div class="box pad-left border-left">
                        <div class="info notifications">
                             <md-menu md-offset="0 72px" md-position-mode="target-right target">
                                <md-button ng-click="showMenu($mdOpenMenu, $event); clearNotifications()" aria-label="Open sample menu">
                                    <md-icon>notifications_none</md-icon>
                                    <div ng-if="notificationsCounter > 0" class="badge">@{{ notificationsCounter }}</div>
                                </md-button>
                                <md-menu-content class="menu-item-auto max-width-400" width=2>
                                    <md-menu-item ng-repeat="notification in notifications">
                                        <md-content layout-padding="12" class="notif-inner" layout="row">
                                            <div class="image" flex="20">
                                                <div class="img" cssbg="@{{ notification.image.thumbnail_path }}" centerbg="true"></div>
                                            </div>
                                            <div class="text" flex="80">
                                                <p class="title md-title"><!-- @{{notification.title}} --> This is a Notification</p>
                                                <p class="body md-body-1"><!-- @{{notification.text}} --> It's real urgent</p>
                                            </div>
                                        </md-content>
                                    </md-menu-item>
                                </md-menu-content>
                            </md-menu>
                        </div>

                        <div class="info profile">
                             <md-menu md-offset="0 87px" md-position-mode="target-right target">
                                <md-button ng-click="showMenu($mdOpenMenu, $event)" aria-label="Open sample menu">
                                    <!-- <div class="img" cssbg="@{{ asset('img/profile.png') }}" centerbg="true"></div> -->
                                    <div class='img' cssbg="@{{ currentUser.picture_id }}" centerbg='true'></div>
                                </md-button>
                                <md-menu-content class="menu-item-auto" width=2>
                                    <md-menu-item class='avatar_drop'>
                                        <a class='avatar_link' href="/dashboard/leagues">Dashboard</a>
                                    </md-menu-item>
                                    <md-menu-item class='avatar_drop'>
                                        <a class='avatar_link' href="/dashboard/settings">Settings</a>
                                    </md-menu-item>
                                    <md-menu-item class='avatar_drop'>
                                        <a class='avatar_link' href="/logout">Logout</a>
                                    </md-menu-item>
                                </md-menu-content>
                            </md-menu>
                        </div>

                    </div>

                    <div class="box" ng-repeat="(key, value) in menu.items"
                         style="margin: 0 15px;">
                         <md-menu md-offset="0 72px">
                            <md-button ng-click="showMenu($mdOpenMenu, $event)" class="mdm" aria-label="@{{ capitalize(key) }}">@{{ capitalize(key) }} <md-icon class="material-icons" aria-label="dropdown">arrow_drop_down</md-icon></md-button>
                            <md-menu-content class="min-width-180 header-dd-menu">
                                <md-menu-item ng-repeat="(k, v) in value"><md-button href="@{{ v.url }}">@{{ v.text }}</md-button></md-menu-item>
                            </md-menu-content>
                        </md-menu>
                    </div>

                    <div class="box" style="margin: 0 15px;">                         
                        <md-button ng-click="showMenu($mdOpenMenu, $event)" class="mdm" aria-label="Leagues" style='padding: 0px 5px!important; border-bottom: none!important;'>
                            <a class='league_legends' href="/dashboard/leagues">Leagues</a>
                        </md-button>
                    </div>
                </div>
            </div>
            
            <!-- MOBILE HEADER -->
            <div class="mobile">
                <md-button class="md-icon-button" ng-click="showMobileMenu()"><md-icon aria-label="Open menu" >menu</md-icon></md-button>
                <span ng-style='mobileHeader' class="middle-container"><a ui-sref="index" class="brand"><img style='height: 48px;' ng-src="@{{asset('img/landings/logo-v2.png')}}" alt="Wooter"></a></span>
                <!-- <md-button ng-if='authenticated === true && currentUser.picture_id !== null' class="md-icon-button" ng-click="showProfileActions($event)" aria-label="Open Profile Box" ><div class="img" cssbg="@{{asset('img/profile.png')}}" centerbg="true"></div></md-button> -->
                <md-button ng-if='authenticated === true && currentUser.picture_id !== null' class="md-icon-button" ng-click="showProfileActions($event)" aria-label="Open Profile Box" >
                    <div>
                        <img style='height:100%' ng-src='@{{ currentUser.picture.thumbnail_path }}'>
                    </div>
                </md-button>

                <md-button ng-if='authenticated === true && currentUser.picture_id === null' class="md-icon-button" ng-click="showProfileActions($event)" aria-label="Open Profile Box" >
                    <div ng-if='currentUser.first_name === "null"'' class="img" centerbg="true" style='background-image: -webkit-linear-gradient(left, rgb(0,150,136)50%, rgb(0, 121, 110) 50%); text-align: center;'>
                        <p style='color: #fff; font-weight: bolder; line-height: 30px; font-size: 20px;'>
                            @{{ currentUser.first_name | limitTo: 1 }}
                        </p>
                    </div>
                </md-button>
                <!-- <md-button ng-if='authenticated === false' class='md-raised wooter-btn-primary' md-no-ink style='border-bottom: none!important;'><a class='signin_button' href="/#/login">SIGN IN</a></md-button> -->
                <md-button ng-if='authenticated === false' class='signin_button' href='/login'>SIGN IN</md-button>
            </div>
        </md-toolbar>
    </div>
</div>



@include('templates.layout.sideMenu')