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

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
{
  $this->middleware('auth',['except'=> ['show','search']]);
}

    public function index()
    {
      if(Auth::user()->type==='customer'){
        return redirect('/')->with('error','Unauthorized Access');
      }else{
          return view('pages.create');
      }
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
      $validate = $this->validate($request,[
        'name' => 'required',
        'description' => 'max:1000|required',
        'p-image' => 'image|mimes:jpeg,png,jpg,gif|max:20000|required',
        'images[]' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:20000',
        'stock' => 'required|numeric',
        'price' => 'required|numeric',
        'category' => 'required',
      ]);
if(!$validate){
    return redirect('/create')->with('error','Please fill all the fields!');
}else{
      $post = new Post;
      $post->name = $request->input('name');
      $post->description = $request->input('description');
      $post->price = $request->input('price');
      $post->stock= $request->input('stock');
      $post->category= $request->input('category');
      $post->unique_id= uniqid(true);
      $post->by=Auth::user()->email;
      if(Auth::user()->is_admin){
          $post->is_approved = true;
      }else{
          $post->is_approved = false;
      }
        $filenameWithExt = $request->file('p-image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('p-image')->getClientOriginalExtension();
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        $path = $request->file('p-image')->storeAs('public/products', $fileNameToStore);
        $post->image=$fileNameToStore;


if ($request->file('image1')) {
  $filenameWithExt = $request->file('image1')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image1')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image1')->storeAs('public/products', $fileNameToStore);
  $post->image1=$fileNameToStore;
}else{
  $post->image1=null;
}

if ($request->file('image2')) {
  $filenameWithExt = $request->file('image2')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image2')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image2')->storeAs('public/products', $fileNameToStore);
  $post->image2=$fileNameToStore;
}else{
  $post->image2=null;
}


if ($request->file('image3')) {
  $filenameWithExt = $request->file('image3')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image3')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image3')->storeAs('public/products', $fileNameToStore);
  $post->image3=$fileNameToStore;
}else{
  $post->image3=null;
}



}

        $post->save();
        return redirect('/')->with('success','Post Successfully Created');
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
        if($post->by !== Auth::user()->email || Auth::user()->is_admin){
          return redirect('/')->with('error','Unauthorized Access!');
        }else{
            return view('pages.edit')->with('post',$post);
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
      $validate = $this->validate($request,[
        'description' => 'max:1000',
        'p-image' => 'image|mimes:jpeg,png,jpg,gif|max:200000',
        'images[]' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:20000',
        'stock' => 'numeric',
        'price' => 'numeric',
      ]);


      $post = Post::where('unique_id',$id)->first();

      if(empty($request->input('name'))){
          $post->name = $post->name;
      }else{
        $post->name = $request->input('name');
      }
      if(empty($request->input('description'))){
          $post->description= $post->description;
      }else{
        $post->description = $request->input('description');
      }
      if(empty($request->input('price'))){
          $post->price= $post->price;
      }else{
        $post->price = $request->input('price');
      }
      if(empty($request->input('stock'))){
          $post->stock= $post->stock;
      }else{
        $post->stock = $request->input('stock');
      }
      if(empty($request->input('category'))){
          $post->category= $post->category;
      }else{
        $post->category = $request->input('category');
      }

    if($request->file('p-image')){
      Storage::delete('public/products/'.$post->image);
      $filenameWithExt = $request->file('p-image')->getClientOriginalName();
      $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
      $extension = $request->file('p-image')->getClientOriginalExtension();
      $fileNameToStore = $filename.'_'.time().'.'.$extension;
      $path = $request->file('p-image')->storeAs('public/products', $fileNameToStore);
      $post->image=$fileNameToStore;
    }





if ($request->file('image1')) {
  Storage::delete('public/products/'.$post->image1);
  $filenameWithExt = $request->file('image1')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image1')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image1')->storeAs('public/products', $fileNameToStore);
  $post->image1=$fileNameToStore;
}

if ($request->file('image2')) {
    Storage::delete('public/products/'.$post->image2);
  $filenameWithExt = $request->file('image2')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image2')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image2')->storeAs('public/products', $fileNameToStore);
  $post->image2=$fileNameToStore;
}


if ($request->file('image3')) {
  Storage::delete('public/products/'.$post->image3);
  $filenameWithExt = $request->file('image3')->getClientOriginalName();
  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
  $extension = $request->file('image3')->getClientOriginalExtension();
  $fileNameToStore = $filename.'_'.time().'.'.$extension;
  $path = $request->file('image3')->storeAs('public/products', $fileNameToStore);
  $post->image3=$fileNameToStore;
}

        $post->save();
        return redirect('/profile/'.Auth::user()->id)->with('success','Post Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $post=Post::where('id',$id)->firstOrFail();;
    if($post->by === Auth::user()->email){

            Storage::delete('public/products/'.$post->image);
            Storage::delete('public/products/'.$post->image1);
            Storage::delete('public/products/'.$post->image2);
            Storage::delete('public/products/'.$post->image3);
            $post->delete();
            return redirect('/')->with('success','Post Deleted');

      }else{

        return redirect(url()->previous())->with('error','Unauthorized Access');
      }
    }

    public function forget(){
      $email = Auth::user()->email;

    $query = Cart::where('user', $email)->get();

    foreach($query as $item){
        Post::where('unique_id',$item->product)->increment('stock', $item->quantity);
    }

    $del = Cart::where('user', $email)->delete();
    return redirect(url()->previous())->with('success','Cart is empty!');
    }


