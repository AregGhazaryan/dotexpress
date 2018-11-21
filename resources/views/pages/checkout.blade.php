@extends('layouts.core')
@section('content')
<div class="content">
  @if(session('error'))
      <div class="alert alert-danger">
          {{ session('error') }}
      </div>
  @elseif(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
<div class="jumbotron">

  @if(!empty($products))

<table class="table">
  <thead>
    <tr>
      <th scope="col">Product Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
    </tr>
  </thead>

@foreach($products as $item)

@php($pricetotal[]=$item->price)
    <tr>

      <td><a href="product/{{$item->product}}">{{$item->name}}</a></td>
      <td>{{$item->price}}$</td>


      <td>{{$item->quantity}}</td>
      <td class="text-right"><a class='btn btn-danger' href="/checkout/delete/{{$item->product}}">Delete</a></td>
    </tr>

  @endforeach
<h3>Total : {{array_sum($pricetotal)}}$</h3>
</table>
<div class="text-center mt-2">
  <form method="post" action="{{action('PostsController@checkoutbuy')}}">
<div class="text-left">
  <div class="form-group">
      <label for="inputAddress">Address</label>
      <input type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St" required>
    </div>
      <div class="form-group ml-4">
  <input class="form-check-input" type="checkbox" name="check" id="check">
  <label class="form-check-label" for="check">
    High Priority Premium Delivery (Extra Charges May Apply)
  </label>
    </div>
</div>

    <br>
    <div class="mt-2">
      <button class='btn btn-success float-left' type="submit">Buy</button>


      <a class='btn btn-danger float-right' href="/checkout/forget" onclick="return confirm('Are you sure?')">Empty Cart</a>
    </div>
</form>
</div>




@else
  <h1>Your Shopping Cart Is Empty!</h1>
@endif
</div>
</div>
@endsection
