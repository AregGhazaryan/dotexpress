@extends('layouts.core')
@section('content')
<div class="content">
    <div class="product-container">
        <h1>Product Details</h1>
        <div class="card">
            <div class="wrap row">
                <div id="carouselExampleControls" class="carousel slide col" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="card-img-top product-img"
                                src="{{$product->PrimaryImage ? asset('storage/product_image/'.$product->PrimaryImage->path) : asset('img/default_product.png')}}"
                                alt="{{$product->name}}">
                        </div>
                        @foreach($product->SecondaryImages as $image)
                        <div class="carousel-item">
                            <img class="card-img-top product-img" src="{{asset('storage/product_image/'.$image->path)}}"
                                alt="{{$image->path}}">
                        </div>
                        @endforeach
                        @if($product->SecondaryImages)
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        @endif
                    </div>
                </div>
                <ul class="list-group list-group-flush product-list borderless col">
                    <li class="list-group-item borderless pd-list">Name : {{$product->name}}</li>
                    <li class="list-group-item pd-list">Description : {{$product->description}}</li>
                    <li class="list-group-item pd-list">Availability : @if($product->stock=='0' ||
                        empty($product->stock))<span class="text-danger">Out Of Stock</span> @else In Stock
                        {{$product->stock}}@endif</li>
                    <li class="list-group-item pd-list">Price : {{$product->price}}$</li>
                    @if($product->user)
                    <li class="list-group-item pd-list">By User : <a
                            href="/profile/{{$product->user->id}}">{{$product->user->name}}</a></li>
                    @endif
                    @if($product->stock !== '0' || !empty($product->stock) && !Auth::user()->IsSeller)
                    @if(!Auth::check())
                    <li class="list-group-item">Quantity :
                        <form action="{{ route('carts.store', $product->unique_id) }}" method="POST">
                            <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="quantity">
                                        <option selected>0</option>
                                        @for($i=1;$i<=$product->stock;$i++)
                                            <option>{{$i}}</option>
                                            @endfor
                                    </select>
                    </li>
                    <li class="list-group-item last-list">
                        <div class="row">
                            <button type="submit" class="col btn btn-primary"><i class="fas fa-cart-plus mr-2"></i>Add
                                To Cart</button>
                            </form>
                            @endif
                            @auth
                            <a href="/wish/{{$product->unique_id}}"
                                class="btn btn-primary heart mr-2 ml-2 text-center  m-0"><i
                                    class="far fa-heart mr-2"></i>Add To Wish List</a>
                            @if(Auth::user()->IsAdmin || $product->user_id === Auth::user()->id)
                            <form class='col text-center p-0' action="{{ route('products.destroy', $product->id)}}"
                                onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right"
                                method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">Delete</button>
                            </form>
                            @endif
                            @endauth
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection