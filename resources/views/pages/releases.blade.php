<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
@extends('layouts.core')
@section('content')
<div class="content">
  <div class="card mb-4">
    <div class="card-header">
      <span class="badge badge-success" style="font-size:12pt;">New</span> Version 2.0
    </div>
    <div class="card-body">
      <h5 class="card-title">General Changes</h5>
      <p class="card-text">
        <ul>
          <li>Fixed spaghetti code</li>
          <li>Swaped stupid ->with() chaining with php's compact function</li>
          <li>Created seperate controllers for everything instead of writing into one controller multiple functions</li>
          <li>Disclaimed dummy page added</li>
          <li>Major database structure changes now its much more neat</li>
          <li>Now guests can add items to the cart but in order to buy they have to register which in turn will check if user had any cart items before it will add to database</li>
          <li>Looking back at the old code make me want to quit life</li>
        </ul>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <span class="badge badge-danger" style="font-size:12pt;">Old and terrible</span> Version 1.2
    </div>
    <div class="card-body">
      <h5 class="card-title">General Changes</h5>
      <p class="card-text">
        <ul>
          <li>Enhanced website design</li>
          <li>Created queues for emails</li>
          <li>Contact Page Created</li>
          <li>Terms and Conditions Added</li>
          <li>Privacy Policy Added</li>
          <li>now users that register or contact support will recieve an automated message</li>
          <li>Added website logo</li>
        </ul>
    </div>
  </div>
</div>
@endsection