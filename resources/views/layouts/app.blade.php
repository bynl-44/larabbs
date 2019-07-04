<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>@yield('title', 'LaraBBS') - Laravel 进阶教程</title>
  <meta name="description" content="@yield('description', 'LaraBBS 爱好者社区')">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Style -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  
  @yield('styles')
  
</head>
<body>
  <div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

      @include('shared._messages')
      
      @yield('content')

    </div>
    
    @include('layouts._footer')
  </div>

<!-- Optional JavaScript -->
<script src="{{ mix('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>
