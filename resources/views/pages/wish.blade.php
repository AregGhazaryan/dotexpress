@extends('layouts.core')
@section('content')
  <div class="content">
    <div class="fav-page">

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
@foreach($products as $items)
    @foreach($items as $item)

        <tr>
<td><img src="/storage/products/{{$item->image}}" style="width:200px;"></td>
          <td><a href="product/{{$item->product}}">{{$item->name}}</a></td>
          <td>{{$item->price}}$</td>


          <td class="text-right"><a class='btn btn-danger' href="/wish/delete/{{$item->unique_id}}"><i class="fas fa-times"></i></a></td>
        </tr>

      @endforeach
    @endforeach
    </table>
  @else
    <h1>Your Wish List Is Empty!</h1>
  @endif
    </div>

  </div>
@endsection
