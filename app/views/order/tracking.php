<?php include 'app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    
    <?php if (empty($data['order'])): ?>
        <div class="auth-container">
            <h2 class="text-center mb-3">Tra cứu đơn hàng</h2>
            <p class="text-center text-muted mb-3">Nhập mã đơn hàng của bạn để kiểm tra trạng thái</p>
            
            <?php if(isset($data['error'])): ?>
                <div class="alert alert-error"><?= $data['error'] ?></div>
            <?php endif; ?>

            <form action="/shop_giay/order/tracking" method="POST">
                <div class="form-group" style="display: flex; gap: 1rem;">
                    <input type="text" name="order_code" class="form-control" placeholder="VD: DO168123456" required style="flex: 1;">
                    <button type="submit" class="btn btn-primary">Tra cứu</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <?php $order = $data['order']; ?>
        <h2 class="mb-3 text-center">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code']) ?></h2>
        
        <div style="max-width: 800px; margin: 0 auto; background: var(--surface-color); padding: 2.5rem; border-radius: 12px; box-shadow: var(--shadow-sm);">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                <div>
                    <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">Trạng thái: 
                        <span style="color: <?= $order['status'] == 'Hoàn thành' ? '#0f5132' : ($order['status'] == 'Đã hủy' ? '#842029' : '#0d6efd') ?>;">
                            <?= htmlspecialchars($order['status']) ?>
                        </span>
                    </h3>
                    <p style="color: var(--text-muted);">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                </div>
                <div>
                    <strong style="font-size: 1.5rem; color: var(--primary-color);"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</strong>
                </div>
            </div>

            <div class="row" style="margin-bottom: 2rem;">
                <div class="col-md-6">
                    <h4 class="mb-2">Thông tin người nhận</h4>
                    <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['recipient_name']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['recipient_phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                    <p><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note'] ?: 'Không có') ?></p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-2">Thanh toán</h4>
                    <p><strong>Phương thức:</strong> <?= htmlspecialchars($order['payment']['payment_method'] ?? 'COD') ?></p>
                    <p><strong>Trạng thái TT:</strong> <?= htmlspecialchars($order['payment']['payment_status'] ?? 'Pending') ?></p>
                </div>
            </div>

            <h4 class="mb-3">Sản phẩm đã đặt</h4>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <?php foreach ($order['items'] as $item): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border-color); padding: 1rem; border-radius: 8px;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <img src="<?= htmlspecialchars($item['primary_image']) ?>" style="width: 60px; height: 60px; border-radius: 4px; object-fit: cover;">
                            <div>
                                <a href="/shop_giay/product/detail/<?= $item['slug'] ?>" style="font-weight: 500; font-size: 1.1rem;">
                                    <?= htmlspecialchars($item['name']) ?>
                                </a>
                                <div style="color: var(--text-muted); margin-top: 0.25rem;">Size: <?= htmlspecialchars($item['size']) ?></div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: 600;"><?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                            <div style="color: var(--text-muted);">Số lượng: <?= $item['quantity'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-3" style="padding-top: 2rem;">
                <a href="/shop_giay/home/index" class="btn btn-outline">Về trang chủ</a>
            </div>

        </div>

    <?php endif; ?>

</div>

<?php include 'app/views/layouts/footer.php'; ?>
