<!-- Enhanced Navbar with Modern Design -->
<nav class="navbar navbar-expand-lg sticky-top navbar-light shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-bottom: 3px solid #667eea;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
        <img src="{{ asset('images/pic.png') }}" alt="Joonguini Store Logo" class="me-2" height="45" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));" />
        <span class="fw-bold" style="font-size: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Joonguini Store</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link mx-2 px-3 rounded-pill nav-hover" href="{{ route('index') }}"><i class="fas fa-home pe-2"></i>Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2 px-3 rounded-pill nav-hover" href="{{ route('products') }}"><i class="fas fa-shop pe-2"></i>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mx-2 px-3 rounded-pill nav-hover" href="{{ route('categories') }}"><i class="fas fa-list pe-2"></i>Categories</a>
        </li>
        <!-- Cart Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mx-2 px-3 rounded-pill nav-hover position-relative" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cart-shopping pe-2"></i>Cart
            <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill" style="font-size: 0.7rem;">{{ $cartCount ?? 0 }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="cartDropdown" style="width: 400px; max-height: 500px; overflow-y: auto;">
            <div class="dropdown-header d-flex justify-content-between align-items-center">
              <h6 class="mb-0">Shopping Cart</h6>
              <button class="btn btn-sm btn-outline-danger" onclick="clearCart()" title="Clear Cart">
                <i class="fas fa-trash"></i>
              </button>
            </div>
            <div id="cart-items-container">
              <div class="text-center p-3">
                <div class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mb-0 mt-2 text-muted">Loading cart...</p>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-footer p-3">
              <div class="d-flex justify-content-between mb-2">
                <strong>Total: <span id="cart-total">$0.00</span></strong>
              </div>
              <div class="d-grid gap-2">
                <button class="btn btn-primary btn-sm" onclick="proceedToCheckout()">
                  <i class="fas fa-credit-card me-1"></i>Checkout
                </button>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-sm">
                  <i class="fas fa-shopping-cart me-1"></i>View Full Cart
                </a>
              </div>
            </div>
          </div>
        </li>
        
        
        @auth
        <!-- User Dropdown -->
        <li class="nav-item dropdown ms-3">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 rounded-pill nav-hover" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
              <i class="fas fa-user text-white" style="font-size: 0.9rem;"></i>
            </div>
            <span class="fw-medium">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
            <li>
              <div class="dropdown-header">
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <small class="text-muted">{{ Auth::user()->email }}</small>
              </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="#!">
                <i class="fas fa-user me-2"></i>Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('orders.index') }}">
                <i class="fas fa-box me-2"></i>My Orders
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#!">
                <i class="fas fa-heart me-2"></i>Wishlist
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#!">
                <i class="fas fa-cog me-2"></i>Settings
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <!-- Guest Navigation -->
        <li class="nav-item ms-2">
          <a class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 btn-hover" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt me-1"></i>Login
          </a>
        </li>
        <li class="nav-item ms-2">
          <a class="btn btn-sm rounded-pill px-4 py-2 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;" href="{{ route('register') }}">
            <i class="fas fa-user-plus me-1"></i>Sign Up
          </a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
<!-- Navbar -->