<md-bottom-sheet class="md-list md-has-header profileActionSheet" ng-cloak>
	<md-content>
	    <a href="#" class="profile">
			<!-- <span class="img md-whiteframe-z2" cssbg="{{ asset('img/profile.png') }}" centerbg="true"></span> -->
			<span class='img md-whiteframe-dp' centerbg='true' style='overflow: hidden'>
				<img ng-src='@{{ currentUser.picture.thumbnail_path }}' style='height: 200%; border-radius: 50px;'>
			</span>
			<!-- <p>Alex Aleksandrovski</p> -->
			@{{ currentUser.first_name }} @{{ currentUser.last_name }}
		</a>
	</md-content>
	<md-list>
		<md-list-item ng-repeat="(key, val) in profileActions">
			<md-button class="md-list-item-content" href="@{{ val.url }}" >
				<md-icon ng-if="val.icon">@{{val.icon}}</md-icon>
				<span class="md-inline-list-icon-label">@{{ val.text }}</span>
			</md-button>
		</md-list-item>
	</md-list>
</md-bottom-sheet>