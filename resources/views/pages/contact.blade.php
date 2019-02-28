@extends('layouts.core')
@section('content')
  <div class="content container">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <h1>Contact Support</h1>
    <h5>You can contact support with the form below or send an email to support@DotExpress.com</h5>
<form class="mt-5" action="{{ action('PagesController@send')}}" method="post">
            {{csrf_field()}}
  <div class="form-group">
    <label for="email">Email</label>
    <input class='form-control' id="email" type="email" name="email" placeholder="Your email">
    <br>
      <label for="body">Your Message</label>
    <textarea class='form-control contact-body' id="body" name="body" maxlength="700" placeholder="Type your message here"></textarea>
  </div>
  <button class="btn btn-success float-right"> <input type="submit" class="none" name="submit" value="Send"></button>
</form>
  </div>
@endsection
