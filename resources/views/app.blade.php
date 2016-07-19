@extends('templates/layout')

{{-- title page --}}
@section('title', 'Wooter')

@section('body_attr', 'class="APP no-scroll page--loading hide"')

@section('header')
	{{-- header --}}

	@include('templates.layout.angular-preloader')
	@include('templates.layout.angular-header')
@stop

@section('main')
	{{-- main content --}}
	<div class="page-anim" ui-view="main" id="main" ng-cloak=""></div>

@stop

@section('footer')
	{{-- footer --}}
	@include('fake.footer')
@stop
