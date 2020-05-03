<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Order;
use Auth;

class OrderController extends Controller
{

  public function approve($id)
  {
    $order = \App\Order::findOrFail($id);

    if ($order->seller_id !== Auth::user()->id) {
      return redirect()->back()->with('error', 'Unauthorized access!');
    } else {
      $order->is_approved = true;
      $order->save();
    }

    return redirect()->back()->with('success', 'Order successfully approved');
  }
}
