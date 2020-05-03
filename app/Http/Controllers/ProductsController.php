<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;
use Auth;

class ProductsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('product.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $validate = $this->validate($request, [
      'name' => 'required',
      'description' => 'max:1000|required',
      'p-image' => 'image|mimes:jpeg,png,jpg,gif|max:20000|required',
      'images[]' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:20000',
      'stock' => 'required|numeric',
      'price' => 'required|numeric',
      'category' => 'required',
    ]);

    if (!$validate) {
      return redirect('/create')->with('error', 'Please fill all the fields!');
    } else {
      // Processing product data
      $product = new Product;
      $product->name = $request->input('name');
      $product->description = $request->input('description');
      $product->price = $request->input('price');
      $product->stock = $request->input('stock');
      $product->category_id = $request->input('category');
      $product->unique_id = uniqid(true);
      $product->user_id = Auth::user()->id;
      if (Auth::user()->IsAdmin) {
        $product->is_approved = true;
        $product->is_published  = true;
      } else {
        $product->is_approved = false;
        $product->is_published  = false;
      }
      $product->save();

      // Processing Primary Image
      $filenameWithExt = $request->file('p-image')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('p-image')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('p-image')->storeAs('public/product_image', $fileNameToStore);

      $primary_image = new \App\Image;
      $primary_image->path = $fileNameToStore;
      $primary_image->save();
      $primary_image->products()->attach($product->id, ['is_primary' => true]);

      // Processing optional images
      if ($request->images) {
        foreach ($request->images as $image) {
          $filenameWithExt = $image->getClientOriginalName();
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          $extension = $image->getClientOriginalExtension();
          $fileNameToStore = $filename . '_' . time() . '.' . $extension;
          $path = $image->storeAs('public/product_image', $fileNameToStore);

          $image = new \App\Image;
          $image->path = $fileNameToStore;
          $image->save();
          $image->products()->attach($product->id, ['is_primary' => false]);
        }
      }
    }

    return redirect('/')->with('success', 'Post Successfully Created');
  }

  public function search(Request $request)
  {
    $keywords = $request->input('search');

    $complete = explode(' ', $keywords);

    $find = \App\Product::query();

    foreach ($complete as $word) {
      $find = $find->orWhere('name', 'like', '%' . $word . '%');
    }

    return view('pages.search')->with('find', $find->paginate(10));
  }


  public function approve($id)
  {
    $post = Product::where('unique_id', $id)->firstOrFail();
    $post->is_approved = true;
    $post->save();
    return redirect(url()->previous())->with('success', 'Successfully Approved');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($unique_id)
  {
    $product = \App\Product::where('unique_id', $unique_id)->firstOrFail();
    return view('product.index')->with('product', $product);
  }


  public function buy(Request $request)
  {
    $check = $request->input('check');
    $address = $request->input('address');

    foreach (Auth::user()->carts as $item) {
      $order = new \App\Order;
      $order->order_id = uniqid();
      $order->quantity = $item->quantity;
      $order->product_unique_id = $item->product->unique_id;
      $order->is_approved = false;
      if ($check) {
        $order->is_premium = true;
      } else {
        $order->is_premium = false;
      }
      $order->user_id = Auth::user()->id;
      $order->seller_id = $item->product->user_id;
      $order->address = $address;
      $order->arrival_confirmed = false;
      $order->save();
      $item->delete();
    }

    return redirect()->back()->with('success', 'Orders Have Been Successfully Placed, Please Wait For Confirmation');
  }

  public function buyNow(Request $request)
  {
    $product = \App\Product::find($request->id);
    $order = new \App\Order;
    $order->order_id = uniqid();
    $order->quantity = $request->quantity;
    $order->product_unique_id = $product->unique_id;
    $order->is_approved = false;
    if ($request->check) {
      $order->is_premium = true;
    } else {
      $order->is_premium = false;
    }
    $order->user_id = Auth::user()->id;
    $order->seller_id = $product->user_id;
    $order->address = $request->address;
    $order->arrival_confirmed = false;
    $order->save();

    return redirect()->back()->with('success', 'Order successfully placed');
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $product = \App\Product::where('unique_id', $id)->first();
    return view('product.edit')->with('product', $product);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $product = \App\Product::where('unique_id', $id)->first();
    if ($product->user_id !== Auth::id() || Auth::user()->IsAdmin) {

      $validate = $this->validate($request, [
        'name' => 'required',
        'description' => 'max:1000|required',
        'p-image' => 'image|mimes:jpeg,png,jpg,gif|max:20000',
        'images[]' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:20000',
        'stock' => 'required|numeric',
        'price' => 'required|numeric',
        'category' => 'required',
      ]);

      // Processing product data
      $product->name = $request->name;
      $product->description = $request->description;
      $product->price = $request->price;
      $product->stock = $request->stock;
      $product->category_id = $request->category;
      $product->unique_id = uniqid(true);
      $product->user_id = Auth::user()->id;
      $product->save();


      // Processing Primary Image
      if ($request->file('p-image')) {
        Storage::delete('public/product_image/' . $product->PrimaryImage->path);
        $filenameWithExt = $request->file('p-image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('p-image')->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('p-image')->storeAs('public/product_image', $fileNameToStore);

        $primary_image = new \App\Image;
        $primary_image->path = $fileNameToStore;
        $primary_image->save();
        $primary_image->products()->attach($product->id, ['is_primary' => true]);
      }

      if ($request->images) {
        // Processing optional images
        foreach ($product->SecondaryImages as $image) {
          Storage::delete('public/product_image/' . $image->path);
        }

        if ($request->images) {
          foreach ($request->images as $image) {
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $image->storeAs('public/product_image', $fileNameToStore);

            $image = new \App\Image;
            $image->path = $fileNameToStore;
            $image->save();
            $image->products()->attach($product->id, ['is_primary' => false]);
          }
        }
      }
      return redirect('/')->with('success', 'Post Successfully Created');
    } else {
      return redirect()->back()->with('error', 'Unauthorized access');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product = \App\Product::where('id', $id)->firstOrFail();;
    if ($product->user_id === Auth::user()->id || Auth::user()->IsAdmin) {
      foreach ($product->images as $image) {
        Storage::delete('public/product_image/' . $image->path);
      }
      $product->delete();
      return redirect('/')->with('success', 'Post Deleted');
    } else {
      return redirect(url()->previous())->with('error', 'Unauthorized Access');
    }
  }
}
