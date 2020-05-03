@extends('layouts.core')
@section('content')
<div class="content">
  <div class="row profile-content">
    <div class="col-sm-3">
      <h2>Profile Information</h2>
      <ul class="list-group">
        <li class="list-group-item">Name : {{$user->name}}</li>
        <li class="list-group-item">Email : {{$user->email}}</li>
        <li class="list-group-item">Verified : @if($user->email_verified_at) Yes @else No @endif</li>
      </ul>
    </div>

    <div class="col-md">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          @if(Auth::user()->IsSeller || Auth::user()->IsAdmin)
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
            aria-controls="nav-home" aria-selected="true">Product Listing</a>
          @endif

          {{-- Admin Tabs --}}
          @if(Auth::user()->IsAdmin)
          <a class="nav-item nav-link" id="nav-seller-tab" data-toggle="tab" href="#seller" role="tab"
            aria-controls="nav-contact" aria-selected="false">Seller List</a>
          <a class="nav-item nav-link" id="nav-customer-tab" data-toggle="tab" href="#customer" role="tab"
            aria-controls="nav-contact" aria-selected="false">Customer List</a>
          @endif

          {{-- Orders Tab --}}
          @if($orders)
          @if($user->id == Auth::user()->id || Auth::user()->IsAdmin)
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#tab" role="tab"
            aria-controls="nav-profile" aria-selected="false">Order Listing</a>
          @endif
          @endif


        </div>
      </nav>

      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          {{-- Fetch all products (when admin visits his own profile) --}}
          @if(Auth::user()->IsAdmin && Auth::user()->id === $user->id)
          @foreach($products as $product)
          <div class="product-card">

            <div class="card">
              <div class="card-head">
                <img class="card-img-top"
                  src="{{$product->PrimaryImage ? asset('storage/product_image/'.$product->PrimaryImage->path) : asset('img/default_product.png')}}"
                  alt="Card image cap">
              </div>
              <div class="card-body pt-0">
                <h5 class="card-title"><a
                    href="{{route('products.show', $product->unique_id)}}" />{{$product->name}}</a></h5>
                <p class="card-text">{{$product->price}}$</p>
                <p class="card-text">@if($product->stock==0)<span style="color:red;">Not Available </span>@else Stock :
                  {{$product->stock}}@endif</p>
                <p class="card-text">@if($product->is_approved===0)<span style="color:red;">Not Approved </span>@else
                  Approved @endif</p>
              </div>
              <div class="card-body text-center row">
                <a href="{{route('products.edit', $product->unique_id)}}" class="btn btn-success col ml-3"><i
                    class="fas fa-edit mr-2"></i>Edit</a>

                @if(Auth::user()->IsAdmin || $product->user_id == Auth::user()->id)
                <form class='col text-center' action="{{ route('products.destroy', $product->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right" method="POST">
                  <a class="btn btn-danger w-100"><i class="fas fa-trash-alt" style="color:white;"></i> <input
                      type='submit' class='none' name="_method" value="Delete"></a>

                  @csrf
                </form>
                @endif

              </div>
              <div class="card-body text-center row  p-0 m-0">
                @if(!$product->is_approved)
                <a href="/approve/{{$product->unique_id}}" class="btn btn-success col ml-3 m-2"><i
                    class="fas fa-check-square mr-2"></i>Approve</a>
                @endif
              </div>


            </div>

          </div>
          @endforeach
          <div class="links">
            {{$products->links()}}
          </div>

          {{-- Fetch only seller's products (when Admin visits seller's profile or seller looks at his/her's own profile) --}}
          @elseif(Auth::user()->IsAdmin && Auth::user()->id !== $user->id || Auth::user()->IsSeller && Auth::user()->id
          === $user->id)
          @foreach($query as $product)
          <div class="product-card">

            <div class="card">
              <a href="{{route('products.show', $product->unique_id)}}">
              <div class="card-head">
                <img class="card-img-top"
                  src="{{$product->PrimaryImage ? asset('storage/product_image/'.$product->PrimaryImage->path) : asset('img/default_product.png')}}"
                  alt="Card image cap">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{$product->name}}</a></h5>
                <p class="card-text">{{$product->price}}$</p>
                <p class="card-text">@if(!$product->stock)<span style="color:red;">Not Available </span>@else Stock :
                  {{$product->stock}}@endif</p>
                <p class="card-text">@if(!$product->is_approved)<span style="color:red;">Not Approved </span>@else
                  Approved @endif</p>
              </div>
              <div class="card-body text-center row">
                <a href="/posts/{{$product->unique_id}}/edit" class="btn btn-success col ml-3"><i
                    class="fas fa-edit mr-2"></i>Edit</a>

                @if(Auth::user()->IsAdmin || $product->user_id == Auth::user()->id)
                <form class='col text-center' action="{{ route('products.destroy' , $product->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete ?');" class="text-right" method="POST">
                  @method('DELETE')
                  @csrf
                  <button class="btn btn-danger w-100"><i class="fas fa-trash-alt mr-3"
                      style="color:white;"></i>Delete</button>
                </form>
                @endif
              </div>
              @if(Auth::user()->IsAdmin)
              <div class="card-body text-center row  p-0 m-0">
                @if(!$product->is_approved)
                <a href="{{route('products.approve', $product->unique_id)}}" class="btn btn-success col ml-3 m-2"><i
                    class="fas fa-check-square mr-2"></i>Approve</a>
                @endif
              </div>
              @endif
            </div>
          </div>
          @endforeach
          <div class="links">
            {{$products->links()}}
          </div>
          @endif
        </div>

        @if(Auth::user()->IsSeller && $user->id === Auth::user()->id || Auth::user()->IsAdmin)
        <div class="tab-pane fade" id="tab" role="tabpanel" aria-labelledby="nav-profile-tab">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Buyer</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Approved?</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            @foreach($s_orders as $order)
            <tbody>
              <tr>
                <td><a href="{{route('profile', $order->user_id)}}">{{$order->buyer->name}}</a></td>
                <td><a href="{{route('products.show', $order->product_unique_id)}}">{{$order->product->name}}</a></td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->price}}$</td>
                <td>@if($order->is_approved)Approved @else Not Approved @endif</td>
                <td>
                  @if(!$order->is_approved)
                  <form action="{{route('orders.approve', $order->id)}}">
                    <button class="btn btn-success" type="submit">Approve</button>
                  </form>
                  @endif
                </td>
              </tr>
            </tbody>

            @endforeach
          </table>
        </div>
        @endif


        @if(Auth::user()->isCustomer && $user->id === Auth::user()->id || Auth::user()->IsAdmin)

        <div class="tab-pane fade" id="tab" role="tabpanel" aria-labelledby="nav-profile-tab">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Approved?</th>
              </tr>
            </thead>

            @foreach($orders as $order)
            <tbody>
              <tr>
                <td><a href="{{route('products.show', $order->product_unique_id)}}">{{$order->product->name}}</a></td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->price}}$</td>
                <td>@if($order->is_approved)Approved @else Not Approved @endif</td>
              </tr>
            </tbody>

            @endforeach
          </table>
        </div>
        @if($user->IsAdmin)
        <div class="tab-pane fade" id="tab" role="tabpanel" aria-labelledby="nav-profile-tab">
          <table class="table text-center">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">User</th>
                <th scope="col">Address</th>
                <th scope="col">Approved?</th>
                <th scope="col">Action</th>
              </tr>
            </thead>

            @foreach($sellers as $sales)
            <tbody>
              <tr>
                <td><a href="\product/{{$sales->product_id}}">{{$sales->name}}</a></td>
                <td>{{$sales->quantity}}</td>
                <td>{{$sales->price}}$</td>
                <td>{{$sales->user}}</td>
                <td>{{$sales->address}}</td>
                <td>@if($sales->is_approved)Approved @else Not Approved @endif</td>
                <td>@if($sales->is_confirmed)Confirmed @else <a href="/send/{{$sales->order_id}}"
                    class="btn btn-success"><i class="fas fa-envelope mr-2"></i>Send Confirmation Email</a> @endif</td>
              </tr>
            </tbody>

            @endforeach
          </table>
        </div>
        @endif
        @endif

        @if(Auth::user()->IsAdmin)
        @if($orderlist)
        <div class="tab-pane fade" id="tab" role="tabpanel" aria-labelledby="nav-profile-tab">
          <table class="table text-center">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Ordered By</th>
                <th scope="col">Premium Delievery?</th>
                <th scope="col">Approved?</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            @foreach($orderlist as $orders)
            <tbody>
              <tr>
                <td><a href="{{route('products.show', $orders->product->unique_id)}}">{{$orders->product->name}}</a></td>
                <td>{{$orders->quantity}}</td>
                <td>{{$orders->product->price}}$</td>
                <td>{{$orders->user}}</td>
                <td>@if($orders->premium)Yes @else No @endif</td>
                <td>@if($orders->is_approved)Approved @else Not Approved @endif</td>
                <td>@if(Auth::user()->IsAdmin and !$orders->is_approved) <a href="/order/approve/{{$orders->order_id}}"
                    class="btn btn-success col ml-3 m-2"><i class="fas fa-check-square mr-2"></i>Approve</a>@endif</td>
              </tr>
            </tbody>

            @endforeach
          </table>
          @endif
          @endif
        </div>


        @if(Auth::user()->IsAdmin)
        <div class="tab-pane fade" id="seller" role="tabpanel" aria-labelledby="nav-contact-tab">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Seller Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            @foreach($sellers as $user)
            <tbody>
              <tr>
                <td><a href="\profile/{{$user->id}}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                    <td><a href="{{route('profile.delete', $user->id)}}" class="btn btn-danger">Delete</a></td>
              </tr>
            </tbody>

            @endforeach
          </table>


        </div>
        @endif


        @if(Auth::user()->IsAdmin)
        <div class="tab-pane fade" id="customer" role="tabpanel" aria-labelledby="nav-contact-tab">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Customer Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            @foreach($customers as $person)
            <tbody>
              <tr>
                <td><a href="\profile/{{$person->id}}">{{$person->name}}</a></td>
                <td>{{$person->email}}</td>
                @if($person->is_admin)@else<td><a href="\profile/delete/{{$person->id}}"
                    class="btn btn-danger">Delete</a></td>@endif
              </tr>
            </tbody>
            @endforeach
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
</div>

<script>
  var url = window.location.href;
  var trueurl = url.substr(url.length - 4);

if(trueurl === "#tab"){
  $('#nav-tab a[href="#nav-profile"]').tab('show')
}
</script>
@endsection