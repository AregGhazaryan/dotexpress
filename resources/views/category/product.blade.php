@extends('layouts.core')
@section('content')
<div class="content">
<div class="product-container">
  @if(session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @elseif(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
  <h1>Product Details</h1>
  <div class="card">
<div class="wrap row">
  <div id="carouselExampleControls" class="carousel slide col" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
        <img class="card-img-top product-img" src="/storage/products/{{$post->image}}" alt="{{$post->name}}">
    </div>
    @if($post->image1)
    <div class="carousel-item">
      <img class="card-img-top product-img" src="/storage/products/{{$post->image1}}" alt="{{$post->name}}">
    </div>
  @else
  @endif
  @if($post->image2)
  <div class="carousel-item">
    <img class="card-img-top product-img" src="/storage/products/{{$post->image2}}" alt="{{$post->name}}">
  </div>
@else
@endif
@if($post->image3)
<div class="carousel-item">
  <img class="card-img-top product-img" src="/storage/products/{{$post->image3}}" alt="{{$post->name}}">
</div>
@else
@endif
@if($post->image1 or $post->image2 or $post->image3)
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
@endif
</div>

</div>
    <ul class="list-group list-group-flush product-list borderless col">
       <li class="list-group-item borderless pd-list">Name : {{$post->name}}</li>
       <li class="list-group-item pd-list">Description : {{$post->description}}</li>
       <li class="list-group-item pd-list">Availability : @if($post->stock=='0' || empty($post->stock))<span class="text-danger">Out Of Stock</span> @else In Stock {{$post->stock}}@endif</li>
       <li class="list-group-item pd-list">Price : {{$post->price}}$</li>
       @if($user)
       <li class="list-group-item pd-list">By User : <a href="/profile/{{@$user->id}}">{{@$user->name}}</a></li>
     @endif
@if($post->stock == '0' || empty($post->stock))
@else
  @if (Auth::check())
    <li class="list-group-item">Quantity :
      <form action="{{ route('add', $post->unique_id) }}" method="GET">
         <div class="form-row align-items-center">
           <div class="col-auto my-1">
             <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="quantity">
               <option selected>0</option>
             @for($i=1;$i<=$post->stock;$i++)
               <option>{{$i}}</option>
             @endfor
             </select>
  @else

  @endif

              </div>
            </div>


    <li class="list-group-item last-list">
      <div class="row">
        @if(Auth::user())
        @if($post->by !== Auth::user()->email)

          <button type="submit" class="col btn btn-primary"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</button>
        </form>

            <a href="/wish/{{$post->unique_id}}" class="btn btn-primary heart mr-2 ml-2 text-center  m-0"><i class="far fa-heart mr-2"></i>Add To Wish List</a>
          @endif
        @endif
        @if(@Auth::user()->is_admin || $post->by === @Auth::user()->email)
          <form class='col text-center p-0' action="{{ action('PostsController@destroy' , $post->id)}}" onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right" method="post">
            <button class="btn btn-danger w-100"><i class="fas fa-trash-alt" style="color:white;"></i>  <input type='submit' class='none' name="_method"  value="Delete"></button>
<input type="hidden" name="_method" value="delete" />
            {{ csrf_field() }}
          </form>
      </div>
@endif
    </li>
  </li>
@endif
     </ul>

</div>

  </div>
</div>


</div>
@endsection
