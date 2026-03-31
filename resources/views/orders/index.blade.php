@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Order Queue</span>
                <h1>Orders</h1>
                <p class="muted">Orders include both quick counter sales and customer pre-orders.</p>
            </div>
            <a class="button-inline" href="{{ route('orders.create') }}">Create Order</a>
        </div>
    </section>

    <section class="card">
        @if ($orders->isEmpty())
            <p class="muted">No orders yet.</p>
        @else
            <div class="order-list">
                @foreach ($orders as $order)
                    <article class="order-row">
                        <div class="product-main">
                            <strong>{{ $order->order_number }}</strong>
                            <p class="product-copy">{{ $order->customer?->name ?? 'Walk-in customer' }}</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Type</span>
                            <span class="product-value">{{ strtoupper($order->order_type) }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge">{{ strtoupper($order->order_status) }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Total</span>
                            <span class="product-value">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="row-actions">
                            <a href="{{ route('orders.show', $order) }}">View order</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
