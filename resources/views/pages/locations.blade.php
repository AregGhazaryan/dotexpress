@extends('layouts.core')
@section('content')
<div class="content">

<div class="mapdiv row">
  <div class="col">
    <ul class="list-group mini-list">
      <li class="list-group-item">Service-center : Komitas St. 20/3</li>
      <li class="list-group-item">Phone : 778-45-47-40</li>
      <li class="list-group-item">Email : dot@service.com</li>
      <hr>
      <li class="list-group-item">Branch : Arshakunyants St. 10</li>
      <li class="list-group-item">Phone : 778-45-47-47</li>
      <li class="list-group-item">Email : dot@branch.com</li>
    </ul>
<br>
    <a href="/message" class='btn btn-success'>Contact Our Administrator</a>
  </div>
  <div class="col">
<iframe class='map' src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d24384.89720369551!2d44.51162008878997!3d40.18431751755392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1541705890922" width='100%' height='100%' frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>
</div>
</div>
@endsection
