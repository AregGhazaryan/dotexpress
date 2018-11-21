@extends('layouts.core')
@section('content')
  <div class="content">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="create-form" action="{{  action('PostsController@store')  }}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="form-group">
          <label for="title">Product Name</label>
          <input type="text" class="form-control" id="product-name" aria-describedby="name" placeholder="Product Name" name="name">
        </div>
        <div class="form-group">
            <label for="description">Product Description</label>
            <textarea cols="10" rows="10" class="form-control"  placeholder="Description" name='description'></textarea>
          </div>
          <div class="row">
            <div class="form-group form-mini">
                <label for="stock">Stock</label>
                <input type="text" name="stock" class="form-control">
              </div>
            <div class="form-group form-mini">
                <label for="price">Price In USD</label>
                <input type="text" name="price" class="form-control">
              </div>
              <div class="form-mini">
                <label for="category">Category</label>
                <select class="custom-select" name="category">
                  <option selected value=''>Select The Category</option>
                  <option value="electronics">Electronics</option>
                  <option value="accessories">Accessories</option>
                  <option value="food">Food</option>
                  <option value="clothing">Clothing</option>
                  <option value="alcohol">Alcohol</option>
                </select>
              </div>
          </div>
<div class="form-group form-row">
          <div class="custom-file col-auto">
   <input type="file" class="custom-file-input" name='p-image' required>
   <label class="custom-file-label" for="p-image">Primary Image</label>
   <div class="invalid-feedback">Invalid File</div>
 </div>
 <div class="custom-file col-auto">
<input type="file" class="custom-file-input" name='image1'>
<label class="custom-file-label" for="image1">Optional Image</label>
<div class="invalid-feedback">Invalid File</div>
</div>
<div class="custom-file col-auto">
<input type="file" class="custom-file-input" name='image2'>
<label class="custom-file-label" for="image2">Optional Image</label>
<div class="invalid-feedback">Invalid File</div>
</div>
<div class="custom-file col-auto">
<input type="file" class="custom-file-input" name='image3'>
<label class="custom-file-label" for="image3">Optional Image</label>
<div class="invalid-feedback">Invalid File</div>
</div></div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-success">Submit</button>
</div>

    </form>
  </div>
@endsection
