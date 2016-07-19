{{--<md-sidenav class="md-sidenav-left sideMenu md-whiteframe-z2" md-component-id="mobileMenu">--}}
    {{--<div ng-controller="HeaderController">--}}
        {{--<md-toolbar class="md-theme-light">--}}
            {{--<span ng-show="searchBar.state" class="autocomplete-container" ng-model="search.params">--}}
                {{--<md-autocomplete ng-disabled="!searchBar.state" md-no-cache="!searchBar.cache" md-search-text-change="searchBar.Event.change"--}}
                                 {{--md-search-text="search.params.search" md-selected-item-change="searchBar.itemChange(item)"--}}
                                 {{--md-menu-class="headerAutocomplete-ul" class="headerAutocomplete"--}}
                                 {{--md-items="item in searchBar.Event.search(search.params.search)" md-item-text="item.name" md-min-length="0" placeholder="Search">--}}
                    {{--<md-item-template>--}}
                        {{--<div class="search-item" layout="row">--}}
                            {{--<div class="image lazy-image" ng-if="item.image" flex="30">--}}
                                {{--<img ng-src="@{{asset(item.image)}}" onload="resizeImage(this)" alt="icon1">--}}
                            {{--</div>--}}
                            {{--<div class="search-item-content" flex="70">--}}
                                {{--<p class="title" md-highlight-text="search.params.search" md-highlight-flags="^i">@{{item.name}}</p>--}}
                                {{--<p class="subtitle">@{{item.company}}</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</md-item-template>--}}
                    {{--<md-not-found>--}}
                        {{--<div class="search-not-found">--}}
                            {{--<p>No results for "@{{search.params.search}}"</p>--}}
                        {{--</div>--}}
                    {{--</md-not-found>--}}
                {{--</md-autocomplete>--}}
            {{--</span>--}}
        {{--</md-toolbar>--}}
        {{--<md-content layout-padding>--}}
            {{--<md-list ng-repeat="(key, value) in menu.items">--}}
                {{--<md-subheader>@{{ capitalize(key) }}</md-subheader>--}}
                {{--<md-list-item ng-repeat="(k, v) in value" href="@{{ v.url }}">@{{ v.text }}</md-list-item>--}}
            {{--</md-list>--}}
            {{--<md-list class="mdt">--}}
                {{--<md-subheader>Links</md-subheader>--}}
                {{--<md-list-item href="#">Blog</md-list-item>--}}
                {{--<md-list-item href="#">Contact</md-list-item>--}}
            {{--</md-list>--}}
        {{--</md-content>--}}
    {{--</div>--}}
{{--</md-sidenav>--}}

<md-sidenav class="md-sidenav-left md-whiteframe-z2" md-component-id="mobileMenu" md-is-locked-open="shouldLockOpen">

    <md-content>

        <md-list>

            <md-list-item href="/dashboard/leagues">

                <md-icon aria-label="dashboard" class="material-icons">dashboard</md-icon>

                <p>Dashboard</p>

            </md-list-item>

            <!-- <md-list-item href="#">

                <md-icon aria-label="featured_play_list" class="material-icons">featured_play_list</md-icon>

                <p>Your Leagues</p>

            </md-list-item>

            <md-list-item href="#">

                <md-icon aria-label="email" class="material-icons">email</md-icon>

                <p>Messages</p>

            </md-list-item>

            <md-list-item href="#">

                <md-icon aria-label="today" class="material-icons">today</md-icon>

                <p>Schedule</p>

            </md-list-item> -->

            <md-divider ></md-divider>

            <md-list-item href="/packages">

                <md-icon aria-label="card_travel" class="material-icons">work</md-icon>

                <p>Packages</p>

            </md-list-item>

            <md-list-item href="/first-setup">

                <md-icon aria-label="settings" class="material-icons">settings</md-icon>

                <p>Settings</p>

            </md-list-item>

            <md-list-item ng-if='authenticated === true' href="/logout">

                <md-icon aria-label="logout" class="material-icons">forward circle</md-icon>

                <p>Logout</p>

            </md-list-item>

            <md-list-item ng-if='authenticated === false' href='/login'>
                <md-icon aria-label='signIn' class='material-icons'>input</md-icon>
                <p>Login</p>
            </md-list-item>
        </md-list>

    </md-content>

</md-sidenav>

