<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Product;
use App\User;

class CategoryController extends Controller
{

  public function sort($category, Request $request)
  {
    if ($request->input('sort') == 0) {
      $posts = Product::where('category_id', $category)->orderBy("name", "asc")->paginate(20);
    } elseif ($request->input('sort') == 1) {
      $posts = Product::where('category_id', $category)->orderBy("name", "desc")->paginate(20);
    } elseif ($request->input('sort') == 2) {
      $posts = Product::where('category_id', $category)->orderBy("price", "asc")->paginate(20);
    } elseif ($request->input('sort') == 3) {
      $posts = Product::where('category_id', $category)->orderBy("price", "desc")->paginate(20);
    }

    return view('category.index', compact('posts'));
  }

  public function index($name)
  {
    $category = \App\Category::where('machine_name', $name)->first();
    $products = \App\Product::where('category_id', $category->id)->paginate(12);
    return view('category.index')->with('posts', $products);
  }
}
