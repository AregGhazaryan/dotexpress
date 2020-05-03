<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Mail;

class EmailController extends Controller
{
  public function send($id)
  {
    $order = Order::where('order_id', $id)->firstOrFail();
    if (!$order->product_by === Auth::user()->email) {
      return redirect(url()->previous())->with('error', 'Unauthorized access');
    } else {
      $title = "Order Confirmation";
      $content = "Your order has been successfully accepted";
      Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message) {

        $message->from('dotexpress@gmail.com', 'Support');
        $message->subject('DotExpress Order Confirmation');
        $message->to('');
      });
    }

    $order->update(['confirmed' => true]);
    return redirect(url()->previous())->with('success', 'Order Successfully Confirmed');
  }
}
