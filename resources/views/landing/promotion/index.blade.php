<!-- this extends the landing layout template -->
@extends('landing.layout.page')
<!-- html for body goes in the main section -->
@section('Main')

  <div id="league-page" ng-controller="league_controller" ngCLoak>
    @include('landing.promotion.layout.header')
    @include('landing.promotion.layout.top_nav')
    <div class="league-content">
      <div class="container">

        <div class="side">
          @include('landing.promotion.layout.side')
        </div>
        <div class="maxh content">

          @include('landing.promotion.layout.about')

          @include('landing.promotion.layout.info')
          <div class="grey-line"></div>
          @include('landing.promotion.layout.features')
          <div class="grey-line"></div>
          @include('landing.promotion.layout.photos')
          <div class="grey-line"></div>
          @include('landing.promotion.layout.videos')
          <div class="grey-line"></div>
          <div class="hide">@include('landing.promotion.layout.pricing')</div>
          @include('landing.promotion.layout.reviews')
        </div>
      </div>
      <div class="container">
        <div class="clearfix">
          @include('landing.promotion.layout.map')
        </div>

      </div>
    </div>
  </div>
  @include('landing.promotion.layout.modals')
  @include('landing.promotion.layout.gallery')
@stop
