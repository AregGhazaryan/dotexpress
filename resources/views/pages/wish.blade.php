@extends('layouts.core')
@section('content')
  <div class="content container">
    <div class="fav-page table-responsive">

      @if(!empty($products))

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Product Image</th>
          <th scope="col">Product Name</th>
          <th scope="col">Price</th>
          <th scope="col"></th>
        </tr>
      </thead>
@foreach($products as $item)

        <tr>
        <td><a href="product/{{$item->product->id}}"><img src="{{$item->product->PrimaryImage ? asset('storage/product_image/'.$item->product->PrimaryImage->path) : asset('img/default_product.png')}}" style="width:200px;"></a></td>
          <td><a href="product/{{$item->product->id}}">{{$item->product->name}}</a></td>
          <td>{{$item->product->price}}$</td>
          <td class="text-right">
          <form action="{{route('wish.destroy', $item->id)}}" method="POST">
            @csrf 
            @method("DELETE")
          <button class="btn btn-danger" type="submit"><i class="fas fa-times"></i></button>
          </form>
          </td>
        </tr>

    @endforeach
    </table>
  @else
    <h1>Your Wish List Is Empty!</h1>
  @endif
    </div>

  </div>
@endsection
