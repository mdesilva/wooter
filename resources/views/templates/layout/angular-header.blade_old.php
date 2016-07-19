<div class="header-container page-anim" ui-view="header" id="header" ng-controller="HeaderController">
    <div id="primaryHeader" class="md-whiteframe-2dp">
        <md-toolbar>
            <div class="desktop tablet">
                <div class="left">
                    <div class="content-inner">
                        <span class="brand-c"><a href="/home" class="brand"><img ng-src="@{{asset('img/logo.png')}}" alt="Wooter"></a></span>
<!--                         <span ng-show="searchBar.state" class="autocomplete-container" ng-model="search.params">
                            <md-autocomplete ng-disabled="!searchBar.state" md-no-cache="!searchBar.cache" md-search-text-change="searchBar.Event.change"
                                             md-search-text="search.params.search" md-selected-item-change="searchBar.itemChange(item)"
                                             md-menu-class="headerAutocomplete-ul" class="headerAutocomplete"
                                             md-items="item in searchBar.Event.search(search.params.search)" md-item-text="item.name" md-min-length="0" placeholder="Search">
                                <md-item-template>
                                    <div class="search-item" layout="row">
                                        <div class="search-item-content" flex="70">
                                            <p class="title"><span md-highlight-text="search.params.search" md-highlight-flags="^i">@{{item.name}}</span> - @{{item.type}} - <a ui-sref="results({sport: item.name.toLowerCase()})">view</a></p>
                                        </div>
                                    </div>
                                </md-item-template>
                                <md-not-found>
                                    <div class="search-not-found">
                                        <p>No results for "@{{search.params.search}}"</p>
                                    </div>
                                </md-not-found>
                            </md-autocomplete>
                        </span> -->
                    </div>
                </div>
                <div class="right">
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
                                                <p class="title md-title">@{{notification.title}}</p>
                                                <p class="body md-body-1">@{{notification.text}}</p>
                                            </div>
                                        </md-content>
                                    </md-menu-item>
                                </md-menu-content>
                            </md-menu>
                        </div>

<!--                         <div class="info conversations">
                             <md-menu md-offset="0 72px" md-position-mode="target-right target">
                                <md-button ng-click="showMenu($mdOpenMenu, $event)" aria-label="Open sample menu">
                                    <md-icon>mail_outline</md-icon>
                                    <div class="badge">2</div>
                                </md-button>
                                <md-menu-content class="menu-item-auto" width=2>
                                    <md-menu-item>
                                        <md-content layout-padding="12" class="notif-inner" layout="row">
                                                <div class="image" flex="20">
                                                    <div class="img" cssbg="@{{ asset('img/profile.png') }}" centerbg="true"></div>
                                                </div>
                                                <div class="text" flex="80">
                                                    <p class="title md-title">Notification title</p>
                                                    <p class="body md-body-1">Notification text Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium soluta numquam repellat odio atque nostrum quasi culpa.</p>
                                                </div>
                                            </md-content>
                                        </md-menu-item>
                                </md-menu-content>
                            </md-menu>
                        </div> -->

                        <div class="info profile">
                             <md-menu md-offset="0 72px" md-position-mode="target-right target">
                                <md-button ng-click="showMenu($mdOpenMenu, $event)" aria-label="Open sample menu">
                                    <div class="img" cssbg="@{{ asset('img/profile.png') }}" centerbg="true"></div>
                                </md-button>
                                <md-menu-content class="menu-item-auto" width=2>
                                    <md-menu-item>
                                        <md-content layout-padding="12" class="notif-inner" layout="row">
                                                <div class="image" flex="20">
                                                    <div class="img" cssbg="@{{ asset('img/profile.png') }}" centerbg="true"></div>
                                                </div>
                                                <div class="text" flex="80">
                                                    <p class="title md-title">Notification title</p>
                                                    <p class="body md-body-1">Notification text Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium soluta numquam repellat odio atque nostrum quasi culpa.</p>
                                                </div>
                                            </md-content>
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
                </div>
            </div>
            <div class="mobile">
                <md-button class="md-icon-button" ng-click="showMobileMenu()"><md-icon aria-label="Open menu" >menu</md-icon></md-button>
                <span class="middle-container"><a ui-sref="index" class="brand"><img ng-src="@{{asset('img/logo.png')}}" alt="Wooter"></a></span>
                <md-button class="md-icon-button" ng-click="showProfileActions($event)" aria-label="Open Profile Box" ><div class="img" cssbg="@{{asset('img/profile.png')}}" centerbg="true"></div></md-button>
            </div>
        </md-toolbar>
    </div>
</div>



@include('templates.layout.sideMenu')