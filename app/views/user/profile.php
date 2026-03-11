<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary-red: #d32f2f;
        --secondary-dark: #333;
        --bg-gray: #f8f9fa;
        --border-light: #eee;
    }

    body { background-color: var(--bg-gray); }

    .profile-container { padding: 50px 0; }
    
    .profile-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 30px;
        height: 100%;
        border: 1px solid var(--border-light);
    }

    .section-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 25px;
        color: var(--secondary-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Form Styles */
    .form-group { margin-bottom: 20px; }
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #777;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1.5px solid var(--border-light);
        border-radius: 8px;
        transition: 0.3s;
        background: #fdfdfd;
    }
    .form-control:focus {
        border-color: var(--primary-red);
        outline: none;
        box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
    }
    .form-control:disabled { background-color: #f1f1f1; cursor: not-allowed; color: #999; }

    /* Order History Table */
    .order-table { width: 100%; border-collapse: collapse; }
    .order-table th {
        text-align: left;
        font-size: 0.8rem;
        color: #888;
        padding: 12px;
        border-bottom: 2px solid var(--bg-gray);
    }
    .order-table td { padding: 15px 12px; border-bottom: 1px solid var(--border-light); vertical-align: middle; }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-completed { background: #e6f4ea; color: #1e7e34; }
    .status-pending { background: #eef2ff; color: #3730a3; }
    .status-cancelled { background: #fdf2f2; color: #9b1c1c; }

    .btn-save {
        background: var(--secondary-dark);
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-save:hover { background: #000; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    .btn-detail {
        text-decoration: none;
        color: var(--primary-red);
        font-weight: 600;
        font-size: 0.85rem;
        border: 1.5px solid var(--primary-red);
        padding: 5px 12px;
        border-radius: 6px;
        transition: 0.3s;
    }
    .btn-detail:hover { background: var(--primary-red); color: #fff; }

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        border-left: 4px solid;
    }
    .alert-success { background: #e6f4ea; color: #1e7e34; border-color: #1e7e34; }
    .alert-error { background: #fdf2f2; color: #9b1c1c; border-color: #9b1c1c; }
</style>

<div class="profile-container">
    <div class="container">
        <h2 class="mb-4" style="font-weight: 800;">Tài khoản của tôi</h2>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="profile-card">
                    <h3 class="section-title">
                        <i class="fas fa-user-circle"></i> Cập nhật hồ sơ
                    </h3>
                    
                    <?php if(isset($data['success'])): ?>
                        <div class="alert alert-success"><?= $data['success'] ?></div>
                    <?php endif; ?>
                    
                    <?php if(isset($data['error'])): ?>
                        <div class="alert alert-error"><?= $data['error'] ?></div>
                    <?php endif; ?>

                    <form action="/shop_giay/user/profile" method="POST">
                        <?php $u = $data['user']; ?>
                        
                        <div class="form-group">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($u['username']) ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($u['full_name']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($u['phone'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Địa chỉ mặc định</label>
                            <textarea name="address" class="form-control" rows="3" style="resize: none;"><?= htmlspecialchars($u['address'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn-save">Lưu thay đổi</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="profile-card">
                    <h3 class="section-title">
                        <i class="fas fa-shopping-bag"></i> Lịch sử đơn hàng
                    </h3>
                    
                    <?php if (empty($data['orders'])): ?>
                        <div class="text-center py-5">
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="/shop_giay/product" class="btn-detail" style="display: inline-block; margin-top: 10px;">Mua sắm ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="order-table">
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
                                            <td class="text-muted"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                            <td style="font-weight: 600;"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                                            <td>
                                                <?php 
                                                    $statusClass = 'status-pending';
                                                    if ($order['status'] == 'Hoàn thành') $statusClass = 'status-completed';
                                                    if ($order['status'] == 'Đã hủy') $statusClass = 'status-cancelled';
                                                ?>
                                                <span class="status-badge <?= $statusClass ?>">
                                                    <?= htmlspecialchars($order['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="/shop_giay/order/tracking/<?= htmlspecialchars($order['order_code']) ?>" class="btn-detail">Chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>