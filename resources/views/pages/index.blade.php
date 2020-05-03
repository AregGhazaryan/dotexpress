@extends('layouts.core')
@section('content')
<div class="content">

  @if(Gate::allows('add-product'))
  <a href="{{route('products.create')}}" class="mb-3 btn btn-primary create"><i class="fas fa-file mr-2"></i>New
    Product</a>
  @endif
  <h1>All Our Products</h1>

  <div class="row justify-content-around">
    @foreach($posts as $post)

    <div class="product-card">
      <div class="card">

        <a href="{{route('products.show', $post->unique_id)}}">
          <div class="card-head">
            <img class="card-img-top"
              src="{{$post->PrimaryImage ? asset('storage/product_image/'.$post->PrimaryImage->path) : asset('img/default_product.png')}}"
              alt="Card image cap">
          </div>
          <div class="card-body">
            <h5 class="card-title">{{substr($post->name,0, 25)}}</h5>
        </a>
        <p class="card-text">{{$post->price}}$</p>
        <p class="card-text">@if(!$post->stock)<span style="color:red;">Not Available </span>@else Stock :
          {{$post->stock}}@endif</p>
      </div>

      <button class="btn btn-success" data-toggle="modal" data-price="{{$post->price}}" data-name="{{$post->name}}"
        data-product="{{$post->unique_id}}" data-quantity="{{$post->stock}}" data-id="{{$post->id}}"
        data-target="#buy"><i class="fas fa-credit-card mr-2"></i>Buy Now</a></button>
      <div class="card-body text-center">
        @if($post->stock !== 0)
        <form action="{{ route('carts.store', $post->unique_id) }}" method="POST">
          <button type="submit" class="col btn btn-primary"><i class="fas fa-cart-plus mr-2"></i>Add To Cart</button>
        </form>
        @endif
      </div>

      @if(Auth::check() && Auth::user()->IsAdmin)
      <form action="{{ route('products.destroy' , $post->id)}}"
        onsubmit="return confirm('Are you sure you want to delete ?');" class="d-flex justify-content-between" method="POST">
      <a href="{{route('products.edit', $post->unique_id)}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
      @csrf
        @method('DELETE')
        <button class="btn btn-danger"><i class="fas fa-trash-alt" style="color:white;"></i></a>
      </form>
      @endif

    </div>
  </div>

  @endforeach
</div>
<div class="links">
  {{$posts->links()}}
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="buy" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
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
        <form action="{{route('products.buy-now')}}" method="post">
          <div id="input-container"></div>
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
          <h5 class="mt-2" id="total">
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
  let button = $(event.relatedTarget);
  let name = $("#name").text(button.data('name'));
  let price = button.data('price');
  let quantity = button.data('quantity');
  let recipient = button.data('product');
  let hiddeninput = $('#readonly');
  let inputContainer = document.getElementById('input-container');
  inputContainer.innerHTML = '';
  let idInput = document.createElement('input');
  idInput.setAttribute('name','id');
  idInput.setAttribute('type', 'hidden');
  idInput.setAttribute('value', button.data('id'));

  inputContainer.appendChild(idInput);

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