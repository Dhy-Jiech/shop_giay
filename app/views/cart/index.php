<?php include 'app/views/layouts/header.php'; ?>

<div class="container">
    <h2 class="mb-3" style="color: var(--primary-color);">Giỏ hàng của bạn</h2>

    <?php if (empty($data['items'])): ?>
        <div class="auth-container text-center">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Giỏ hàng của bạn đang trống.</p>
            <a href="/shop_giay/product/index" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="row" style="gap: 2rem; align-items: flex-start;">
            <div style="flex: 2;">
                <table style="background: var(--surface-color); border-radius: 8px; box-shadow: var(--shadow-sm);">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th style="width: 150px;">Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['items'] as $item): ?>
                            <tr>
                                <td style="display: flex; gap: 1rem; align-items: center;">
                                    <img src="<?= htmlspecialchars($item['primary_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    <div>
                                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                                        <div style="font-size: 0.9rem; color: var(--text-muted);">Size: <?= htmlspecialchars($item['size']) ?></div>
                                    </div>
                                </td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <form action="/shop_giay/cart/update" method="POST" style="display: flex; gap: 0.5rem;">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="padding: 0.25rem 0.5rem; text-align: center;">
                                        <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem; border-radius: 4px;">↻</button>
                                    </form>
                                </td>
                                <td><strong><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</strong></td>
                                <td>
                                    <a href="/shop_giay/cart/remove/<?= $item['product_id'] ?>" style="color: #dc3545; font-size: 1.2rem; font-weight: bold;" title="Xóa">✕</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="flex: 1; background: var(--surface-color); padding: 2rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
                <h3 class="mb-3">Tóm tắt đơn hàng</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Tạm tính:</span>
                    <strong><?= number_format($data['total'], 0, ',', '.') ?>đ</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem;">
                    <span><strong>Tổng cộng:</strong></span>
                    <strong style="color: var(--primary-color);"><?= number_format($data['total'], 0, ',', '.') ?>đ</strong>
                </div>
                
                <a href="/shop_giay/order/checkout" class="btn btn-primary" style="display: block; width: 100%;">Tiến hành thanh toán</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
