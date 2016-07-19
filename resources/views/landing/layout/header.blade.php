<style>
    
.md-scroll-mask{
    display:none!important;
}
</style>

<div class="header-container"  ui-view="header" id="header" ng-controller="HeaderControllerStatic">
  <div id="primaryHeader" class="md-whiteframe-2dp">
    <md-toolbar style='height: 64px; background-color: rgb(33,33,33);'>
      <div class="desktop tablet">
        <div class="left">
          <div class="content-inner">
            <p class='open_link' style="margin: 0px;">
              <a href="/" target='_self' style="float: left;" >
                <img style="height: 75px; padding-left: 30px;" src="/img/landings/logo-v2.png" alt="Wooter">
              </a>                          
            </p>
            <p class='open_link' style="float: left; padding: 14px 20px;">
              <a href="/" target='_self'>
                <img style="height: 15px;width: 120px;" src="/img/landings/logo_text.png" alt="Wooter Logo">
              </a>
            </p>
          </div>
        </div>
        <div class="right">
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
            text-decoration: none;}

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
      </div>
      <div class="mobile">
        <md-button class="md-icon-button" ng-click="showMobileMenu()"><md-icon aria-label="Open menu" >menu</md-icon></md-button>
        <span class="middle-container"><a ui-sref="index" class="brand"><img style='height: 48px;' src="/img/landings/logo-v2.png" alt="Wooter"></a></span>
      </div>
    </md-toolbar>
  </div>
</div>

