<?php include 'app/views/layouts/header.php'; ?>

<style>
:root {
    --primary-red: #ff4757;
    --primary-red-dark: #ff6b81;
    --gradient-red: linear-gradient(135deg, var(--primary-red), var(--primary-red-dark));
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
    --shadow-md: 0 5px 20px rgba(0,0,0,0.08);
    --shadow-lg: 0 10px 30px rgba(255,71,87,0.15);
    --border-radius: 16px;
}

.checkout-page {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 2rem 0;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Checkout Form */
.checkout-form {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-md);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #333;
}

.section-title i {
    color: var(--primary-red);
    font-size: 1.2rem;
}

.form-group {
    margin-bottom: 1.2rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #555;
    font-size: 0.95rem;
}

.form-group label i {
    margin-right: 5px;
    color: var(--primary-red);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-red);
    outline: none;
    box-shadow: 0 0 0 3px rgba(255,71,87,0.1);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

/* Payment Methods */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.payment-method {
    position: relative;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-method:hover {
    border-color: var(--primary-red);
}

.payment-method.selected {
    border-color: var(--primary-red);
    background: #fff5f6;
}

.payment-method input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.payment-method label {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    cursor: pointer;
    margin: 0;
}

.payment-icon {
    width: 50px;
    height: 50px;
    background: #f0f0f0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 1.5rem;
    color: var(--primary-red);
}

.payment-info {
    flex: 1;
}

.payment-info h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 5px 0;
    color: #333;
}

.payment-info p {
    font-size: 0.85rem;
    color: #999;
    margin: 0;
}

