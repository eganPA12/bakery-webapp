@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Customer Directory</span>
                <h1>Customers</h1>
                <p class="muted">Customers can come from manual owner input or from public pre-orders.</p>
            </div>
            <a class="button-inline" href="{{ route('customers.create') }}">Add Customer</a>
        </div>
    </section>

    <section class="card">
        @if ($customers->isEmpty())
            <p class="muted">No customers yet.</p>
        @else
            <div class="customer-list">
                @foreach ($customers as $customer)
                    <article class="customer-row">
                        <div class="product-main">
                            <strong>{{ $customer->name }}</strong>
                            <p class="product-copy">Registered bakery customer</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Email</span>
                            <span class="product-value">{{ $customer->email ?: '-' }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Phone</span>
                            <span class="product-value">{{ $customer->phone ?: '-' }}</span>
                        </div>

                        <div class="row-actions">
                            <a href="{{ route('customers.edit', $customer) }}">Edit customer</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
