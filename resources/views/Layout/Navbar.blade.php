<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top bg-light mb-5 navbar-light">
  <div class="container">
    <a class="navbar-brand" href="#"><img id="MDB-logo"
        src="{{ asset('images/pic.png') }}" alt="Brand Image Logo"
        draggable="false" height="50" /></a>
        <h1>Joonguini Store </h1>
    <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link mx-2" href="#!"><i class="fas fa-shop pe-2"></i>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="#!"><i class="fas fa-list pe-2"></i>Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2" href="#!"><i class="fas fa-cart-shopping pe-2"></i>cart</a>
        </li>
        
        
        @if(Auth::check())
        <li class="nav-item ms-3">
          <a class="btn btn-dark btn-rounded" href="{{ route('logout') }}">Logout</a>
        </li>
        @else
        <li class="nav-item ms-3">
          <a class="btn btn-dark btn-rounded" href="{{ route('login') }}">Login</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
<!-- Navbar -->