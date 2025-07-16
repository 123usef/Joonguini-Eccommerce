@extends('Layout.Base')



@section('content')

<div class="container">
    <h1>Products</h1>
    <div class="row">
        @if($products->count() > 0)
        <div class="col-md-4">
            @foreach($products as $product)
            <div class="card">
                <img src="{{ Voyager::image( $product->image ) }}" alt="{{ $product->name }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->price }}</p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="col-md-12">
            <p>No products found</p>
        </div>
        @endif
    </div>


</div>

@endsection