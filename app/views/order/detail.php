<?php include 'app/views/layouts/header.php'; ?>

<div class="tracking-container">
    <div class="tracking-content">
        <!-- Header Section -->
        <div class="tracking-header">
            <h1 class="tracking-title">Theo dõi đơn hàng</h1>
            <p class="tracking-subtitle">Nhập mã đơn hàng để kiểm tra tình trạng vận chuyển</p>
        </div>

        <!-- Search Form -->
        <div class="tracking-search-card">
            <form action="/shop_giay/order/tracking" method="POST" class="tracking-search-form" id="trackingForm">
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="order_code" id="orderCode" 
                           value="<?= htmlspecialchars($_POST['order_code'] ?? $orderCode ?? '') ?>" 
                           placeholder="Nhập mã đơn hàng (VD: DO123456...)" required>
                    <button type="submit" class="btn-track">
                        <i class="fas fa-search"></i> Tra cứu
                    </button>
                </div>
                <?php if (isset($error)): ?>
                    <div class="track-error">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <?php if (isset($order) && $order): ?>
            <!-- Order Status Stepper -->
            <div class="status-stepper-card animate-fadeIn">
                <div class="stepper-header">
                    <div class="order-id-info">
                        <span class="label">Mã đơn hàng:</span>
                        <span class="value"><?= $order['order_code'] ?></span>
                    </div>
                    <div class="order-date-info">
                        <span class="label">Ngày đặt:</span>
                        <span class="value"><?= date('H:i - d/m/Y', strtotime($order['created_at'])) ?></span>
                    </div>
                </div>

                <div class="stepper-visual">
                    <?php 
                        $statusMap = [
                            'Pending'   => 1,
                            'Confirmed' => 2,
                            'Shipping'  => 3,
                            'Completed' => 4,
                            'Cancelled' => 0
                        ];
                        $currentStatusNum = $statusMap[$order['order_status']] ?? 1;
                        $isCancelled = $order['order_status'] === 'Cancelled';
                        
                        // Status labels in Vietnamese
                        $statusLabels = [
                            'Pending' => 'Chờ xác nhận',
                            'Confirmed' => 'Đã xác nhận',
                            'Shipping' => 'Đang giao hàng',
                            'Completed' => 'Đã giao hàng',
                            'Cancelled' => 'Đã hủy'
                        ];
                    ?>

                    <?php if (!$isCancelled): ?>
                        <!-- Pending -->
                        <div class="stepper-item <?= $currentStatusNum >= 1 ? 'active' : '' ?>">
                            <div class="step-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div class="step-label">Chờ xác nhận</div>
                            <div class="step-date">
                                <?= $currentStatusNum >= 1 ? date('d/m', strtotime($order['created_at'])) : '' ?>
                            </div>
                        </div>
                        <div class="stepper-line <?= $currentStatusNum >= 2 ? 'active' : '' ?>"></div>

                        <!-- Confirmed -->
                        <div class="stepper-item <?= $currentStatusNum >= 2 ? 'active' : '' ?>">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="step-label">Đã xác nhận</div>
                        </div>
                        <div class="stepper-line <?= $currentStatusNum >= 3 ? 'active' : '' ?>"></div>

                        <!-- Shipping -->
                        <div class="stepper-item <?= $currentStatusNum >= 3 ? 'active' : '' ?>">
                            <div class="step-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="step-label">Đang giao hàng</div>
                        </div>
                        <div class="stepper-line <?= $currentStatusNum >= 4 ? 'active' : '' ?>"></div>

                        <!-- Completed -->
                        <div class="stepper-item <?= $currentStatusNum >= 4 ? 'active' : '' ?>">
                            <div class="step-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="step-label">Đã giao hàng</div>
                        </div>
                    <?php else: ?>
                        <!-- Cancelled -->
                        <div class="stepper-item cancelled">
                            <div class="step-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="step-label">Đơn hàng đã hủy</div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Current Status Message -->
                <div class="current-status-message">
                    <i class="fas fa-info-circle"></i>
                    <span>
                        <?php if ($isCancelled): ?>
                            Đơn hàng đã bị hủy. Vui lòng liên hệ CSKH để biết thêm chi tiết.
                        <?php else: ?>
                            Đơn hàng đang ở trạng thái: 
                            <strong><?= $statusLabels[$order['order_status']] ?></strong>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <div class="tracking-grid">
                <!-- Left Column - Products & Timeline -->
                <div class="tracking-main">
                    <!-- Products List -->
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-shopping-bag"></i>
                                Sản phẩm đã mua
                            </h3>
                            <span class="item-count"><?= count($order['items']) ?> sản phẩm</span>
                        </div>
                        <div class="product-list">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="product-item">
                                    <div class="product-image">
                                        <img src="<?= htmlspecialchars($item['primary_image'] ?? '/public/images/no-image.png') ?>" 
                                             alt="<?= htmlspecialchars($item['name']) ?>">
                                    </div>
                                    <div class="product-details">
                                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                                        <div class="product-meta">
                                            <span class="variant">Size: <?= $item['size'] ?></span>
                                            <span class="variant">Màu: <?= $item['color'] ?></span>
                                        </div>
                                        <div class="product-pricing">
                                            <span class="price"><?= number_format($item['unit_price'], 0, ',', '.') ?>đ</span>
                                            <span class="quantity">x <?= $item['quantity'] ?></span>
                                            <span class="total">= <?= number_format($item['total_price'], 0, ',', '.') ?>đ</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Tạm tính:</span>
                                <span><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</span>
                            </div>
                            <?php if ($order['discount_amount'] > 0): ?>
                                <div class="summary-row discount">
                                    <span>Giảm giá:</span>
                                    <span>-<?= number_format($order['discount_amount'], 0, ',', '.') ?>đ</span>
                                </div>
                            <?php endif; ?>
                            <div class="summary-row">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="summary-row grand-total">
                                <span>Tổng thanh toán:</span>
                                <span><?= number_format($order['final_amount'], 0, ',', '.') ?>đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="info-card">
                        <h3 class="card-title">
                            <i class="fas fa-clock"></i>
                            Lịch sử đơn hàng
                        </h3>
                        <div class="timeline">
                            <?php if (!empty($order['history'])): ?>
                                <?php foreach ($order['history'] as $index => $history): ?>
                                    <div class="timeline-item <?= $index === 0 ? 'latest' : '' ?>">
                                        <div class="timeline-marker">
                                            <i class="fas fa-circle"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <span class="timeline-status <?= strtolower($history['status']) ?>">
                                                    <?= $statusLabels[$history['status']] ?? $history['status'] ?>
                                                </span>
                                                <span class="timeline-time">
                                                    <?= date('H:i', strtotime($history['created_at'])) ?>
                                                </span>
                                                <span class="timeline-date">
                                                    <?= date('d/m/Y', strtotime($history['created_at'])) ?>
                                                </span>
                                            </div>
                                            <?php if (!empty($history['note'])): ?>
                                                <p class="timeline-note"><?= htmlspecialchars($history['note']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-timeline">
                                    <i class="fas fa-clock"></i>
                                    <p>Đơn hàng đang chờ xử lý</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Delivery Info & Payment -->
                <div class="tracking-sidebar">
                    <!-- Delivery Information -->
                    <div class="info-card delivery-card">
                        <h3 class="card-title">
                            <i class="fas fa-truck"></i>
                            Thông tin giao hàng
                        </h3>
                        <div class="delivery-info">
                            <div class="info-row">
                                <i class="fas fa-user"></i>
                                <div>
                                    <span class="info-label">Người nhận</span>
                                    <span class="info-value"><?= htmlspecialchars($order['customer_name']) ?></span>
                                </div>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <span class="info-label">Số điện thoại</span>
                                    <span class="info-value"><?= htmlspecialchars($order['customer_phone']) ?></span>
                                </div>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>
                                    <span class="info-label">Địa chỉ</span>
                                    <span class="info-value"><?= htmlspecialchars($order['shipping_address']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="info-card payment-card">
                        <h3 class="card-title">
                            <i class="fas fa-credit-card"></i>
                            Thông tin thanh toán
                        </h3>
                        <div class="payment-info">
                            <div class="info-row">
                                <span class="info-label">Phương thức</span>
                                <span class="info-value">
                                    <?php 
                                        $paymentMethods = [
                                            'COD' => 'Thanh toán khi nhận hàng',
                                            'Bank Transfer' => 'Chuyển khoản ngân hàng',
                                            'QR' => 'Quét mã QR'
                                        ];
                                        echo $paymentMethods[$order['payment_method']] ?? $order['payment_method'];
                                    ?>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái</span>
                                <span class="payment-status <?= strtolower($order['payment_status']) ?>">
                                    <?= $order['payment_status'] === 'Paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Support Contact -->
                    <div class="info-card support-card">
                        <h3 class="card-title">
                            <i class="fas fa-headset"></i>
                            Hỗ trợ khách hàng
                        </h3>
                        <div class="support-info">
                            <p>Nếu bạn cần hỗ trợ về đơn hàng, vui lòng liên hệ:</p>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>1900 1234</span>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>support@dostore.vn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="tracking-actions">
                <a href="/shop_giay/product/index" class="btn-continue">
                    <i class="fas fa-arrow-left"></i>
                    Tiếp tục mua sắm
                </a>
                <button onclick="window.print()" class="btn-print">
                    <i class="fas fa-print"></i>
                    In đơn hàng
                </button>
            </div>

        <?php else: ?>
            <!-- Empty State - No order found -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-box-search"></i>
                </div>
                <h2>Chưa có thông tin đơn hàng</h2>
                <p>Vui lòng nhập mã đơn hàng để tra cứu</p>
                
                <!-- Quick Tips -->
                <div class="search-tips">
                    <h4>Mẹo tìm mã đơn hàng:</h4>
                    <ul>
                        <li><i class="fas fa-envelope"></i> Kiểm tra email xác nhận đơn hàng</li>
                        <li><i class="fas fa-sms"></i> Xem tin nhắn SMS từ Đớ Store</li>
                        <li><i class="fas fa-user"></i> Đăng nhập và xem lịch sử mua hàng</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
:root {
    --primary-red: #ef4444;
    --dark-red: #b91c1c;
    --gradient-red: linear-gradient(135deg, #ef4444, #b91c1c);
    --bg-gray: #f8fafc;
    --border-color: #e2e8f0;
}

.tracking-container {
    background-color: var(--bg-gray);
    min-height: 80vh;
    padding: 60px 20px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.tracking-content {
    max-width: 1200px;
    margin: 0 auto;
}

.tracking-header {
    text-align: center;
    margin-bottom: 40px;
}

.tracking-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
}

.tracking-subtitle {
    color: #64748b;
    font-size: 1.1rem;
}

/* Search Card */
.tracking-search-card {
    background: white;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    margin-bottom: 40px;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: #f1f5f9;
    padding: 8px;
    border-radius: 16px;
    border: 2px solid transparent;
    transition: all 0.3s;
}

.search-input-group:focus-within {
    border-color: var(--primary-red);
    background: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
}

.search-icon {
    padding: 0 20px;
    color: #94a3b8;
    font-size: 1.3rem;
}

.search-input-group input {
    flex: 1;
    border: none;
    background: none;
    padding: 16px 10px;
    font-size: 1.1rem;
    outline: none;
    font-weight: 500;
}

.btn-track {
    background: var(--gradient-red);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-track:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

.track-error {
    color: var(--primary-red);
    margin-top: 16px;
    padding: 12px;
    background: #fef2f2;
    border-radius: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Status Stepper */
.status-stepper-card {
    background: white;
    border-radius: 24px;
    padding: 35px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.stepper-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.order-id-info, .order-date-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.order-id-info .label, .order-date-info .label {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 500;
}

.order-id-info .value {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-red);
    letter-spacing: 1px;
}

.order-date-info .value {
    font-weight: 600;
    color: #334155;
}

.stepper-visual {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
}

.stepper-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    text-align: center;
}

.step-icon {
    width: 70px;
    height: 70px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: #94a3b8;
    transition: all 0.4s;
    margin-bottom: 15px;
    border: 4px solid white;
    box-shadow: 0 0 0 1px #e2e8f0;
}

.step-label {
    font-size: 1rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 5px;
}

.step-date {
    font-size: 0.85rem;
    color: #94a3b8;
}

.stepper-item.active .step-icon {
    background: var(--gradient-red);
    color: white;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    transform: scale(1.05);
}

.stepper-item.active .step-label {
    color: var(--primary-red);
    font-weight: 700;
}

.stepper-line {
    height: 4px;
    background: #f1f5f9;
    flex: 1;
    margin: 0 10px;
    transform: translateY(-25px);
    transition: all 0.4s;
}

.stepper-line.active {
    background: var(--primary-red);
}

.current-status-message {
    background: #f0f9ff;
    padding: 16px 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #0369a1;
    font-size: 1rem;
}

/* Grid Layout */
.tracking-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

/* Cards */
.info-card {
    background: white;
    border-radius: 24px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    margin-bottom: 25px;
    border: 1px solid #f1f5f9;
    transition: all 0.3s;
}

.info-card:hover {
    box-shadow: 0 15px 30px rgba(0,0,0,0.05);
    transform: translateY(-2px);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-title i {
    color: var(--primary-red);
}

.item-count {
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
}

/* Product List */
.product-list {
    margin-bottom: 20px;
}

.product-item {
    display: flex;
    gap: 15px;
    padding: 20px 0;
    border-bottom: 1px solid #f1f5f9;
}

.product-item:last-child {
    border-bottom: none;
}

.product-image {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
    flex: 1;
}

.product-details h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
}

.product-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 10px;
}

.product-meta .variant {
    font-size: 0.85rem;
    color: #64748b;
    background: #f8fafc;
    padding: 4px 10px;
    border-radius: 6px;
}

.product-pricing {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.product-pricing .price {
    font-weight: 600;
    color: var(--primary-red);
}

.product-pricing .quantity {
    color: #64748b;
}

.product-pricing .total {
    font-weight: 700;
    color: #1e293b;
}

/* Order Summary */
.order-summary {
    background: #f8fafc;
    padding: 20px;
    border-radius: 16px;
    margin-top: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    color: #475569;
}

.summary-row.discount {
    color: #10b981;
}

.summary-row.grand-total {
    margin-top: 10px;
    padding-top: 15px;
    border-top: 2px dashed #e2e8f0;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-red);
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
    display: flex;
    gap: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 20px;
    height: 20px;
    background: white;
    border: 3px solid #cbd5e1;
    border-radius: 50%;
    z-index: 1;
}

.timeline-item.latest .timeline-marker {
    border-color: var(--primary-red);
    box-shadow: 0 0 0 5px rgba(239, 68, 68, 0.1);
}

.timeline::before {
    content: '';
    position: absolute;
    left: -21px;
    top: 15px;
    bottom: 15px;
    width: 2px;
    background: #e2e8f0;
}

.timeline-content {
    flex: 1;
}

.timeline-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 5px;
    flex-wrap: wrap;
}

.timeline-status {
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
}

.timeline-status.pending { background: #fff7ed; color: #f97316; }
.timeline-status.confirmed { background: #f0fdf4; color: #16a34a; }
.timeline-status.shipping { background: #eff6ff; color: #2563eb; }
.timeline-status.completed { background: #faf5ff; color: #9333ea; }
.timeline-status.cancelled { background: #fef2f2; color: #dc2626; }

.timeline-time {
    font-weight: 600;
    color: #1e293b;
}

.timeline-date {
    color: #94a3b8;
    font-size: 0.85rem;
}

.timeline-note {
    margin-top: 8px;
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    background: #f8fafc;
    padding: 10px 15px;
    border-radius: 12px;
}

/* Delivery & Payment Info */
.delivery-info, .payment-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-row {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.info-row i {
    width: 24px;
    color: var(--primary-red);
    font-size: 1.2rem;
    margin-top: 2px;
}

.info-row > div {
    flex: 1;
}

.info-label {
    display: block;
    font-size: 0.8rem;
    color: #94a3b8;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    display: block;
    font-weight: 500;
    color: #1e293b;
    line-height: 1.5;
}

.payment-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
}

.payment-status.paid {
    background: #dcfce7;
    color: #15803d;
}

.payment-status.pending {
    background: #fef3c7;
    color: #d97706;
}

/* Support Card */
.support-card {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}

.support-info p {
    color: #475569;
    margin-bottom: 15px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: white;
    border-radius: 12px;
    margin-bottom: 10px;
    font-weight: 500;
}

.contact-item i {
    color: var(--primary-red);
}

/* Action Buttons */
.tracking-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 40px;
}

.btn-continue, .btn-print {
    padding: 14px 30px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-continue {
    background: white;
    color: #1e293b;
    border: 1px solid #e2e8f0;
}

.btn-print {
    background: var(--gradient-red);
    color: white;
}

.btn-continue:hover, .btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}

.empty-icon {
    font-size: 4rem;
    color: var(--primary-red);
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h2 {
    font-size: 1.8rem;
    color: #1e293b;
    margin-bottom: 10px;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 30px;
}

.search-tips {
    max-width: 400px;
    margin: 0 auto;
    text-align: left;
    background: #f8fafc;
    padding: 25px;
    border-radius: 20px;
}

.search-tips h4 {
    margin-bottom: 15px;
    color: #334155;
}

.search-tips ul {
    list-style: none;
    padding: 0;
}

.search-tips li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    color: #475569;
}

.search-tips li i {
    color: var(--primary-red);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out;
}

/* Responsive */
@media (max-width: 968px) {
    .tracking-grid {
        grid-template-columns: 1fr;
    }
    
    .stepper-visual {
        flex-direction: column;
        gap: 20px;
    }
    
    .stepper-line {
        width: 4px;
        height: 30px;
        margin: 10px 0;
        transform: none;
    }
    
    .tracking-actions {
        flex-direction: column;
    }
}

@media (max-width: 768px) {
    .tracking-title {
        font-size: 2rem;
    }
    
    .search-input-group {
        flex-direction: column;
        background: none;
        padding: 0;
        gap: 15px;
    }
    
    .search-input-group input {
        background: #f1f5f9;
        border-radius: 12px;
        width: 100%;
    }
    
    .btn-track {
        width: 100%;
        justify-content: center;
    }
    
    .stepper-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    
    .product-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .product-image {
        width: 100%;
        height: 200px;
    }
}
</style>

<?php include 'app/views/layouts/footer.php'; ?>