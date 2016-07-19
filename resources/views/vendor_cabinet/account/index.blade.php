@extends('landing.layout.page')

@section('Main')
<div>
<div ng-cloak class='sales_dashboard'>
  <md-content>
    <md-tabs md-dynamic-height md-border-bottom>
      

      <md-tab label="COMPANY">
        <md-content>          
			

          <div class="sales_innards container md-whiteframe-4dp">
            <div class="basics_title">
              <img src="../img/dashboard/info.png" alt="">
              <h1>Basics</h1>
            </div>
            <div class="basics_innards">
              <div layout='row' layout-wrap class='company_details'>
                <div layout='column' flex='30' layout-align='center center' class='company_image'>
                  <img src="" alt="Company_Logo">
                </div>
                <div layout='column' flex='70' layout-align='center center' class='company_info'>
                  <form name="userForm">
                    <md-input-container class='thirdMIC mic'>
                      <label>Company Name</label>
                      <input name="companyName" ng-model="companyName">
                    </md-input-container>

                    <md-input-container class='thirdMIC mic'>
                      <label>First Name</label>
                      <input name="firstName" ng-model="firstName">
                    </md-input-container>

                    <md-input-container class='thirdMIC mic'>
                      <label>Last Name</label>
                      <input name="lastName" ng-model="lastName">
                    </md-input-container>

                    <div class="clear"></div>

                    <md-input-container class='halfMIC mic'>
                      <label>Company Email</label>
                      <input name="comapanyEmail" ng-model="comapanyEmail" ng-pattern="/^.+@.+\..+$/">
                    </md-input-container>

                    <md-input-container class='halfMIC mic'>
                      <label>Website URL</label>
                      <input name="websiteURL" ng-model="websiteURL">
                    </md-input-container>

                    <div class="clear"></div>

                    <md-input-container class='halfMIC mic'>
                      <label>Phone Number</label>
                      <input name="phoneNumber" ng-model="phoneNumber" ng-pattern="/^([0-9]{3}) [0-9]{3}-[0-9]{4}$/">
                    </md-input-container>

                    <md-input-container class='halfMIC mic'>
                      <label>Alt. Phone Number (optional)</label>
                      <input name="altNumber" ng-model="altNumber" ng-pattern="/^([0-9]{3}) [0-9]{3}-[0-9]{4}$/">
                    </md-input-container>
                    
                    <div class="clear"></div>
                  </form>
                </div>
              </div>
            </div>
          
            <div class="hq_title">
              <img src="../img/dashboard/home.png" alt="">
              <h1>Headquarters</h1>            
            </div>
            <div class="hq_innards">
              <div layout='row' class='hq_details'>
                <div layout='column' flex='100' layout-align='center center' class='hq_info'>
                  <form name="userForm">
                    <md-input-container class='halfMIC mic'>
                      <label>Street Address</label>
                      <input name="comapanyEmail" ng-model="streetAddress">
                    </md-input-container>

                    <md-input-container class='halfMIC mic'>
                      <label>Apt. Building Suite (optional)</label>
                      <input name="specificAddress" ng-model="specificAddress">
                    </md-input-container>

                    <div class="clear"></div>

                    <md-input-container class='thirdMIC mic'>
                      <label>City</label>
                      <input name="city" ng-model="city">
                    </md-input-container>

                    <md-input-container class='thirdMIC mic'>
                      <label>State</label>
                      <input name="state" ng-model="state">
                    </md-input-container>

                    <md-input-container class='thirdMIC mic'>
                      <label>Zip</label>
                      <input name="zip" ng-model="zip">
                    </md-input-container>

                    <div class="clear"></div>
                  </form>
                </div>
              </div>
            </div>

            <div class="about_title">
              <img src="../img/dashboard/books.png" alt="">
              <h1>About Company</h1>            
            </div>
            <div class="about_innards">
              <div layout='row' class='about_details'>
                <div layout='column' flex='100' layout-align='center center' class='about_info'>
                  <form name="userForm">
                    <md-input-container class='wholeMIC mic'>
                      <label>Describe Your Organization</label>
                      <textarea name="bio" ng-model="comments" md-maxlength="500"></textarea>
                    </md-input-container>
                    <div class="clear"></div>
                  </form>
                </div>
              </div>
            </div>

            <div class="social_title">
              <img src="../img/dashboard/social.png" alt="">
              <h1>Social Media URL's</h1>            
            </div>
            <div class="social_innards">
              <div layout='row' class='social_details'>
                <div layout='column' flex='100' layout-align='center center' class='social_info'>
                  <form name="userForm">
                    <md-input-container class='halfMIC mic'>
                      <p>facebook.com/ </p>
                      <input name="urlFacebook" ng-model="urlFacebook">
                    </md-input-container>
                    <md-input-container class='halfMIC mic'>
                      <p>pintrest.com/ </p>
                      <input name="urlPintrest" ng-model="urlPintrest">
                    </md-input-container>
                    <div class="clear"></div>
                    <md-input-container class='halfMIC mic'>
                      <p>twitter.com/ </p>
                      <input name="urlTwitter" ng-model="urlTwitter">
                    </md-input-container>
                    <md-input-container class='halfMIC mic'>
                      <p>plus.Google.com/ </p>
                      <input name="urlGoogle" ng-model="urlGoogle">
                    </md-input-container>
                    <div class="clear"></div>
                    <md-input-container class='halfMIC mic'>
                      <p>instagram.com/ </p>
                      <input name="urlInstagram" ng-model="urlInstagram">
                    </md-input-container>
                    <md-input-container class='halfMIC mic'>
                      <p>vine.co/ </p>
                      <input name="urlVine" ng-model="urlVine">
                    </md-input-container>
                    <div class="clear"></div>
                    <br>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </md-content>
      </md-tab>

      <md-tab label="NOTIFICATIONS">
        <md-content>          
          <div class="sales_innards container md-whiteframe-4dp">

            <div class="mobile_title">
              <h1>Mobile Notifications</h1>
            </div>
            <div class="mobile_innards">
              <div layout='row' layout-wrap class='mobile_details'>
                <div layout='column' flex='30' layout-align='center center' class='mobile_image'>
                  <p class='disable'>Mobile Phone</p>
                  <br>
                  <p>Recieve mobile updates by<br>regular SMS text messages</p>
                </div>
                <div layout='column' flex='70' layout-align='center center' class='mobile_info'>
                  <p>You can add a phone number to your account in the <span style='color:#d24a48'>Company</span> page</p>
                </div>

                <div layout='column' flex='100' layout-align='center center' class='mobile_hr'>
                  <hr>
                </div>

                <div layout='column' flex='30' layout-align='center center' class='mobile_image'>
                  <p class='disable'>Notify Me When:</p>
                  <br>
                  <p>Applies to both text messages<br>and push notifications.</p>
                </div>
                <div layout='column' flex='70' layout-align='center center' class='mobile_info'>
                  <div class="mobile_checking">
                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb1" class="md-primary">
                      I recieve messages on Wooter.
                    </md-checkbox>

                    <div class="clear"></div>   

                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb2" class="md-primary">
                      A player or team joins my league(s).
                    </md-checkbox>

                    <div class="clear"></div>               

                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb3" class="md-primary">
                      Someone leaves a review.
                    </md-checkbox>

                    <div class="clear"></div>                    
                    
                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb4" class="md-primary">
                      Changes are made to my league(s) or company info.
                    </md-checkbox>

                    <div class="clear"></div>                    
                    


                  </div>
                </div>
              </div>
            </div>

            <div class="mobile_title">
              <h1>Email Notifications</h1>
            </div>
            <div class="mobile_innards">
              <div layout='row' layout-wrap class='mobile_details'>
                <div layout='column' flex='30' layout-align='center center' class='mobile_image'>
                  <p class='disable'>I want to recieve:</p>
                  <br>
                  <p>You can disable these at any time.</p>
                </div>
                <div layout='column' flex='70' layout-align='center center' class='mobile_info'>
                  <div class="mobile_checking">
                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb5" class="md-primary">
                      General promotions, updates, news about Wooter.
                    </md-checkbox>

                    <md-checkbox md-no-ink aria-label="Checkbox No Ink" ng-model="data.cb6" class="md-primary">
                      General promotions for partner campaigns and services, and user surveys from Wooter.
                    </md-checkbox>

                    <div class="clear"></div>                    

                  </div>
                </div>
              </div>
            </div>

          </div>

        </md-content>
      </md-tab>

      <md-tab label="ACCOUNT">
        <md-content>          
          <div class="sales_innards container_special md-whiteframe-4dp">
            <div class="pass_title">
              <h1>Change Password</h1>
            </div>
            <div class="pass_innards">
              <div layout='row' layout-wrap class='pass_details'>
                <div layout='column' flex='100' layout-align='center center' class='pass_info'>
                  <form name="userForm">


                    <md-input-container class='wholeMIC mic'>
                      <p>Old Password </p>
                      <input name="changePass" ng-model="changePass">
                    </md-input-container>

                    <md-input-container class='wholeMIC mic'>
                      <p>New Password</p>
                      <input name="changeConfirm" ng-model="changeConfirm">
                    </md-input-container>

                    <md-input-container class='wholeMIC mic'>
                      <p>Confirm Password</p>
                      <input name="changeConfirm" ng-model="changeConfirm">
                    </md-input-container>

                    <p style='margin: 230px 0px 30px;'>
                      <md-button class="md-raised" style='background: #ef5350; color: white;'>Change Password</md-button>
                    </p>


                    <div class="clear"></div>                    

                    

                  </form>
                </div>
              </div>
            </div>     
            <div class="pass_title">
              <h1>Delete Account</h1>
            </div>
            <div class="pass_innards">
              <div layout='row' layout-wrap class='pass_details'>
                <div layout='column' flex='100' layout-align='center center' class='pass_info'>
                  <form name="userForm">
                  
                    <p>
                      <md-button class="md-raised" style='background: #949494; color: white;'>Remove Account</md-button>
                    </p>

                  </form>
                </div>
              </div>
            </div>  
        </md-content>
      </md-tab>
    </md-tabs>
  </md-content>
</div>

</div>

<script>
	
$( document ).ready(function() {
  $('md-tabs-canvas').addClass('container');

	$('.toggle_dropdown').click(function(){
		$( '.player_menu' ).toggleClass('hide');
	});

});

</script>


@stop

