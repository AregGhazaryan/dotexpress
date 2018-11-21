@extends('layouts.core')
@section('content')
<div class="content">
<div class="jumbotron">
  <h1>Our Services</h1>
  <p>We are a popular supermarket in Armenia selling variety of products ranging from electronics to everyday products. For every purchase above 100$ you will get 40% off discount on every product.
    We also have a service center where customers can take their broken electronics and get repaired in couple of days. We are open 24/7, you can order anytime from the website too.If you want to order online you need to register.</p>
    @if(!Auth::user())
    <a href="/register" class='btn btn-success'>Register</a>

    <a href="/login" class='btn btn-primary'>Login</a>
  @endif
</div>
</div>
@endsection
