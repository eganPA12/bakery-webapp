@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Owner Dashboard</span>
                <h1>{{ $bakery->shop_name }}</h1>
                <p class="muted">A single control room for menu changes, stock visibility, daily revenue, and live order handling.</p>
                <div class="actions">
                    <a class="button-inline" href="{{ route('orders.create') }}">Create Order</a>
                    <a class="button-inline" href="{{ route('products.create') }}">Add Product</a>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Customer Ordering Link</span>
                <p><a href="{{ route('menu.show', $bakery->qr_token) }}" target="_blank">{{ route('menu.show', $bakery->qr_token) }}</a></p>
                <p class="muted">Use this exact public URL as the destination for your QR code at the counter or on printed packaging.</p>
            </div>
        </div>
    </section>

    <section class="grid grid-4">
        <div class="stat">
            <small>Total Products</small>
            <h2>{{ $stats['products'] }}</h2>
        </div>
        <div class="stat">
            <small>Registered Customers</small>
            <h2>{{ $stats['customers'] }}</h2>
        </div>
        <div class="stat">
            <small>Orders Today</small>
            <h2>{{ $stats['orders_today'] }}</h2>
        </div>
        <div class="stat">
            <small>Revenue Ledger</small>
            <h2>Rp {{ number_format((float) $stats['revenue_ledger'], 0, ',', '.') }}</h2>
        </div>
    </section>

    <section class="grid grid-2 dashboard-panels">
        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Low Stock Watch</h2>
                    <p class="muted">Products that need attention before they run too low.</p>
                </div>
            </div>

            @if ($lowStockItems->isEmpty())
                <p class="muted">No product is below its reorder level right now.</p>
            @else
                <div class="dashboard-list">
                    @foreach ($lowStockItems as $inventory)
                        <article class="dashboard-row">
                            <div class="dashboard-main">
                                <strong>{{ $inventory->product?->name }}</strong>
                                <p class="product-copy">{{ $inventory->product?->category }}</p>
                                <div class="dashboard-details">
                                    <div class="dashboard-detail">
                                        <span class="product-label">Stock</span>
                                        <span class="product-value">{{ $inventory->quantity_on_hand }}</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Reorder Level</span>
                                        <span class="product-value">{{ $inventory->reorder_level }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="{{ route('inventories.index') }}">Manage stock</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Recent Orders</h2>
                    <p class="muted">Latest order activity with status and totals at a glance.</p>
                </div>
            </div>

            @if ($recentOrders->isEmpty())
                <p class="muted">No orders yet. Start from the Orders page.</p>
            @else
                <div class="dashboard-list">
                    @foreach ($recentOrders as $order)
                        <article class="dashboard-row">
                            <div class="dashboard-main">
                                <strong>{{ $order->order_number }}</strong>
                                <p class="product-copy">{{ $order->customer?->name ?? 'Walk-in customer' }}</p>
                                <div class="dashboard-details">
                                    <div class="dashboard-detail">
                                        <span class="product-label">Type</span>
                                        <span class="product-value">{{ strtoupper($order->order_type) }}</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Status</span>
                                        <span class="badge">{{ strtoupper($order->order_status) }}</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Total</span>
                                        <span class="product-value">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="{{ route('orders.show', $order) }}">Open order</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
