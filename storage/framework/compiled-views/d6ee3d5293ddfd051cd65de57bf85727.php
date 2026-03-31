<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Order Detail</span>
                <h1><?php echo e($order->order_number); ?></h1>
                <p class="muted">
                    <?php echo e(strtoupper($order->order_type)); ?> order for <?php echo e($order->customer?->name ?? 'Walk-in customer'); ?>

                </p>
                <div class="actions">
                    <span class="badge badge-hero"><?php echo e(strtoupper($order->order_status)); ?></span>
                    <span class="badge badge-hero">Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></span>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Quick Snapshot</span>
                <p><strong>Items:</strong> <?php echo e($order->items->sum('quantity')); ?></p>
                <p><strong>Platform Fee:</strong> Rp <?php echo e(number_format((float) $order->platform_fee, 0, ',', '.')); ?></p>
                <p><strong>Pickup:</strong> <?php echo e($order->pickup_time?->format('d M Y H:i') ?? 'Not scheduled'); ?></p>
            </div>
        </div>
    </section>

    <section class="detail-grid">
        <div class="card stack">
            <h2>Order Summary</h2>
            <div class="summary-list">
                <div class="summary-row">
                    <div class="summary-key">Type</div>
                    <div class="summary-value"><?php echo e(strtoupper($order->order_type)); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Status</div>
                    <div class="summary-value"><?php echo e(strtoupper($order->order_status)); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Customer</div>
                    <div class="summary-value"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Ordered At</div>
                    <div class="summary-value"><?php echo e($order->ordered_at?->format('d M Y H:i')); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Pickup Time</div>
                    <div class="summary-value"><?php echo e($order->pickup_time?->format('d M Y H:i') ?? '-'); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Expires At</div>
                    <div class="summary-value"><?php echo e($order->expires_at?->format('d M Y H:i') ?? '-'); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Platform Fee</div>
                    <div class="summary-value">Rp <?php echo e(number_format((float) $order->platform_fee, 0, ',', '.')); ?></div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Notes</div>
                    <div class="summary-value"><?php echo e($order->notes ?: '-'); ?></div>
                </div>
            </div>
        </div>

        <aside class="card status-panel">
            <div>
                <h2>Status Actions</h2>
                <p class="muted">Use these controls to move the order through the bakery workflow.</p>
            </div>

            <div class="status-current">
                <h3>Current Status</h3>
                <div class="actions">
                    <span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span>
                    <span class="badge"><?php echo e(strtoupper($order->order_type)); ?></span>
                </div>
            </div>

            <?php if(! in_array($order->order_status, ['completed', 'expired'], true)): ?>
                <div class="action-grid">
                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="baking">
                        <button class="button-inline" type="submit">Mark Baking</button>
                    </form>

                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="ready">
                        <button class="button-inline" type="submit">Mark Ready</button>
                    </form>

                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="completed">
                        <button class="button-inline" type="submit">Mark Completed</button>
                    </form>

                    <?php if($order->order_type === 'preorder'): ?>
                        <form action="<?php echo e(route('orders.expire', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="button-inline button-secondary" type="submit">Expire & Return Stock</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="surface-note">
                    This order is already finished, so no more status changes are available.
                </div>
            <?php endif; ?>
        </aside>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Ordered Items</h2>
        <div class="item-list">
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="item-row">
                    <div class="product-main">
                        <strong><?php echo e($item->product?->name); ?></strong>
                        <p class="product-copy"><?php echo e($item->product?->category ?? 'Bakery item'); ?></p>
                    </div>

                    <div class="product-meta">
                        <span class="product-label">Quantity</span>
                        <span class="product-value"><?php echo e($item->quantity); ?></span>
                    </div>

                    <div class="product-meta">
                        <span class="product-label">Unit Price</span>
                        <span class="product-value">Rp <?php echo e(number_format((float) $item->unit_price, 0, ',', '.')); ?></span>
                    </div>

                    <div class="item-highlight">
                        <div class="product-label">Subtotal</div>
                        <div class="product-value">Rp <?php echo e(number_format((float) $item->subtotal_item, 0, ',', '.')); ?></div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/orders/show.blade.php ENDPATH**/ ?>