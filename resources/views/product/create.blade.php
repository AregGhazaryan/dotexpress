@extends('layouts.core')
@section('content')
<div class="content">

  <form class="create-form" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="title">Product Name</label>
      <input type="text" class="form-control" id="product-name" aria-describedby="name" placeholder="Product Name"
        name="name">
    </div>
    <div class="form-group">
      <label for="description">Product Description</label>
      <textarea cols="10" rows="10" class="form-control" placeholder="Description" name='description'></textarea>
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
          @foreach($categories as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
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
        <input type="file" class="custom-file-input" name='images[]' multiple>
        <label class="custom-file-label" for="image1">Optional Images</label>
        <div class="invalid-feedback">Invalid File</div>
      </div>
    </div>
    <div class="form-group text-center">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>

  </form>
</div>
@endsection