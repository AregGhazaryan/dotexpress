<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Auth;

class CartsController extends Controller
{
    public function store(Request $request, $unique_id)
    {
        $product = \App\Product::where('unique_id', $unique_id)->firstOrFail();
        if (Auth::check()) {
            // Checking if the user has already added the same product to cart
            $exists_product = \App\Product::where('unique_id', $unique_id)->first();
            $exists = Auth::user()->carts->where('product_id', $exists_product->id)->first();

            if ($exists) {
                $exists->increment('quantity', $request->quantity ? $request->quantity : 1);
                $exists->save();
            } else {
                $cart = new \App\Cart;
                $cart->product_id = $product->id;
                $cart->quantity = $request->quantity ? $request->quantity : 1;
                $cart->save();
                $cart->users()->attach(Auth::user()->id);
            }
        } else {
            // Make a session cart if user doesnt exist

            if (session('carts')) {
                $cart = session('carts');
                if (array_key_exists($product->id, $cart)) {
                    $cart[$product->unique_id] = $cart[$product->unique_id] + ($request->quantity ? $request->quantity : 1);
                } else {
                    $cart[$product->unique_id] = $request->quantity ? $request->quantity : 1;
                }
                session()->put('carts', $cart);
            } else {
                $item = [$product->unique_id => $request->quantity ? $request->quantity : 1];
                session()->put('carts', $item);
            }
        }


        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function checkout()
    {
        if (Auth::check()) {
            $carts = Auth::user()->carts;
        } else {
            $carts = [];
            if (session('carts')) {
                foreach (session('carts') as $product_id => $quantity) {
                    $carts[$product_id] = \App\Product::where('unique_id', $product_id)->first();
                    $carts[$product_id]->quantity = $quantity;
                }
            }
        }
        return view('pages.checkout')->with('carts', $carts);
    }

    public function empty()
    {
        if (Auth::check()) {
            Auth::user()->carts()->delete();
        } else {
            session()->forget('carts');
        }

        return redirect(url()->previous())->with('success', 'Cart is empty!');
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            Auth::user()->carts()->where('carts.id', $id)->delete();
        } else {
            $carts = session('carts');
            unset($carts[$id]);
            session()->put('carts', $carts);
        }
        return redirect(url()->previous())->with('success', 'Item Deleted!');
    }
}