.payment-check {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.payment-method.selected .payment-check {
    background: var(--primary-red);
    border-color: var(--primary-red);
}

/* QR Code Section */
.qr-section {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    display: none;
}

.qr-section.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

.qr-code {
    margin: 20px auto;
    width: 250px;
    height: 250px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.qr-code img {
    max-width: 100%;
    max-height: 100%;
}

.qr-amount {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-red);
    margin: 15px 0;
}

.qr-note {
    color: #666;
    font-size: 0.9rem;
    margin: 10px 0;
}

.qr-status {
    display: inline-block;
    padding: 10px 20px;
    background: #fff3cd;
    color: #856404;
    border-radius: 30px;
    font-size: 0.9rem;
    margin-top: 15px;
}

/* Order Summary */
.order-summary {
    background: white;
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 100px;
}

.summary-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.summary-items {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 1.5rem;
}

.summary-item {
    display: flex;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.item-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.item-variant {
    font-size: 0.8rem;
    color: #999;
    margin-bottom: 5px;
}

.item-price {
    display: flex;
    justify-content: space-between;
    color: #666;
    font-size: 0.9rem;
}

/* Promo Code Section */
.promo-section {
    background: #f8f9fa;
    padding: 1.2rem;
    border-radius: 12px;
    margin: 1rem 0;
}

.promo-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.promo-input-group input {
    flex: 1;
    padding: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.95rem;
}

.promo-input-group button {
    padding: 12px 20px;
    background: var(--gradient-red);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.promo-input-group button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.promo-input-group button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.promo-message {
    font-size: 0.9rem;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.promo-message.success {
    color: #28a745;
}

.promo-message.error {
    color: #dc3545;
}

.promo-list {
    margin-top: 15px;
    border-top: 1px dashed #ddd;
    padding-top: 15px;
}

.promo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.promo-item .promo-code {
    font-weight: 600;
    color: var(--primary-red);
}

.promo-item .promo-desc {
    font-size: 0.85rem;
    color: #666;
}

.promo-item .promo-value {
    font-weight: 600;
    color: #28a745;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    font-size: 1rem;
}

.summary-row.discount {
    color: #28a745;
}

.summary-row.total {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-red);
    border-top: 2px solid #f0f0f0;
    margin-top: 10px;
    padding-top: 15px;
}

.btn-checkout {
    width: 100%;
    padding: 15px;
    background: var(--gradient-red);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1.5rem;
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,71,87,0.4);
}

.btn-checkout:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

/* Loading Spinner */
.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 968px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
    
    .order-summary {
        position: static;
    }
}
</style>

<div class="checkout-page">
    <div class="checkout-container">
        <!-- Checkout Form -->
        <div class="checkout-form">
            <?php if (isset($errors) && !empty($errors)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <?php foreach ($errors as $error): ?>
                            <p style="margin: 0;"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
                </div>
            <?php endif; ?>

            <form id="checkoutForm" method="POST" action="/shop_giay/order/checkout">
                <!-- Thông tin người nhận -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Thông tin người nhận
                    </h3>
                    
                    <div class="form-group">
                        <label><i class="fas fa-user-circle"></i> Họ và tên *</label>
                        <input type="text" name="recipient_name" class="form-control" 
                               value="<?= htmlspecialchars($user['full_name'] ?? $_POST['recipient_name'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-phone"></i> Số điện thoại *</label>
                        <input type="tel" name="recipient_phone" class="form-control" 
                               value="<?= htmlspecialchars($user['phone'] ?? $_POST['recipient_phone'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Địa chỉ nhận hàng *</label>
                        <textarea name="shipping_address" class="form-control" required><?= htmlspecialchars($user['address'] ?? $_POST['shipping_address'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-sticky-note"></i> Ghi chú (không bắt buộc)</label>
                        <textarea name="note" class="form-control"><?= htmlspecialchars($_POST['note'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Mã khuyến mãi -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-tag"></i>
                        Mã khuyến mãi
                    </h3>
                    
                    <div class="promo-section">
                        <div class="promo-input-group">
                            <input type="text" id="promoCode" placeholder="Nhập mã khuyến mãi">
                            <button type="button" onclick="applyPromo()" id="applyPromoBtn">Áp dụng</button>
                        </div>
                        <div id="promoMessage" class="promo-message"></div>
                        
                        <!-- Danh sách mã khuyến mãi đang có -->
                        <?php if (!empty($promotions)): ?>
                        <div class="promo-list">
                            <p style="font-weight: 600; margin-bottom: 10px;">Mã khuyến mãi hiện có:</p>
                            <?php foreach ($promotions as $promo): ?>
                            <div class="promo-item">
                                <div>
                                    <span class="promo-code"><?= $promo['code'] ?></span>
                                    <span class="promo-desc"> - <?= $promo['name'] ?></span>
                                </div>
                                <span class="promo-value">
                                    <?php if ($promo['discount_type'] == 'Percent'): ?>
                                        -<?= $promo['discount_value'] ?>%
                                    <?php else: ?>
                                        -<?= number_format($promo['discount_value'], 0, ',', '.') ?>đ
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Phương thức thanh toán -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-credit-card"></i>
                        Phương thức thanh toán
                    </h3>

                    <div class="payment-methods">
                        <!-- Thanh toán COD -->
                        <div class="payment-method <?= ($_POST['payment_method'] ?? 'COD') == 'COD' ? 'selected' : '' ?>" onclick="selectPayment('COD')">
                            <input type="radio" name="payment_method" id="payment_cod" value="COD" 
                                   <?= ($_POST['payment_method'] ?? 'COD') == 'COD' ? 'checked' : '' ?> required>
                            <label for="payment_cod">
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Thanh toán khi nhận hàng (COD)</h4>
                                    <p>Chỉ thanh toán khi bạn nhận được sản phẩm</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>

                        <!-- Thanh toán chuyển khoản QR -->
                        <div class="payment-method <?= ($_POST['payment_method'] ?? '') == 'QR' ? 'selected' : '' ?>" onclick="selectPayment('QR')">
                            <input type="radio" name="payment_method" id="payment_qr" value="QR"
                                   <?= ($_POST['payment_method'] ?? '') == 'QR' ? 'checked' : '' ?>>
                            <label for="payment_qr">
                                <div class="payment-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="payment-info">
                                    <h4>Quét mã QR - Chuyển khoản</h4>
                                    <p>Thanh toán nhanh qua ứng dụng ngân hàng</p>
                                </div>
                                <div class="payment-check">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Nút thanh toán cho COD -->
                <button type="submit" id="submitBtn" class="btn-checkout" style="display: block;">
                    <i class="fas fa-check-circle"></i>
                    Xác nhận đặt hàng
                </button>
            </form>

            <!-- QR Payment Section -->
            <div id="qrSection" class="qr-section">
                <h3 style="margin-bottom: 1rem;">Quét mã QR để thanh toán</h3>
                
                <div class="qr-code">
                    <img src="/shop_giay/public/images/qr-payment.png" alt="QR Code" onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=DO<?= time() ?>-<?= $total ?>'">
                </div>

                <div class="qr-amount">
                    <?= number_format($finalTotal ?? $total, 0, ',', '.') ?>đ
                </div>

                <div class="qr-note">
                    <i class="fas fa-info-circle"></i>
                    Sử dụng ứng dụng ngân hàng để quét mã QR
                </div>

                <div class="qr-note">
                    <strong>Nội dung chuyển khoản:</strong><br>
                    DO<?= time() ?> - <?= $user['full_name'] ?? 'KH' ?>
                </div>

                <div id="qrStatus" class="qr-status">
                    <i class="fas fa-spinner fa-spin"></i>
                    Đang chờ thanh toán...
                </div>

                <button onclick="checkQRPayment()" class="btn-checkout" style="margin-top: 1rem;">
                    <i class="fas fa-sync-alt"></i>
                    Đã thanh toán xong
                </button>

                <button onclick="cancelQR()" class="btn-checkout" style="background: #6c757d; margin-top: 0.5rem;">
                    <i class="fas fa-times"></i>
                    Hủy
                </button>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="summary-title">
                <i class="fas fa-shopping-bag"></i>
                Đơn hàng của bạn
            </h3>

            <div class="summary-items">
                <?php if (!empty($items) && is_array($items)): ?>
                    <?php foreach ($items as $item): ?>
                    <div class="summary-item">
                        <div class="item-image">
                            <img src="<?= htmlspecialchars($item['image'] ?? '/public/images/no-image.png') ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>">
                        </div>
                        <div class="item-details">
                            <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="item-variant">
                                <?php if (isset($item['size'])): ?>
                                    Size: <?= $item['size'] ?><br>
                                <?php endif; ?>
                                <?php if (isset($item['color'])): ?>
                                    Màu: <?= $item['color'] ?>
                                <?php endif; ?>
                            </div>
                            <div class="item-price">
                                <span><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                                <span>x<?= $item['quantity'] ?></span>
                                <span>= <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #999; padding: 20px;">Không có sản phẩm nào</p>
                <?php endif; ?>
            </div>

            <div class="summary-row">
                <span>Tạm tính:</span>
                <span><?= number_format($total ?? 0, 0, ',', '.') ?>đ</span>
            </div>

            <div id="discountRow" class="summary-row discount" style="display: none;">
                <span>Giảm giá:</span>
                <span>-<span id="discountAmount">0</span>đ</span>
            </div>

            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span><?= ($total ?? 0) >= 500000 ? 'Miễn phí' : '30,000đ' ?></span>
            </div>

            <div class="summary-row total">
                <span>Tổng cộng:</span>
                <span id="finalTotal"><?= number_format(($total ?? 0) >= 500000 ? ($total ?? 0) : ($total ?? 0) + 30000, 0, ',', '.') ?>đ</span>
            </div>
        </div>
    </div>
</div>

<script>
    let paymentMethod = '<?= $_POST['payment_method'] ?? 'COD' ?>';
    let subtotal = <?= $total ?? 0 ?>;
    let discount = 0;
    let promoCode = '';

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (paymentMethod === 'QR') {
        selectPayment('QR');
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    const formData = new FormData(this);
    
    fetch('/shop_giay/order/checkout', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        if (response.status === 302) {
            // Redirect - session expired
            throw new Error('Phiên đăng nhập hết hạn');
        }
        
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            console.error('Expected JSON but got:', contentType);
            return response.text().then(text => {
                console.error('Response text:', text.substring(0, 200));
                throw new Error('Server returned HTML instead of JSON');
            });
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            showNotification('Đặt hàng thành công!', 'success');
            setTimeout(() => {
                window.location.href = '/shop_giay/order/success/' + data.order_code;
            }, 1500);
        } else {
            showNotification(data.message || 'Có lỗi xảy ra', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Xác nhận đặt hàng';
            
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            }
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        
        if (error.message.includes('Phiên đăng nhập')) {
            showNotification('Phiên đăng nhập hết hạn. Đang chuyển hướng...', 'error');
            setTimeout(() => {
                window.location.href = '/shop_giay/auth/login';
            }, 2000);
        } else {
            showNotification('Lỗi kết nối đến server: ' + error.message, 'error');
        }
        
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Xác nhận đặt hàng';
    });
});

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
        notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span style="margin-left: 10px;">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function selectPayment(method) {
        paymentMethod = method;
        
        document.querySelectorAll('.payment-method').forEach(el => {
            el.classList.remove('selected');
        });
        
        event.currentTarget.classList.add('selected');
        document.getElementById('payment_' + method.toLowerCase()).checked = true;
        
        if (method === 'QR') {
            document.querySelector('.checkout-form > form').style.display = 'none';
            document.getElementById('qrSection').classList.add('active');
            document.getElementById('submitBtn').style.display = 'none';
        } else {
            document.querySelector('.checkout-form > form').style.display = 'block';
            document.getElementById('qrSection').classList.remove('active');
            document.getElementById('submitBtn').style.display = 'block';
        }
    }

    function cancelQR() {
        if (confirm('Hủy thanh toán QR và quay lại?')) {
            document.getElementById('payment_cod').checked = true;
            selectPayment('COD');
        }
    }

    function checkQRPayment() {
        document.getElementById('qrStatus').innerHTML = `
            <i class="fas fa-spinner fa-spin"></i>
            Đang kiểm tra thanh toán...
        `;
        
        setTimeout(() => {
            if (confirm('Xác nhận đã thanh toán thành công?')) {
                document.getElementById('checkoutForm').submit();
            } else {
                document.getElementById('qrStatus').innerHTML = `
                    <i class="fas fa-times-circle"></i>
                    Chưa nhận được thanh toán
                `;
            }
        }, 2000);
    }

    function applyPromo() {
        const promoInput = document.getElementById('promoCode');
        const code = promoInput.value.trim().toUpperCase();
        const messageDiv = document.getElementById('promoMessage');
        const applyBtn = document.getElementById('applyPromoBtn');
        
        if (!code) {
            messageDiv.className = 'promo-message error';
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Vui lòng nhập mã khuyến mãi';
            return;
        }
        
        applyBtn.disabled = true;
        applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        messageDiv.innerHTML = '';
        
        fetch('/shop_giay/promotion/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                code: code,
                total: subtotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                discount = data.discount_amount;
                promoCode = code;
                
                document.getElementById('discountRow').style.display = 'flex';
                document.getElementById('discountAmount').textContent = new Intl.NumberFormat('vi-VN').format(discount);
                
                const shipping = subtotal >= 500000 ? 0 : 30000;
                const finalTotal = subtotal - discount + shipping;
                document.getElementById('finalTotal').textContent = new Intl.NumberFormat('vi-VN').format(finalTotal) + 'đ';
                
                messageDiv.className = 'promo-message success';
                messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> Áp dụng mã thành công!';
                
                let hiddenInput = document.getElementById('promoCodeHidden');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'promo_code';
                    hiddenInput.id = 'promoCodeHidden';
                    document.getElementById('checkoutForm').appendChild(hiddenInput);
                }
                hiddenInput.value = code;
                
            } else {
                messageDiv.className = 'promo-message error';
                messageDiv.innerHTML = '<i class="fas fa-times-circle"></i> ' + (data.message || 'Mã không hợp lệ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.className = 'promo-message error';
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Lỗi kết nối';
        })
        .finally(() => {
            applyBtn.disabled = false;
            applyBtn.innerHTML = 'Áp dụng';
        });
    }

    // Thêm CSS cho animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>

<?php include 'app/views/layouts/footer.php'; ?>