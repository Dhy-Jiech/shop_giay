<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary-red: #ef4444;
        --primary-red-dark: #b91c1c;
        --gradient-red: linear-gradient(135deg, #ef4444, #b91c1c);
        --light-bg: #f9fafb;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .cart-page {
        background: var(--light-bg);
        min-height: 80vh;
        padding: 40px 0;
        font-family: 'Inter', sans-serif;
    }

    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Cart Header */
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .cart-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        position: relative;
    }

    .cart-header h2::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-red);
        border-radius: 2px;
    }

    .cart-count {
        background: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: var(--shadow-sm);
    }

    .cart-count span {
        color: var(--primary-red);
        font-weight: 700;
    }

    /* Cart Table */
    .cart-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    .cart-table thead th {
        padding: 15px 20px;
        background: transparent;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .cart-item-row {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .cart-item-row:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .cart-item-row td {
        padding: 20px;
        vertical-align: middle;
        border: none;
    }

    .cart-item-row td:first-child {
        border-radius: 16px 0 0 16px;
    }

    .cart-item-row td:last-child {
        border-radius: 0 16px 16px 0;
    }

    /* Product Box */
    .product-box {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-img-wrapper {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        overflow: hidden;
        background: #f3f4f6;
        border: 1px solid #f3f4f6;
        flex-shrink: 0;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-img-wrapper:hover .product-img {
        transform: scale(1.1);
    }

    .product-info {
        flex: 1;
    }

    .product-info a {
        text-decoration: none;
        color: #1f2937;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 6px;
        display: block;
        transition: color 0.2s;
    }

    .product-info a:hover {
        color: var(--primary-red);
    }

    .product-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .product-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 30px;
        background: #f3f4f6;
        color: #4b5563;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .product-badge i {
        font-size: 0.7rem;
        color: var(--primary-red);
    }

    /* Price Styles */
    .price-current {
        font-weight: 600;
        color: #1f2937;
        font-size: 1.1rem;
    }

    .price-old {
        font-size: 0.9rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-left: 8px;
    }

    /* Quantity Controls */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 30px;
        overflow: hidden;
        padding: 4px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: white;
        border-radius: 30px;
        color: #4b5563;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: var(--shadow-sm);
    }

    .qty-btn:hover {
        background: var(--gradient-red);
        color: white;
        transform: scale(1.1);
    }

    .qty-input {
        width: 45px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        color: #1f2937;
        background: transparent;
        outline: none;
    }

    /* Item Total */
    .item-total {
        font-weight: 700;
        color: var(--primary-red);
        font-size: 1.2rem;
    }

    /* Remove Button */
    .btn-remove {
        color: #9ca3af;
        text-decoration: none;
        font-size: 1.2rem;
        transition: all 0.2s;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f9fafb;
    }

    .btn-remove:hover {
        color: white;
        background: var(--gradient-red);
        transform: rotate(90deg);
    }

    /* Cart Summary */
    .summary-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: var(--shadow-lg);
        position: sticky;
        top: 100px;
        border: 1px solid #f3f4f6;
    }

    .summary-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f3f4f6;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .summary-divider {
        height: 1px;
        background: #f3f4f6;
        margin: 20px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .total-price {
        font-size: 1.5rem;
        color: var(--primary-red);
    }

    .btn-checkout {
        display: block;
        width: 100%;
        padding: 16px;
        background: var(--gradient-red);
        color: white;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-checkout i {
        margin-right: 8px;
    }

    .payment-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .payment-icon {
        height: 24px;
        filter: grayscale(1);
        opacity: 0.5;
        transition: all 0.2s;
    }

    .payment-icon:hover {
        filter: grayscale(0);
        opacity: 1;
    }

    /* Empty Cart */
    .empty-cart {
        background: white;
        border-radius: 30px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: var(--shadow-lg);
    }

    .empty-icon {
        font-size: 5rem;
        color: #e5e7eb;
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        font-size: 1.8rem;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: #6b7280;
        margin-bottom: 30px;
        font-size: 1rem;
    }

    .btn-shop {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--gradient-red);
        color: white;
        padding: 14px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-shop:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    }

    /* Promo Code */
    .promo-code {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }

    .promo-input-group {
        display: flex;
        gap: 10px;
    }

    .promo-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        outline: none;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .promo-input:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .btn-promo {
        padding: 12px 20px;
        background: #f3f4f6;
        color: #4b5563;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-promo:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cart-table thead {
            display: none;
        }

        .cart-item-row {
            display: block;
            margin-bottom: 20px;
        }

        .cart-item-row td {
            display: block;
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid #f3f4f6;
        }

        .cart-item-row td:last-child {
            border-bottom: none;
        }

        .cart-item-row td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            color: #6b7280;
        }

        .product-box {
            flex-direction: column;
            text-align: center;
        }

        .product-img-wrapper {
            margin: 0 auto;
        }

        .quantity-control {
            justify-content: flex-end;
        }
    }
</style>

