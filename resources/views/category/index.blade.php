@extends('layouts.core')
@section('content')
<div class="content">
  @if(!count($posts))
  <h1> No Products Are Available Right Now</h1>
  @else

  @auth
  @if(Auth::user()->IsSeller || Auth::user()->IsAdmin)
  <a href="{{route('products.create')}}" class="mb-3 btn btn-primary create"><i class="fas fa-file mr-2"></i>New
    Product</a>
  @endif
  @endauth
  @if(count($posts))
  <form class="form-inline" action="{{route('sort',['category'=>$posts->first()['category_id']])}}">
    <label class="mr-sm-2" for="inlineFormCustomSelect">Sort By</label>
    <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect" name="sort">
      <option selected value="0">Name ASC</option>
      <option value="1">Name DSC</option>
      <option value="2">Price to lowest</option>
      <option value="3">Price to highest</option>
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  @endif


  @foreach($posts as $post)



  <div class="product-card">
    <div class="card">
      <div class="card-head">
        <a href="{{route('products.show', $post->unique_id)}}"><img class="card-img-top"
            src="{{$post->PrimaryImage ? asset('storage/product_image/'.$post->PrimaryImage->path) : asset('img/default_product.png')}}"
            alt="Card image cap"></a>
      </div>
      <div class="card-body">
        <h5 class="card-title"><a href="/product/{{$post->unique_id}}" />{{substr($post->name,0, 25)}}</a></h5>
        <p class="card-text">{{$post->price}}$</p>
        <p class="card-text">
          @if($post->stock==0)<span style="color:red;">Not Available </span>
          @else Stock : {{$post->stock}}@endif</p>
      </div>
      <div class="card-body text-center">
        @if($post->stock)

        <a href="{{route('carts.store', $post->unique_id)}}" class="btn btn-success mr-2"><i class="fas fa-cart-plus mr-2"></i>Add To
          Cart</a>
        @endif
      </div>
      @if(Auth::check() && Auth::user()->IsAdmin)
      <form action="{{ route('products.destroy', $post->id)}}"
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
    {{$posts->links()}}
  </div>
  @endif
</div>
@endsection