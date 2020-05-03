<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Cart;
use App\Order;
use App\WishList;

class PostsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['show', 'search']]);
  }

  public function index()
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $post = Post::where('unique_id', $id)->firstOrFail();
    if ($post->by !== Auth::user()->email || Auth::user()->is_admin) {
      return redirect('/')->with('error', 'Unauthorized Access!');
    } else {
      return view('pages.edit')->with('post', $post);
    }
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
    $validate = $this->validate($request, [
      'description' => 'max:1000',
      'p-image' => 'image|mimes:jpeg,png,jpg,gif|max:200000',
      'images[]' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:20000',
      'stock' => 'numeric',
      'price' => 'numeric',
    ]);


    $post = Post::where('unique_id', $id)->first();

    if (empty($request->input('name'))) {
      $post->name = $post->name;
    } else {
      $post->name = $request->input('name');
    }
    if (empty($request->input('description'))) {
      $post->description = $post->description;
    } else {
      $post->description = $request->input('description');
    }
    if (empty($request->input('price'))) {
      $post->price = $post->price;
    } else {
      $post->price = $request->input('price');
    }
    if (empty($request->input('stock'))) {
      $post->stock = $post->stock;
    } else {
      $post->stock = $request->input('stock');
    }
    if (empty($request->input('category'))) {
      $post->category = $post->category;
    } else {
      $post->category = $request->input('category');
    }

    if ($request->file('p-image')) {
      Storage::delete('public/products/' . $post->image);
      $filenameWithExt = $request->file('p-image')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('p-image')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('p-image')->storeAs('public/products', $fileNameToStore);
      $post->image = $fileNameToStore;
    }
    
    if ($request->file('image1')) {
      Storage::delete('public/products/' . $post->image1);
      $filenameWithExt = $request->file('image1')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('image1')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('image1')->storeAs('public/products', $fileNameToStore);
      $post->image1 = $fileNameToStore;
    }

    if ($request->file('image2')) {
      Storage::delete('public/products/' . $post->image2);
      $filenameWithExt = $request->file('image2')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('image2')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('image2')->storeAs('public/products', $fileNameToStore);
      $post->image2 = $fileNameToStore;
    }


    if ($request->file('image3')) {
      Storage::delete('public/products/' . $post->image3);
      $filenameWithExt = $request->file('image3')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('image3')->getClientOriginalExtension();
      $fileNameToStore = $filename . '_' . time() . '.' . $extension;
      $path = $request->file('image3')->storeAs('public/products', $fileNameToStore);
      $post->image3 = $fileNameToStore;
    }

    $post->save();
    return redirect('/profile/' . Auth::user()->id)->with('success', 'Post Edited');
  }


  public function add(Request $request, $id, $quantity)
  {
    $desc = Post::where('unique_id', $id)->firstorFail()->decrement('stock', $quantity);
    $post = Post::where('unique_id', $id)->firstorFail();
    $exist = Cart::where('product', $id)->where('user', Auth::user()->email)->first();

    if ($exist) {
      $exist->increment('quantity', $quantity);
      $calculatedPrice = $exist->quantity * $post->price;
      $exist->price = $calculatedPrice;
      $exist->save();
      return redirect(url()->previous())->with('success', 'Added To Cart');
    } else {
      $query = Post::where('unique_id', $id)->firstorFail();
      if (is_numeric($quantity)) {
        $cart = new Cart;
        $cart->user = Auth::user()->email;
        $cart->name = $query->name;
        $cart->quantity = $quantity;
        $cart->price = $query->price * $quantity;
        $cart->product = $id;
        $cart->save();
        return redirect(url()->previous())->with('success', 'Added To Cart');
      }
    }
  }

  public function addtocart(Request $request, $id)
  {
    $quantity = $request->input('quantity');
    $desc = Post::where('unique_id', $id)->firstorFail()->decrement('stock', $quantity);
    $post = Post::where('unique_id', $id)->firstorFail();
    $exist = Cart::where('product', $id)->where('user', Auth::user()->email)->first();

    if ($exist) {
      $exist->increment('quantity', $quantity);
      $calculatedPrice = $exist->quantity * $post->price;
      $exist->price = $calculatedPrice;
      $exist->save();
      return redirect(url()->previous())->with('success', 'Successfully add to cart');
    } else {
      $query = Post::where('unique_id', $id)->firstorFail();
      if (is_numeric($quantity)) {
        $cart = new Cart;
        $cart->user = Auth::user()->email;
        $cart->name = $query->name;
        $cart->quantity = $quantity;
        $cart->price = $query->price * $quantity;
        $cart->product = $id;
        $cart->save();
        return redirect(url()->previous())->with('success', 'Successfully add to cart');
      }
    }
  }

  public function wish($id)
  {
    $find = \App\Product::where('unique_id', $id)->firstorfail();
    $wish = \App\WishList::where('user_id', Auth::user()->id)->where('product_unique_id', $id)->get();

    if ($wish->count() > 0) {
      return redirect(url()->previous())->with('success', 'Selected Product Is Already In Your Wish List');
    } else {
      $wish = new \App\WishList;
      $wish->product_unique_id = $id;
      $wish->user_id = Auth::user()->id;
      $wish->save();
      
      return redirect(url()->previous())->with('success', 'Added To Wish List');
    }
  }

  public function approveorder($id)
  {
    if (Auth::user()->is_admin) {
      $post = Order::where('order_id', $id)->firstOrFail();
      $post->update(['approved' => true]);
      return redirect(url()->previous() . '#tab')->with('success', 'Successfully Approved');
    } else {
      return redirect(url()->previous())->with('error', 'Insufficient Permissions');
    }
  }


}
