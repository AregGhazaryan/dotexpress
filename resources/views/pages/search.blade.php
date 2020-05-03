@extends('layouts.core')
@section('content')
<div class="content">
  @if(count($find))
  <h1>Search Results</h1>
  @else
  <h2>Could not find anything for your request</h2>
  @endif
  @foreach($find as $post)
  <div class="product-card">
    <div class="card">
      <div class="card-head">
        <img class="card-img-top" src="{{$post->PrimaryImage ? asset('storage/product_image/'.$post->PrimaryImage->path) : asset('img/default_product.png')}}" alt="Card image cap">
      </div>
      <div class="card-body">
        <h5 class="card-title"><a href="{{route('products.show', $post->unique_id)}}" />{{$post->name}}</a></h5>
        <p class="card-text">{{$post->price}}$</p>
        <p class="card-text">@if($post->stock==0)<span style="color:red;">Not Available </span>@else Stock : {{$post->stock}}@endif</p>
      </div>
      <div class="card-body text-center">
        @if($post->stock !== 0)
          <form action="{{ route('carts.store', $post->unique_id) }}" method="POST">
            <button type="submit" class="col btn btn-primary"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</button>
          </form>
        @endif
      </div>
      @if(@Auth::user()->is_admin)
      <form action="{{ action('PostsController@destroy' , $post->id)}}"
        onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right" method="POST">
        <a class="btn btn-danger"><i class="fas fa-trash-alt" style="color:white;"></i> <input type='submit'
            class='none' name="_method" value="Delete"></a>
        {{ csrf_field() }}
      </form>
      @endif
    </div>

  </div>
  @endforeach
  <div class="links">
    {{$find->links()}}
  </div>
</div>
@endsection