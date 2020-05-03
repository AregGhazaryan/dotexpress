<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>

  <title>{{config('app.name')}}</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="shortcut icon" href="{{asset('favicon.png?v=2')}}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  <link rel="stylesheet" href="{{asset('/css/master.css')}}">
  <link rel="stylesheet" href="{{asset('/css/waves.css')}}">
  <script src="{{asset('/js/waves.min.js')}}"></script>
</head>

<body>
  @include('inc.navbar')
  @include('inc.alerts')
  @yield('content')

  <script type="text/javascript">
    Waves.attach('.btn',['waves-button', 'waves-float']);
  Waves.init();
  </script>

  @include('inc.footer')

</body>

</html>