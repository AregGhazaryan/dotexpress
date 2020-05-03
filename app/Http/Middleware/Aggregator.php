<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class Aggregator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $cart_sum = array_sum(array_column(Auth::user()->carts->toArray(), 'quantity'));
            $wish_sum = \App\WishList::where('user_id', Auth::user()->id)->count();
        }else{
            $cart_sum = session('carts') ? array_sum(session('carts')) : null;
            $wish_sum = null;
        }
        $categories = \App\Category::where('is_published', true)->get();

        view()->share(compact('categories', 'cart_sum', 'wish_sum'));

        return $next($request);
    }
}
