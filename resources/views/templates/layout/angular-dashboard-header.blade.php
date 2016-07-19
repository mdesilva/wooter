<div class="page-loading" ui-view="header" id="header" ng-controller="HeaderController">

    <div id="primaryHeader" class="md-whiteframe-2dp blue-theme">

        <md-toolbar class="md-toolbar-tools">

            <md-button class="md-icon-button md-primary" aria-label="menu" ng-click="showMobileMenu()" style="margin-left: 2px">

                <md-icon aria-label="menu" class="material-icons step ng-binding ng-isolate-scope md-24 menu_icon" ng-class="it.size">
                    menu
                </md-icon>

            </md-button>


            <md-list layout="row">

                <md-list-item>

                    <img class="md-avatar league_img" src="/img/landing/header/user_profile.png" alt="">

                </md-list-item>

                <md-list-item class="section_separator">

                    <span>


                    </span>
                </md-list-item>

                <md-list-item>

                    <h3>Your Finances</h3>

                </md-list-item>


            </md-list>

            <span flex></span>

            <img class="logo" src="/img/blue-logo.png" alt="">

            <span flex></span>

            <md-list layout="row">

                <md-list-item>

                    <md-button class="md-icon-button">

                        <md-icon aria-label="arrowdropdown" class="material-icons step ng-binding ng-isolate-scope md-24" ng-class="it.size">
                            notifications_none
                        </md-icon>

                    </md-button>

                </md-list-item>

                <md-list-item>

                    <md-button class="md-icon-button">

                        <md-icon aria-label="arrowdropdown" class="material-icons step ng-binding ng-isolate-scope md-24" ng-class="it.size">
                            mail_outline
                        </md-icon>

                        <span class="badge_count">2</span>
                    </md-button>

                </md-list-item>

                <md-list-item>

                    <img class="md-avatar user_profile_img" src="/img/landing/header/user_profile.png" alt="">

                </md-list-item>

            </md-list>


        </md-toolbar>

    </div>

</div>

<style>

    md-backdrop{
        z-index: 1 !important;
        background-color: transparent !important;
    }

    md-sidenav{
        z-index: 2;
    }

    md-sidenav md-content{
        margin-top: 64px;
    }

    .menu_icon{
        color: #fff !important;
        opacity: 0.7;
    }

    .section_separator{
        padding: 0 12px;
    }

    .section_separator span{
        width: 1px;
        height: 40px;
        background-color:#CECECE;
        opacity: 0.2;
    }

    .league_img{
        margin-right: 0 !important;
    }

    .logo{
        height: 20px;
    }

    .badge_count{
        display: block;
        background: #ef5350;
        position: absolute;
        top: 12px;
        right: 20px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        text-align: center;
        line-height: 22px;
        color: #fff;
        font-size: 12px;
    }

</style>

