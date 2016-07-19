@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="__token" content="{{ csrf_token() }}">
    <!-- title -->
    <title>{{ $title }} | Wooter</title>

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Wooter | {{$desc}}">

    <!-- social media tags -->
    <meta name="author"              content="wooter.co">
    <meta name="description"         content="Wooter | {{$desc}}">
    <meta property="og:title"        content="{{ $title }} | Wooter">
    <meta property="og:description"  content="Wooter | {{$desc}}">
    <meta property="og:url"          content="{{$_SERVER['REQUEST_URI']}}">
    <meta property="og:site_name"    content="Wooter | {{$desc}}">
    <meta property="og:type"         content="website">
@show

    <!-- favicon-->
    <link rel="shortcut icon" href="{{asset('img/favicons/favicon-72x72.png')}}">

<!-- imported js and css files -->
@section('Styles')
    {!! assetic('css', jsonConfig('assets.landing-css')) !!}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/vendors/angular/material/angular-material.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing/header/input.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing/footer/input.css')}}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.css">
    
    @foreach ($css as $css_file)
      <link rel="stylesheet" type="text/css" href="{{$css_file}}">
    @endforeach

@show

@section('headJS')
  {!! assetic('js', 'vendors.jquery', true) !!}
  <!-- angular js stuff -->
  <script src="/js/vendors/angular/angular.js" type="text/javascript"></script>
  <script src="/js/vendors/angular/angular-material.js" type="text/javascript"></script>
  <script src="/js/vendors/angular/angular-animate.js" type="text/javascript"></script>
  <script src="/js/vendors/angular/angular-messages.js" type="text/javascript"></script>
  <script src="/js/vendors/angular/angular-mask.js" type="text/javascript"></script>
  <script src="/js/vendors/angular/angular-aria.js" type="text/javascript"></script>

  <script src="/js/landing/header/angular-dropdowns.js"></script>

  <script type="text/javascript">
    var landing = angular.module('landing', ['ngMaterial','ngDropdowns']);
  </script>

  <script src="/js/landing/layout/header.js"></script>
  <script src="/js/landing/layout/script.js"></script>

@show





<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


