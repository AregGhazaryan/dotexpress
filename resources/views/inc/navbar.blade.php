<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="/"><img src="{{asset('logo.png')}}"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse mt-3" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/locations">Locations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/customerservice">Customer Service</a>
      </li>

    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="mr-5">
        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}">
          <input class="form-control mr-sm-2 search" type="search" placeholder="Search" aria-label="Search"
            name='search'>
          <button class="btn btn-search" type="submit"><i class="fas fa-search"></i></button>
        </form>
      </li>
      <li class="nav-item"><a class="nav-link" href="{{route('carts.checkout')}}" /><i
          class="fas fa-shopping-cart mr-2"></i>Cart
        @if($cart_sum)
        <span class="badge badge-pill badge-danger">{{$cart_sum}}</span>
        @endif

        </a></li>
      <!-- Authentication Links -->
      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
      </li>
      <li class="nav-item">
        @if (Route::has('register'))
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
      </li>
      @else
      <li class="nav-item"><a class="nav-link" href="{{route('wish.index')}}">
        <i class="fas fa-heart mr-2"></i>Wish List
        @if($wish_sum)<span class="badge badge-pill badge-danger">{{$wish_sum}}</span>@endif
      
      </a></li>
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" v-pre>
          <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="/profile/{{Auth::user()->id}}"><i class="fas fa-user mr-2"></i>Profile</a>
          <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
              class="fas fa-sign-out-alt"></i>
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
      @endguest
  </div>

  </ul>
</nav>


<nav class="navbar navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categories"
    aria-controls="categories" aria-expanded="false" aria-label="Toggle navigation">
    Categories
    <i class="fas fa-bars"></i>
  </button>
</nav>

<div class="pos-f-b">
  <div class="collapse" id="categories">
    <div class="bg-dark p-4">
      <h4 class="text-white">Browse By Category</h4>
      <ul class="cat-menu">
        @foreach($categories as $category)
        <li><a href="{{route('categories.show', $category->machine_name)}}">{{$category->name}}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>