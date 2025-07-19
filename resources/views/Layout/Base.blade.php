<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="d-flex flex-column min-vh-100">
                <!-- Nav Bar Include  -->
                @include('Layout.Navbar')

                <!-- Main Content Wrapper -->
                <main class="flex-grow-1 pb-4">
                    @yield('content')
                </main>

                <!-- Footer Include  -->
                @include('Layout.Footer')

                <!-- Scripts -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
                
                <!-- Cart JavaScript Functions -->
                <script>
                // Setup CSRF token for all AJAX requests
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Cart operations object
                const Cart = {
                    // Add product to cart
                    add: function(productId, quantity = 1) {
                        return fetch('/api/cart/add', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                        .then(response => {
                            console.log('Add to cart response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Add to cart data:', data);
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                                this.showMessage(data.message, 'success');
                            } else {
                                this.showMessage(data.message, 'error');
                            }
                            return data;
                        })
                        .catch(error => {
                            console.error('Add to cart error:', error);
                            this.showMessage('An error occurred while adding to cart. Please try again.', 'error');
                        });
                    },

                    // Remove product from cart
                    remove: function(productId) {
                        return fetch('/api/cart/remove', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                                this.showMessage(data.message, 'success');
                            } else {
                                this.showMessage(data.message, 'error');
                            }
                            return data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.showMessage('An error occurred while removing from cart', 'error');
                        });
                    },

                    // Update product quantity in cart
                    update: function(productId, quantity) {
                        return fetch('/api/cart/update', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                                this.showMessage(data.message, 'success');
                            } else {
                                this.showMessage(data.message, 'error');
                            }
                            return data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.showMessage('An error occurred while updating cart', 'error');
                        });
                    },

                    // Get cart count
                    getCount: function() {
                        return fetch('/api/cart/count', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                            }
                            return data;
                        });
                    },

                    // Clear entire cart
                    clear: function() {
                        return fetch('/api/cart/clear', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                                this.showMessage(data.message, 'success');
                            } else {
                                this.showMessage(data.message, 'error');
                            }
                            return data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.showMessage('An error occurred while clearing cart', 'error');
                        });
                    },

                    // Update cart count badge in navbar
                    updateCartCount: function(count) {
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = count;
                            
                            // Hide badge if count is 0
                            if (count === 0) {
                                cartCountElement.style.display = 'none';
                            } else {
                                cartCountElement.style.display = 'inline';
                            }
                        }
                    },

                    // Show success/error messages
                    showMessage: function(message, type) {
                        // Create alert element
                        const alertDiv = document.createElement('div');
                        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
                        alertDiv.style.top = '20px';
                        alertDiv.style.right = '20px';
                        alertDiv.style.zIndex = '9999';
                        alertDiv.style.minWidth = '300px';
                        
                        alertDiv.innerHTML = `
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        
                        // Add to page
                        document.body.appendChild(alertDiv);
                        
                        // Auto remove after 3 seconds
                        setTimeout(() => {
                            if (alertDiv.parentNode) {
                                alertDiv.remove();
                            }
                        }, 3000);
                    },

                    // Get cart with products for dropdown
                    getCartData: function() {
                        return fetch('/api/cart/get', {
                            method: 'GET',
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.updateCartCount(data.cart_count);
                                this.updateCartDropdown(data.cart_items, data.cart_total);
                            }
                            return data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.showMessage('An error occurred while loading cart', 'error');
                        });
                    },

                    // Update cart dropdown content
                    updateCartDropdown: function(cartItems, cartTotal) {
                        const container = document.getElementById('cart-items-container');
                        const totalElement = document.getElementById('cart-total');
                        
                        if (!container || !totalElement) return;
                        
                        // Update total
                        totalElement.textContent = `${cartTotal} OMR`;
                        
                        // Update items
                        if (cartItems.length === 0) {
                            container.innerHTML = `
                                <div class="text-center p-4">
                                    <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Your cart is empty</p>
                                </div>
                            `;
                        } else {
                            let itemsHtml = '';
                            cartItems.forEach(item => {
                                itemsHtml += `
                                    <div class="dropdown-item-text p-3 border-bottom" id="cart-item-${item.product.id}">
                                        <div class="row align-items-center">
                                            <div class="col-3">
                                                <img src="${item.product.image_url}" alt="${item.product.name}" 
                                                     class="img-fluid rounded" style="height: 50px; width: 50px; object-fit: cover;">
                                            </div>
                                            <div class="col-6">
                                                <div class="small fw-bold">${item.product.name}</div>
                                                <div class="small text-muted">${item.product.formatted_price}</div>
                                                <div class="small text-primary">Qty: ${item.quantity}</div>
                                            </div>
                                            <div class="col-3 text-end">
                                                <div class="small fw-bold mb-1">${item.subtotal.toFixed(3)} OMR</div>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.product.id}, ${item.quantity - 1})" title="Decrease">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateCartQuantity(${item.product.id}, ${item.quantity + 1})" title="Increase">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${item.product.id})" title="Remove">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            container.innerHTML = itemsHtml;
                        }
                    }
                };

                // Global functions for dropdown cart operations
                function updateCartQuantity(productId, quantity) {
                    if (quantity <= 0) {
                        removeFromCart(productId);
                        return;
                    }
                    
                    Cart.update(productId, quantity).then(data => {
                        if (data.success) {
                            Cart.getCartData(); // Refresh dropdown
                        }
                    });
                }

                function removeFromCart(productId) {
                    Cart.remove(productId).then(data => {
                        if (data.success) {
                            Cart.getCartData(); // Refresh dropdown
                        }
                    });
                }

                function clearCart() {
                    if (confirm('Are you sure you want to clear your entire cart?')) {
                        Cart.clear().then(data => {
                            if (data.success) {
                                Cart.getCartData(); // Refresh dropdown
                            }
                        });
                    }
                }

                function proceedToCheckout() {
                    @auth
                        // Redirect to checkout page
                        window.location.href = '/checkout';
                    @else
                        // Redirect to login page
                        window.location.href = '/login';
                    @endauth
                }

                // Load cart count on page load
                document.addEventListener('DOMContentLoaded', function() {
                    Cart.getCount();
                    
                    // Load cart data when dropdown is opened
                    const cartDropdown = document.getElementById('cartDropdown');
                    if (cartDropdown) {
                        cartDropdown.addEventListener('click', function(e) {
                            e.preventDefault();
                            Cart.getCartData();
                        });
                    }
                });

                // Add to cart button click handler
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-to-cart-btn') || e.target.closest('.add-to-cart-btn')) {
                        e.preventDefault();
                        
                        const button = e.target.classList.contains('add-to-cart-btn') ? e.target : e.target.closest('.add-to-cart-btn');
                        const productId = button.getAttribute('data-product-id');
                        const quantity = button.getAttribute('data-quantity') || 1;
                        
                        if (productId) {
                            // Disable button during request
                            button.disabled = true;
                            const originalText = button.innerHTML;
                            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                            
                            Cart.add(productId, quantity).then(data => {
                                if (data.success) {
                                    Cart.getCartData(); // Refresh dropdown
                                }
                            }).finally(() => {
                                // Re-enable button
                                button.disabled = false;
                                button.innerHTML = originalText;
                            });
                        }
                    }
                });
                </script>
                
                @stack('scripts')
    </body>
</html>
