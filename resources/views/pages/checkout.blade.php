@extends('layouts.core')
@section('content')
<div class="content">
  <div class="jumbotron bg-white rounded shadow">
    @if(count($carts)>0)

    {{-- Checkout for guests --}}
    @guest
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Product Name</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th></th>
        </tr>
      </thead>
      @foreach($carts as $cart)
      @php($pricetotal[]=$cart->price * $cart->quantity)
      <tr>
        <td><a href="{{route('products.show', $cart->unique_id)}}">{{$cart->name}}</a></td>
        <td>{{$cart->price}}$</td>
        <td>{{$cart->quantity}}</td>
        <td class="text-right">
          <form action="{{ route('carts.destroy', $cart->unique_id)}}" class="text-right" method="post">
            @method('DELETE')
            @csrf
            <button class='btn btn-danger' type="submit"><i class="fas  fa-times-circle"></i></button>
          </form>
        </td>
      </tr>
      @endforeach
      <h3><b>Total : {{array_sum($pricetotal)}}$</b></h3>
    </table>

    {{-- Checkout for authenticated users --}}
    @else

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Product Name</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
        </tr>
      </thead>
      @foreach($carts as $item)
      @php($pricetotal[]=$item->product->price * $item->quantity)
      <tr>
        <td><a href="{{route('products.show', $item->product->unique_id)}}">{{$item->product->name}}</a></td>
        <td>{{$item->product->price}}$</td>
        <td>{{$item->quantity}}</td>
        <td class="text-right">
          <form action="{{ route('carts.destroy', $item->id)}}" class="text-right" method="post">
            @method('DELETE')
            @csrf
            <button class='btn btn-danger' type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
      <h3>Total : {{array_sum($pricetotal)}}$</h3>
    </table>

    @endguest

    <div class="text-center mt-2">
      <form method="post" action="{{ route('products.buy')}}">
        <div class="text-left">
          <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St"
              required>
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
          <a class='btn btn-danger float-right' href="{{route('carts.empty')}}"
            onclick="return confirm('Are you sure?')">Empty Cart</a>
        </div>
      </form>
    </div>
    @else
    <h1>Your Shopping Cart Is Empty!</h1>
    @endif
  </div>
</div>
@endsection