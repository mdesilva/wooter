<div id="landing-container">
    @include('landing.layout.header')

    @yield('Main')

    @include('landing.layout.footer')
</div>

@section('Scripts')
    {!! assetic('js', jsonConfig('assets.landing-js')) !!}
    <!-- javascript for the page -->
    @foreach ($js as $javascript_file)
      <script src="{{$javascript_file}}"></script>
    @endforeach
@show