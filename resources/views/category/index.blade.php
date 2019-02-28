@extends('layouts.core')
@section('content')
<div class="content">
  @if(@$count==0)
    <h1> No Products Are Available Right Now</h1>
  @else
    @if(@Auth::user()->type=="seller" || Auth::user()->is_admin)
          <a href="/create" class="mb-3 btn btn-primary create"><i class="fas fa-file mr-2"></i>New Product</a>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if($count>0)
        <form class="form-inline" action="{{route('sort',['category'=>$posts->first()['category']])}}">
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
      <img class="card-img-top" src="/storage/products/{{$post->image}}" alt="Card image cap">
          </div>
          <div class="card-body">
            <h5 class="card-title"><a href="/product/{{$post->unique_id}}"/>{{str_limit($post->name,25)}}</a></h5>
            <p class="card-text">{{$post->price}}$</p>
            <p class="card-text">@if($post->stock==0)<span style="color:red;">Not Available </span>@else Stock : {{$post->stock}}@endif</p>
          </div>
          <div class="card-body text-center">
            <a href="/product/{{$post->unique_id}}" class="btn btn-primary"><i class="fas fa-info-circle mr-2"></i>Details</a>
              @if(Auth::user()) @if(!$post->stock==0)<a href="/add/{{$post->unique_id}}/1" class="btn btn-success mr-2"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</a>@endif @endif
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
    {{$posts->links()}}
  </div>
  @endif
</div>
@endsection
