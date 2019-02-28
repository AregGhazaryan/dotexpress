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

    @guest
    <div class="jumbotron text-center index-jumbo">
      <h1 class="display-4">Welcome To DotExpress</h1>
      <p class="lead">DotExpress is a laravel template designed to fit any online marketplace. A simple lightweight application ready to be designed and branded.</p>
      <hr class="my-4">
      <p>Created By Areg Ghazaryan.</p>

    </div>
  @else
    @if(@Auth::user()->type=="seller" || Auth::user()->is_admin)
          <a href="/create" class="mb-3 btn btn-primary create"><i class="fas fa-file mr-2"></i>New Product</a>
        @endif
      <h1>All Our Products</h1>
      @if(session()->has('message'))
          <div class="alert alert-success">
              {{ session()->get('message') }}
          </div>
      @endif

    @foreach($posts as $post)
      <div class="product-card">
        <div class="card">
          <div class="card-head">
      <img class="card-img-top" src="/storage/products/{{$post->image}}" alt="Card image cap">
          </div>
          <div class="card-body">
            <h5 class="card-title"><a href="/product/{{$post->unique_id}}"/>{{$post->name}}</a></h5>
            <p class="card-text">{{$post->price}}$</p>
            <p class="card-text">@if($post->stock==0)<span style="color:red;">Not Available </span>@else Stock : {{$post->stock}}@endif</p>
          </div>
          @if($post->by !== Auth::user()->email)
            <button class="btn btn-success" data-toggle="modal" data-price="{{$post->price}}" data-name="{{$post->name}}" data-product="{{$post->unique_id}}" data-quantity="{{$post->stock}}" data-target="#buy"><i class="fas fa-credit-card mr-2"></i>Buy Now</a></button>
          @endif
          <div class="card-body text-center">
            <a href="/product/{{$post->unique_id}}" class="btn btn-primary"><i class="fas fa-info-circle mr-2"></i>Details</a>
              @if(Auth::user())     @if($post->by !== Auth::user()->email) @if($post->stock !== 0)<a href="/add/{{$post->unique_id}}/1" class="btn btn-success mr-2"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</a>@endif @endif @endif


          </div>
          @if(Auth::user()->is_admin)
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

    @endguest
  </div>
  <!-- Modal -->
  <div class="modal fade" id="buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Buy Now</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Product Name : <span id="name"></span>
          <form action="{{route('buy')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
<input class="form-control" type="text" readonly name="name" id="readonly">
<label class="mt-2" for="quantity">Quantity</label>
<select class="custom-select mr-sm-2" name="quantity" id="select">
</select>
<label class="mt-2" for="address">Shipping Address</label>
<input class="form-control" type="text" name="address" value="" required>
<div class="form-check mt-2">
       <input class="form-check-input" type="checkbox" id="check" name="check">
       <label class="form-check-label" for="check">
         High Priority Premium Delivery (Extra Charges May Apply)
       </label>
     </div>
     <h5 class="mt-2"id="total">
<span></span>
       <h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  $('#buy').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var name = $("#name").text(button.data('name'));
  var price = button.data('price');
  var quantity = button.data('quantity');
  var recipient = button.data('product');
  var hiddeninput = $('#readonly');
  $('#total').text("Total : " +price+"$");
  $('#select').change(function () {
    var selected = ($( "#select" ).val());
    $('#total').empty();
    var total  = selected * price;
    $('#total').append("<span>Total : " + total +"$</span>");
  });
for (var i = 1; i <= quantity; i++) {
  $('#select').append('<option value='+i+">"+i+'</option>');
}
$('#buy').on('hidden.bs.modal', function (event) {
  $('#select').empty();
})
  $(hiddeninput).prop("value", button.data('name'));

});




  </script>

@endsection
