<title>@yield('title')</title>

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="__dev" content="{{ detectEnvironment() }}">
	<meta name="__lang" content="{{ getLang() }}">
	<meta name="__deviceInfo" content="{{ json_encode(deviceInfo()) }}">
	<meta name="__locale" content="{{ getTrans(config('translate.default_locale')) }}">
	<meta name="__trans" content="{{ getTrans() }}">
	<meta name="__available_languages" content="{{ json_encode(config('translate.available_trans')) }}">
	@if (detectEnvironment())
		<?php $plugin = new Wooter\Wooter\ngTools\ngViewCleaner() ?>
		<meta name="__view_cache" content="{{{ json_encode($plugin->getFiles()) }}}">
	@else
		<meta name="__view_cache" content="{{{ Storage::get('views/views.cache.json') }}}">
	@endif
@show

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="{{asset('img/favicons/favicon-72x72.png')}}">

@section('css')
	@if (detectEnvironment('local'))
		{!! assetic('css', jsonConfig('assets.css')) !!}
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	@else
		{!! assetic('css', 'production.style', false) !!}
	@endif
@show

@if(isset($es6_support) && $es6_support)
    <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-shim.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-sham.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-shim.min.js"></script> return error undefined:1 Uncaught (in promise) TypeError: object is not a constructor(…)--}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-sham.min.js"></script>
    <script src="//wzrd.in/standalone/es7-shim@latest"></script>
@endif

@section('head_scripts')
	{!! assetic('js', [
		'vendors.modernizr',
		'vendors.jquery',
		'vendors.socketio'
	]) !!}
@show

<base href="/">
