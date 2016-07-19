<!DOCTYPE html>
<html ng-app="Wooter" @yield('html_attr') ng-controller="DefaultController">
	<head>
		@include('templates.head')
	</head>
	<body md-theme="@{{ dynamicTheme }}" data-page="@yield('page_name')" @yield('body_attr')>
		@if (!detectEnvironment())
			@include('templates.loader')
		@endif
		@include('templates.body')
		<div class="loading-state"><md-progress-circular class="white-loader" md-mode="indeterminate" md-diameter="98"></md-progress-circular></div>
        <script id="script_cleaner">
            (function () { __Wooter = false; document.getElementById('script_cleaner').remove()})()
        </script>
	</body>
</html>
