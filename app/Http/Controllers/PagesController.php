<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Jobs\ContactMail;
use App\Order;
use App\Product;
use App\User;
use App\Role;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'locations', 'message', 'terms', 'privacy', 'howitworks', 'contact', 'send', 'releases', 'disclaimer']]);
    }

    public function index()
    {
        $post = Product::where('is_approved', 1)->paginate(10);


        if (Auth::check()) {
            if (session('carts')) {
                foreach (session('carts') as $product_id => $quantity) {
                    $product = \App\Product::where('unique_id', $product_id)->first();
                    $cart = new \App\Cart;
                    $cart->product_id = $product->id;
                    $cart->quantity = $quantity;
                    $cart->save();
                    Auth::user()->carts()->attach($cart->id);
                }
                session()->forget('carts');
            }
        }

        return view('pages.index')->with('posts', $post);
    }

    public function disclaimer(){
        return view('pages.disclaimer');
    }

    public function locations()
    {
        return view('pages.locations');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function howitworks()
    {
        return view('pages.howitworks');
    }
    public function send(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'body' => 'required|string|max:700',
        ]);

        // Dispatch your job or query 
        // $email = $request->email;
        // $body = $request->body;
        // $job = (new ContactMail($email))->delay(Carbon::now()->addSeconds(5));
        // dispatch($job);
        return redirect()->back()->with('success', 'Thank you for your message, we will answer between 3 business days');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
    public function message()
    {
        return view('pages.message');
    }

    public function service()
    {
        return view('pages.service');
    }
    public function terms()
    {
        return view('pages.terms');
    }
    public function profile($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $email = $user->email;
        $orders = Order::where('user_id', $id)->get();
        $s_orders = Order::where('seller_id', $id)->get();
        $query = Product::where('user_id', $id)->paginate(12);
        $products = Product::where('is_approved', false)->paginate(12);
        $orderlist = Order::orderBy('is_approved')->paginate(10);
        $sellers = Role::where('machine_name', 'seller')->first()->users;
        $customers = Role::with('users')->where('machine_name', 'customer')->first()->users;
        return view('pages.profile', compact('s_orders', 'sellers', 'query', 'orders', 'products', 'orderlist', 'customers', 'user'));
    }

    public function deleteprofile($id)
    {
        if (Auth::user()->IsAdmin) {
            $user = User::where('id', $id)->firstOrFail();
            $posts = \App\Product::where('user_id', $user->id)->get();
            foreach ($posts as $post) {
                Storage::delete('public/products/' . $post->image);
                Storage::delete('public/products/' . $post->image1);
                Storage::delete('public/products/' . $post->image2);
                Storage::delete('public/products/' . $post->image3);
                $post->delete();
            }
            $user->delete();

            return redirect(url()->previous())->with('success', "Profile And Its User's Content Were Deleted");
        } else {
            return redirect(url()->previous())->with('error', 'Unauthorized Access');
        }
    }

    public function releases()
    {
        return view('pages.releases');
    }
}
