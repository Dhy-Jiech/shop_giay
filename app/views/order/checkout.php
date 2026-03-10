<?php include 'app/views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-3">Thanh toán</h2>

    <?php if(isset($data['error'])): ?>
        <div class="alert alert-error"><?= $data['error'] ?></div>
    <?php endif; ?>

    <div class="row" style="gap: 2rem; align-items: flex-start;">
        <!-- Checkout Form -->
        <div style="flex: 2; background: var(--surface-color); padding: 2rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
            <h3 class="mb-3" style="color: var(--primary-color);">Thông tin nhận hàng</h3>
            <form action="/shop_giay/order/checkout" method="POST">
                
                <div class="form-group">
                    <label class="form-label" for="recipient_name">Họ và tên người nhận</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="form-control" value="<?= htmlspecialchars($data['user']['full_name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="recipient_phone">Số điện thoại</label>
                    <input type="text" id="recipient_phone" name="recipient_phone" class="form-control" value="<?= htmlspecialchars($data['user']['phone'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="shipping_address">Địa chỉ giao hàng</label>
                    <input type="text" id="shipping_address" name="shipping_address" class="form-control" value="<?= htmlspecialchars($data['user']['address'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="note">Ghi chú đơn hàng (Tùy chọn)</label>
                    <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                </div>

                <h3 class="mb-3 mt-3" style="color: var(--primary-color);">Phương thức thanh toán</h3>
                
                <div class="form-group" style="display: flex; gap: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="payment_method" value="COD" checked> Thanh toán khi nhận hàng (COD)
                    </label>
                    
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="payment_method" value="Bank Transfer"> Chuyển khoản ngân hàng
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem;">Đặt hàng</button>

            </form>
        </div>

        <!-- Order Summary side -->
        <div style="flex: 1; background: var(--surface-color); padding: 2rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
            <h3 class="mb-3">Đơn hàng của bạn</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                <?php foreach ($data['items'] as $item): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <img src="<?= htmlspecialchars($item['primary_image']) ?>" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;">
                            <div>
                                <div style="font-weight: 500;"><?= htmlspecialchars($item['name']) ?></div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">Size: <?= htmlspecialchars($item['size']) ?> x <?= $item['quantity'] ?></div>
                            </div>
                        </div>
                        <div style="font-weight: 600;">
                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span>Tạm tính:</span>
                    <strong><?= number_format($data['total'], 0, ',', '.') ?>đ</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem;">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.25rem;">
                    <span><strong>Tổng cộng:</strong></span>
                    <strong style="color: var(--primary-color);"><?= number_format($data['total'], 0, ',', '.') ?>đ</strong>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
