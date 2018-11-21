<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Order;
use Auth;

class OrderController extends Controller
{
    public function buy(Request $request){
      $validate = $this->validate($request,[
        'name' => 'required',
        'address' => 'required|max:200',
        'quantity' => 'numeric|required',
      ]);

      $name = $request->input('name');
      $post= Post::where('name', $name)->firstOrFail();
      $quantity = $request->input('quantity');
      if($quantity==0){
        return redirect(url()->previous())->with('error','No quantity selected');
      }
      if($quantity>$post->stock){
        return redirect(url()->previous())->with('error','Invalid quantity, not enough items in stock');
      }
      $address = $request->input('address');
      $check = $request->input('check');
      if($post){
        $order = new Order;
        $order->order_id=uniqid();
        $order->name=$post->name;
        $order->user=Auth::user()->email;
        $order->quantity=$quantity;
        $order->product_id=$post->unique_id;
        $order->product_by=$post->by;
        $order->address=$address;
        $order->approved=false;
        $order->price = $quantity * $post->price;
        if($check){
          $order->premium=true;
        }else{
          $order->premium=false;
        }
        $post->decrement('stock',$quantity);
        $order->save();
        return redirect(url()->previous())->with('success','Product successfully ordered, please wait for admin to approve');
      }else{
        return redirect(url()->previous())->with('error','Could not order the product, please try again');
      }
    }
}
