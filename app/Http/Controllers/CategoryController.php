<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;

class CategoryController extends Controller
{

  public function sort($category, Request $request){
    if ($request->input('sort')==0) {
      $posts= Post::where('category',$category)->orderBy("name","asc")->get();
        $count= $posts->count();
      return view('category.index')->with('posts',$posts)->with('count',$count);
    }elseif($request->input('sort')==1){
      $posts= Post::where('category',$category)->orderBy("name","desc")->get();
        $count= $posts->count();
      return view('category.index')->with('posts',$posts)->with('count',$count);
    }elseif($request->input('sort')==2){
      $posts= Post::where('category',$category)->orderBy("price","asc")->get();
        $count= $posts->count();
      return view('category.index')->with('posts',$posts)->with('count',$count);
    }elseif($request->input('sort')==3){
      $posts= Post::where('category',$category)->orderBy("price","desc")->get();
        $count= $posts->count();
      return view('category.index')->with('posts',$posts)->with('count',$count);
    }

  }

    public function index($name){

    switch ($name) {
      case $name == 'electronics':
        $posts= Post::where("category","electronics")->paginate(10);
          $count= $posts->count();
        return view('category.index')->with('posts',$posts)->with('count',$count);
        break;
        case $name == 'accessories':
        $posts= Post::where("category","accessories")->paginate(10);
        $count= $posts->count();
          return view('category.index')->with('posts',$posts)->with('count',$count);
          break;
          case $name == 'food':
          $posts= Post::where("category","food")->paginate(10);
                  $count= $posts->count();
            return view('category.index')->with('posts',$posts)->with('count',$count);
            break;
            case $name == 'clothing':
            $posts= Post::where("category","clothing")->paginate(10);
            $count= $posts->count();
              return view('category.index')->with('posts',$posts)->with('count',$count);
              break;
              case $name == 'alcohol':
              $posts= Post::where("category","alcohol")->paginate(10);
                    $count= $posts->count();
                return view('category.index')->with('posts',$posts)->with('count',$count);;
                break;
      default:
      abort(404);
        break;
    }
    }
    public function product($id){
      $posts=Post::where('unique_id',$id)->first();
      $byuser=$posts->by;
      $user= User::where('email',$byuser)->first();
      if($user){
          return view('category.product')->with('post',$posts)->with('user',$user);
      }else{
        return view('category.product')->with('post',$posts);
      }

    }
}
