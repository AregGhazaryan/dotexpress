<footer class="page-footer font-small pt-4">

  <!-- Footer Links -->
  <div class="container-fluid text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-6 mt-md-0 mt-1 p-4">

        <!-- Content -->

        <ul class="networks p-1">
          <li class="net-item fb"><a href="facebook.com"><i class="fab fa-facebook-f"></i><a></li>
          <li class="net-item gp"><a href="facebook.com"><i class="fab fa-google-plus-g"></i><a></li>
          <li class="net-item in"><a href="facebook.com"><i class="fab fa-instagram"></i><a></li>
          <li class="net-item ok"><a href="facebook.com"><i class="fab fa-odnoklassniki"></i><a></li>
          <li class="net-item tw"><a href="facebook.com"><i class="fab fa-twitter"></i><a></li>
        </ul>


      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none pb-3">

      <!-- Grid column -->
      <div class="col-md-3 mb-md-0 mb-3 p-4 text-center">

        <!-- Links -->
        <h5 class="text-uppercase">Getting Started</h5>

        <ul class="list-unstyled">
          <li>
            <a href="{{route('register')}}">Register</a>
          </li>
          @if(Gate::allows('add-product'))
          <li>
            <a href="{{route('products.create')}}">Create A Post</a>
          </li>
          @endif
          <li>
            <a href="{{route('terms')}}">Terms And Conditions</a>
          </li>
          <li>
            <a href="{{route('privacy')}}">Privacy Policy</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 mb-md-0 mb-3 p-4 text-center">

        <!-- Links -->
        <h5 class="text-uppercase">About Us</h5>

        <ul class="list-unstyled">
          <li>
            <a href="{{route('how-it-works')}}">How It Works</a>
          </li>
          <li>
            <a href="{{route('contact-us')}}">Contact Us</a>
          </li>
          <li>
            <a href="{{route('releases')}}">Releases</a>
          </li>
          <li>
            <a href="{{route('disclaimer')}}">Disclaimer</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->
    <div class="footer-copyright text-md-left pb-2">© <?php echo date("Y");?> Copyright : DotExpress</div>

  </div>
  <!-- Footer Links -->

</footer>