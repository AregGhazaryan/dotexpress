@extends('layouts.core')
@section('content')
<div class="content">
    <h1>Search Results</h1>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
@if(is_null($find))
  <h2>Could not find anything for your request</h2>
@else

  @foreach($find as $post)
    <div class="product-card">
      <div class="card">
        <div class="card-head">
    <img class="card-img-top" src="/storage/products/{{$post->image}}" alt="Card image cap">
        </div>
        <div class="card-body">
          <h5 class="card-title"><a href="/product/{{$post->unique_id}}"/>{{$post->name}}</a></h5>
          <p class="card-text">{{$post->price}}$</p>
          <p class="card-text">@if($post->stock==0)<span style="color:red;">Not Available </span>@else Stock : {{$post->stock}}@endif</p>
        </div>
        <div class="card-body text-center">
          <a href="/product/{{$post->unique_id}}" class="btn btn-primary"><i class="fas fa-info-circle mr-2"></i>Details</a>
            @if(Auth::user()) @if(!$post->stock==0)<a href="/add/{{$post->unique_id}}/1" class="btn btn-success"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</a>@endif @endif

        </div>
        @if(@Auth::user()->is_admin)
      <form action="{{ action('PostsController@destroy' , $post->id)}}" onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right" method="POST">
  <a class="btn btn-danger"><i class="fas fa-trash-alt" style="color:white;"></i>  <input type='submit' class='none' name="_method"  value="Delete"></a>
  {{ csrf_field() }}
  </form>
          @endif
      </div>

    </div>
@endforeach
<div class="links">
  {{$find->links()}}
</div>
@endif
</div>
@endsection
