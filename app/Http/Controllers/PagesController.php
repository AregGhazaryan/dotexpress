<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Cart;
use App\Order;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ContactMail;
use Carbon\Carbon;
use Auth;
use DB;


class PagesController extends Controller
{

  public function __construct()
{
$this->middleware('auth', ['except' => ['index', 'locations', 'message','terms', 'privacy','howitworks','contact', 'send']]);
}

  public function index(){
    $post= Post::where('is_approved', 1)->paginate(20);
    return view('pages.index')->with('posts', $post);
  }

  public function send(Request $request){
    $validatedData = $request->validate([
        'email' => 'required|string|email|max:255',
        'body' => 'required|string|max:700',
    ]);
    $email = $request['email'];
    $body = $request['body'];
    $query = DB::table('support')->insert(
    ['email' => $email, 'body' => $body]
);
    $email = $request['email'];
    $job = (new ContactMail($email))->delay(Carbon::now()->addSeconds(5));
    dispatch($job);
    return redirect('/contact')->with('success','Thank you for your message, we will answer between 3 business days');
  }


  public function locations(){
    return view('pages.locations');
  }
  public function contact(){
    return view('pages.contact');
  }
  public function howitworks(){
    return view('pages.howitworks');
  }
  public function privacy(){
    return view('pages.privacy');
  }
  public function message(){
    return view('pages.message');
  }

  public function service(){
    return view('pages.service');
  }
  public function terms(){
    return view('pages.terms');
  }
  public function profile($id){
    $post = User::where('id',$id)->firstOrFail();
    $email = $post->email;
    $orders = Order::where('user',$email)->get();
    $seller = Order::where('product_by',$email)->get();
    $query = Post::where('by',$email)->paginate(12);
    $productlist = Post::orderBy('is_approved')->paginate(12);
    $orderlist = Order::orderBy('approved')->paginate(10);
    $users = User::where('type', 'seller')->paginate(10);
    $customers = User::where('type', 'customer')->paginate(10);
    return view('pages.profile')->with('post',$post)->with('query',$query)->with('orders',$orders)->with('products',$productlist)->with('orderlist',$orderlist)->with('users',$users)->with('customers',$customers)->with('seller',$seller);
  }

  public function checkout(){

    $query = Cart::where('user',Auth::user()->email)->get();
    if(!$query->isEmpty()){
      return view('pages.checkout')->with('products', $query);
    }else{
      return view('pages.checkout')->with('success','Nothing to display');
    }
  }

  public function deleteprofile($id){
    if(Auth::user()->is_admin){
      $user= User::where('id',$id)->firstOrFail();
      $posts= Post::where('by', $user->email)->get();
      $orders= Order::where('user', $user->email)->get();
      $carts = Cart::where('user', $user->email)->get();
      foreach($posts as $post){
        Storage::delete('public/products/'.$post->image);
        Storage::delete('public/products/'.$post->image1);
        Storage::delete('public/products/'.$post->image2);
        Storage::delete('public/products/'.$post->image3);
        $post->delete();
      }
      $user->delete();
      foreach($orders as $order){
          $order->delete();
      }
      foreach ($carts as $cart) {
      $cart->delete();
      }
      return redirect(url()->previous())->with('success',"Profile And Its User's Content Were Deleted");
    }else{
      return redirect(url()->previous())->with('error','Unauthorized Access');
    }
  }
}
