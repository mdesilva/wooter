@include('templates.ui.notify-container')
@yield('header')
<div id="ov"></div>
<div id="afterHeader"></div>
@yield('main')
@yield('footer')

@section('body_scripts')
	@if (detectEnvironment('local'))
		{!! assetic('js', jsonConfig('assets.js')) !!}
		{!! angular(jsonConfig('assets.angular')) !!}
		<script src="{{asset('js/vendors/angular/i18n/angular-locale_en.js')}}"></script>
		{!! assetic('js', jsonConfig('assets.init')) !!}
		{!! loadApp('functions') !!}
		{!! loadApp('constants') !!}
		{!! loadApp('filters') !!}
		{!! loadApp('services') !!}
		{!! loadApp('factories') !!}
		{!! loadApp('app') !!}
		{!! loadApp('directives') !!}
		{!! loadApp('controllers') !!}
		{!! loadApp('routes') !!}
        {!! loadApp('decorators') !!}
	@else
		{!! assetic('js', 'production.app', false) !!}
	@endif
	<script type="text/javascript">$(window).load(function(){$(document).trigger('loaded')});</script>
@show
