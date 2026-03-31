@extends('layouts.app')

@section('content')
    <section class="hero">
        <span class="eyebrow">Stock Control</span>
        <h1>Inventory</h1>
        <p class="muted">This page manages stock quantities and reorder levels for each product.</p>
    </section>

    <section class="card">
        @if ($inventories->isEmpty())
            <p class="muted">Inventory will appear after you create products.</p>
        @else
            <div class="inventory-list">
                @foreach ($inventories as $inventory)
                    <article class="inventory-row">
                        <div class="product-main">
                            <strong>{{ $inventory->product?->name }}</strong>
                            <p class="product-copy">{{ $inventory->product?->category }}</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Current Stock</span>
                            <span class="product-value">{{ $inventory->quantity_on_hand }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Reorder Level</span>
                            <span class="product-value">{{ $inventory->reorder_level }}</span>
                        </div>

                        <div>
                            <form action="{{ route('inventories.update', $inventory) }}" method="POST" class="inventory-form">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="quantity_on_hand_{{ $inventory->id }}">Stock</label>
                                    <input id="quantity_on_hand_{{ $inventory->id }}" name="quantity_on_hand" type="number" min="0" value="{{ $inventory->quantity_on_hand }}" required>
                                </div>
                                <div>
                                    <label for="reorder_level_{{ $inventory->id }}">Reorder</label>
                                    <input id="reorder_level_{{ $inventory->id }}" name="reorder_level" type="number" min="0" value="{{ $inventory->reorder_level }}" required>
                                </div>
                                <div class="inventory-button">
                                    <button class="button-inline" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
