@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Menu Management</span>
                <h1>Products</h1>
                <p class="muted">Manage bakery menu items and selling prices here.</p>
            </div>
            <a class="button-inline" href="{{ route('products.create') }}">Add Product</a>
        </div>
    </section>

    <section class="card">
        @if ($products->isEmpty())
            <p class="muted">No products yet. Start by adding the first menu item.</p>
        @else
            <div class="product-list">
                @foreach ($products as $product)
                    <article class="product-row">
                        <div class="product-main">
                            <strong>{{ $product->name }}</strong>
                            <p class="product-copy">{{ $product->description ?: 'No product description yet.' }}</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Category</span>
                            <span class="product-value">{{ $product->category }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Price</span>
                            <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Stock</span>
                            <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                        </div>

                        <div class="product-actions">
                            <div class="stack-tight" style="justify-items: end;">
                                <span class="badge {{ $product->is_active ? '' : 'badge-muted' }}">{{ $product->is_active ? 'ACTIVE' : 'HIDDEN' }}</span>
                                <a href="{{ route('products.edit', $product) }}">Edit product</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