public function del($id){
  $email = Auth::user()->email;
  $query = Cart::where('product', $id)->where('user', $email)->get();
foreach($query as $item){
    Post::where('unique_id',$item->product)->increment('stock', $item->quantity);
}
$del = Cart::where('user', $email)->where('product', $id)->delete();
return redirect(url()->previous())->with('success','Item Deleted!');
}


    public function add(Request $request, $id, $quantity){
      $desc = Post::where('unique_id',$id)->firstorFail()->decrement('stock',$quantity);
      $post = Post::where('unique_id',$id)->firstorFail();
      $exist = Cart::where('product', $id)->where('user', Auth::user()->email)->first();

      if($exist){
        $exist->increment('quantity', $quantity);
        $calculatedPrice = $exist->quantity * $post->price;
        $exist->price = $calculatedPrice;
        $exist->save();
        return redirect(url()->previous())->with('success','Added To Cart');
      }else{
        $query = Post::where('unique_id',$id)->firstorFail();
        if(is_numeric($quantity)){
          $cart = new Cart;
          $cart->user=Auth::user()->email;
          $cart->name=$query->name;
          $cart->quantity=$quantity;
          $cart->price = $query->price * $quantity;
          $cart->product=$id;
          $cart->save();
          return redirect(url()->previous())->with('success','Added To Cart');
        }
      }
    }

    public function addtocart(Request $request, $id){
      $quantity = $request->input('quantity');
      $desc = Post::where('unique_id',$id)->firstorFail()->decrement('stock',$quantity);
      $post = Post::where('unique_id',$id)->firstorFail();
      $exist = Cart::where('product', $id)->where('user', Auth::user()->email)->first();

      if($exist){
        $exist->increment('quantity', $quantity);
        $calculatedPrice = $exist->quantity * $post->price;
        $exist->price = $calculatedPrice;
        $exist->save();
        return redirect(url()->previous())->with('success','Successfully add to cart');
      }else{
        $query = Post::where('unique_id',$id)->firstorFail();
        if(is_numeric($quantity)){
          $cart = new Cart;
          $cart->user=Auth::user()->email;
          $cart->name=$query->name;
          $cart->quantity=$quantity;
          $cart->price = $query->price * $quantity;
          $cart->product=$id;
          $cart->save();
          return redirect(url()->previous())->with('success','Successfully add to cart');
        }
      }
  }

  public function search(Request $request){
    $keywords = $request->input('search');
    $complete = explode(' ', $keywords);
    $find = Post::query();
    foreach($complete as $word){
      $find = $find->orWhere('name', 'like', '%' . $word . '%')->paginate(20);
    }
    $count = $find->count();
    if($count == 0){
      $find = null;
      return view('pages.search')->with('error','Could not find anything')->with('find',$find);

    }else{
        return view('pages.search')->with('find',$find);
    }
  }
  public function wish($id){
    $find = Post::where('unique_id', $id)->firstorfail();
    $wish = DB::table('wish')->where('product', $id)->where('user',Auth::user()->email)->get();

    if($wish->count()>0){
          return redirect(url()->previous())->with('success','Selected Product Is Already In Your Wish List');
    }else{
      $query = DB::table('wish')->insert(
      ['product' => $id, 'user' => Auth::user()->email, 'name' => $find->name]
  );
    return redirect(url()->previous())->with('success','Added To Wish List');
    }

  }

  public function wishindex($email){
    $query = DB::table('wish')->where('user',$email)->get();
    $chunk = [];
    foreach($query as $row){
    $check = Post::where('unique_id',$row->product)->get();
    $chunk[] = $check;
    }
    return view('pages.wish')->with('products', $chunk);
  }
  public function wishdelete($id){
 DB::table('wish')->where('product',$id)->where('user', Auth::user()->email)->delete();
 return redirect(url()->previous())->with('success','Deleted');
  }

  public function approve($id){
    if(Auth::user()->is_admin){
      $post = Post::where('unique_id', $id)->firstOrFail();
      $post->update(['is_approved' => true]);
      return redirect(url()->previous())->with('success','Successfully Approved');
    }else{
      return redirect(url()->previous())->with('error','Insufficient Permissions');
    }
  }

  public function approveorder($id){
    if(Auth::user()->is_admin){
      $post = Order::where('order_id', $id)->firstOrFail();
      $post->update(['approved' => true]);
      return redirect(url()->previous() . '#tab')->with('success','Successfully Approved');
    }else{
      return redirect(url()->previous())->with('error','Insufficient Permissions');
    }
  }

  public function checkoutbuy(Request $request){
    $cart = Cart::where('user',Auth::user()->email)->get();
    $check = $request->input('check');
    $address = $request->input('address');
    foreach($cart as $item){
      $order = new Order;
      $order->order_id = uniqid();
      $order->name = $item->name;
      $order->quantity = $item->quantity;
      $order->product_id = $item->product;
      $order->price = $item->price;
      $order->approved = false;
      $order->confirmed = false;
      if($check){
        $order->premium=true;
      }else{
        $order->premium=false;
      }
      $order->user = Auth::user()->email;
      $selected = Post::where('unique_id', $item->product)->first();
      $order->product_by = $selected->by;
      $order->address= $address;
      $order->save();
      $item->delete();
    }
return redirect(url()->previous())->with('success','Orders Have Been Successfully Placed, Please Wait For Confirmation');
  }
}