<div class="cart-page">
    <div class="cart-container">
        <!-- Cart Header -->
        <div class="cart-header">
            <h2>
                <i class="fas fa-shopping-cart" style="color: var(--primary-red); margin-right: 10px;"></i>
                Giỏ hàng của bạn
            </h2>
            <?php if (!empty($data['items'])): ?>
                <div class="cart-count">
                    <i class="fas fa-box"></i>
                    <span><?= count($data['items']) ?></span> sản phẩm
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($data['items'])): ?>
            <!-- Empty Cart -->
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Giỏ hàng trống</h3>
                <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm của chúng tôi!</p>
                <a href="/shop_giay/product/index" class="btn-shop">
                    <i class="fas fa-arrow-left"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Cart Items -->
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['items'] as $item): ?>
                                <tr class="cart-item-row">
                                    <td data-label="Sản phẩm">
                                        <div class="product-box">
                                            <div class="product-img-wrapper">
                                                <?php 
                                                $imagePath = $item['primary_image'] ?? '/public/images/no-image.png';
                                                if (strpos($imagePath, '/shop_giay') === false && strpos($imagePath, 'http') === false) {
                                                    $imagePath = '/shop_giay/public/uploads/' . ltrim($imagePath, '/');
                                                }
                                                ?>
                                                <img src="<?= htmlspecialchars($imagePath) ?>" 
                                                     class="product-img" alt="<?= htmlspecialchars($item['name']) ?>"
                                                     onerror="this.src='/shop_giay/public/images/no-image.png'">
                                            </div>
                                            <div class="product-info">
                                                <a href="/shop_giay/product/detail/<?= $item['slug'] ?>">
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </a>
                                                <div class="product-meta">
                                                    <span class="product-badge">
                                                        <i class="fas fa-ruler"></i>
                                                        Size: <?= htmlspecialchars($item['size'] ?? 'M') ?>
                                                    </span>
                                                    <span class="product-badge">
                                                        <i class="fas fa-palette"></i>
                                                        Màu: <?= htmlspecialchars($item['color'] ?? 'Đen') ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Đơn giá">
                                        <span class="price-current"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                                    </td>
                                    <td data-label="Số lượng">
                                        <div class="quantity-control">
                                            <form action="/shop_giay/cart/update" method="POST" class="quantity-wrapper" id="update-form-<?= $item['product_id'] ?>">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <button type="button" class="qty-btn" onclick="updateQuantity(<?= $item['product_id'] ?>, -1)">−</button>
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                                       min="1" class="qty-input" readonly id="qty-<?= $item['product_id'] ?>">
                                                <button type="button" class="qty-btn" onclick="updateQuantity(<?= $item['product_id'] ?>, 1)">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td data-label="Tổng">
                                        <span class="item-total"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</span>
                                    </td>
                                    <td>
                                        <a href="/shop_giay/cart/remove/<?= $item['product_id'] ?>" 
                                           class="btn-remove" 
                                           onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-4">
                    <!-- Cart Summary -->
                    <div class="summary-card">
                        <h3 class="summary-title">
                            <i class="fas fa-receipt" style="color: var(--primary-red); margin-right: 8px;"></i>
                            Tóm tắt đơn hàng
                        </h3>
                        
                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span><?= number_format($data['total'], 0, ',', '.') ?>đ</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>

                        <?php if (isset($data['discount']) && $data['discount'] > 0): ?>
                        <div class="summary-row" style="color: #10b981;">
                            <span>Giảm giá:</span>
                            <span>-<?= number_format($data['discount'], 0, ',', '.') ?>đ</span>
                        </div>
                        <?php endif; ?>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Tổng cộng:</span>
                            <span class="total-price"><?= number_format($data['total'], 0, ',', '.') ?>đ</span>
                        </div>

                        <!-- Promo Code -->
                        <div class="promo-code">
                            <div class="promo-input-group">
                                <input type="text" class="promo-input" placeholder="Mã giảm giá" id="promoCode">
                                <button class="btn-promo" onclick="applyPromo()">
                                    <i class="fas fa-tag"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="/shop_giay/order/checkout" class="btn-checkout">
                            <i class="fas fa-lock"></i>
                            Thanh toán ngay
                        </a>

                        <!-- Payment Methods -->
                        <div class="payment-icons">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" 
                                 class="payment-icon" height="24" alt="PayPal">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" 
                                 class="payment-icon" height="24" alt="Visa">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" 
                                 class="payment-icon" height="24" alt="Mastercard">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/39/MoMo_Logo.png" 
                                 class="payment-icon" height="24" alt="MoMo">
                        </div>

                        <!-- Continue Shopping -->
                        <div class="text-center mt-3">
                            <a href="/shop_giay/product/index" style="color: #6b7280; text-decoration: none; font-size: 0.9rem;">
                                <i class="fas fa-arrow-left"></i>
                                Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function updateQuantity(productId, change) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + change;
    
    if (newQty < 1) return;
    
    // Cập nhật số lượng trên giao diện
    qtyInput.value = newQty;
    
    // Gửi AJAX request để cập nhật giỏ hàng
    const form = document.getElementById(`update-form-${productId}`);
    const formData = new FormData(form);
    
    fetch('/shop_giay/cart/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload trang để cập nhật tổng tiền
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function applyPromo() {
    const promoCode = document.getElementById('promoCode').value;
    if (!promoCode) {
        alert('Vui lòng nhập mã giảm giá');
        return;
    }
    
    // Gửi AJAX request để kiểm tra mã giảm giá
    fetch('/shop_giay/promotion/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ code: promoCode, total: <?= $data['total'] ?> })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Áp dụng mã giảm giá thành công!');
            location.reload();
        } else {
            alert(data.message || 'Mã giảm giá không hợp lệ');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<?php include 'app/views/layouts/footer.php'; ?>