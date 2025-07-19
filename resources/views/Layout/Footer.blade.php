<footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/pic.png') }}" alt="Joonguini Store" height="40" class="me-2">
                    <h5 class="mb-0">Joonguini Store</h5>
                </div>
                <p class="text-muted mb-0">Your trusted online marketplace for quality products at affordable prices.</p>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('index') }}" class="text-light text-decoration-none">Home</a></li>
                    <li><a href="{{ route('products') }}" class="text-light text-decoration-none">Products</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-light text-decoration-none">Cart</a></li>
                    @auth
                    <li><a href="#" class="text-light text-decoration-none">My Account</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="text-light text-decoration-none">Login</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-uppercase fw-bold mb-3">Support</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('privacy-policy') }}" class="text-light text-decoration-none">Privacy Policy</a></li>
                    <li><a href="{{ route('terms-of-service') }}" class="text-light text-decoration-none">Terms of Service</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                    <li><a href="#" class="text-light text-decoration-none">FAQ</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Joonguini Store. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-flex justify-content-md-end justify-content-center">
                    <a href="#" class="text-light me-3" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-light me-3" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-light me-3" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-light" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>