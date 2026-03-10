<?php include 'app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <h2 class="mb-3" style="color: var(--primary-color);">Tài khoản của tôi</h2>

    <div class="row" style="gap: 2rem; align-items: flex-start;">
        <!-- Profile Form -->
        <div style="flex: 1; background: var(--surface-color); padding: 2rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
            <h3 class="mb-3">Cập nhật thông tin</h3>
            
            <?php if(isset($data['success'])): ?>
                <div class="alert alert-success"><?= $data['success'] ?></div>
            <?php endif; ?>
            
            <?php if(isset($data['error'])): ?>
                <div class="alert alert-error"><?= $data['error'] ?></div>
            <?php endif; ?>

            <form action="/shop_giay/user/profile" method="POST">
                <?php $u = $data['user']; ?>
                
                <div class="form-group">
                    <label class="form-label" for="username">Tên đăng nhập (Không thể đổi)</label>
                    <input type="text" id="username" class="form-control" value="<?= htmlspecialchars($u['username']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label" for="full_name">Họ và tên</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($u['full_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($u['phone'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Địa chỉ mặc định</label>
                    <textarea id="address" name="address" class="form-control" rows="3"><?= htmlspecialchars($u['address'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Lưu thay đổi</button>
            </form>
        </div>

        <!-- Order History -->
        <div style="flex: 2; background: var(--surface-color); padding: 2rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
            <h3 class="mb-3">Lịch sử đơn hàng</h3>
            
            <?php if (empty($data['orders'])): ?>
                <p>Bạn chưa có đơn hàng nào.</p>
                <a href="/shop_giay/product/index" class="btn btn-outline mt-3">Mua sắm ngay</a>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Đặt</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['orders'] as $order): ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($order['order_code']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                <td><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <span style="font-weight: 500; color: <?= $order['status'] == 'Hoàn thành' ? '#0f5132' : ($order['status'] == 'Đã hủy' ? '#842029' : '#0d6efd') ?>;">
                                        <?= htmlspecialchars($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/shop_giay/order/tracking/<?= htmlspecialchars($order['order_code']) ?>" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.85rem;">Xem chi tiết</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
