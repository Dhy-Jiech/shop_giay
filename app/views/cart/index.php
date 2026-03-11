<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary-red: #d32f2f;
        --error-red: #dc3545;
        --light-bg: #f8f9fa;
        --border-color: #eee;
    }

    .cart-container { padding: 40px 0; min-height: 60vh; background-color: var(--light-bg); }
    
    /* Cấu trúc bảng và căn chỉnh thẳng hàng */
    .cart-table { width: 100%; border-collapse: separate; border-spacing: 0 12px; table-layout: fixed; }
    .cart-table thead th { 
        border: none; color: #888; font-weight: 500; 
        text-transform: uppercase; font-size: 0.8rem; padding: 10px 15px;
        text-align: center; 
    }
    .cart-table thead th:first-child { text-align: left; width: 40%; } /* Cột sản phẩm rộng hơn */
    
    .cart-item-row { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.03); border-radius: 12px; }
    .cart-item-row td { padding: 20px 15px; vertical-align: middle; text-align: center; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); }
    .cart-item-row td:first-child { border-left: 1px solid var(--border-color); border-radius: 12px 0 0 12px; text-align: left; }
    .cart-item-row td:last-child { border-right: 1px solid var(--border-color); border-radius: 0 12px 12px 0; }

    /* Chi tiết sản phẩm */
    .product-box { display: flex; align-items: center; gap: 15px; }
    .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
    .product-info a { text-decoration: none; color: #333; font-weight: 600; display: block; margin-bottom: 4px; font-size: 0.95rem; }
    .size-badge { font-size: 0.75rem; color: #777; background: #f1f1f1; padding: 2px 8px; border-radius: 4px; display: inline-block; }

    /* Input số lượng */
    .qty-form { display: flex; justify-content: center; }
    .qty-wrapper { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; height: 34px; }
    .qty-input { width: 40px; border: none; text-align: center; font-weight: 600; font-size: 0.9rem; outline: none; }
    .btn-update { background: #f1f1f1; color: #333; border: none; padding: 0 10px; cursor: pointer; height: 100%; transition: 0.2s; }
    .btn-update:hover { background: #333; color: #fff; }

    /* Nút xóa X màu đỏ */
    .btn-remove { color: var(--error-red); text-decoration: none; font-size: 1.1rem; font-weight: bold; transition: 0.2s; opacity: 0.7; }
    .btn-remove:hover { opacity: 1; transform: scale(1.2); display: inline-block; }

    /* Sidebar tóm tắt */
    .summary-card { background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid var(--border-color); }
    .total-price { font-size: 1.5rem; font-weight: 800; color: var(--primary-red); }

    .btn-checkout {
        display: block; width: 100%; padding: 16px; border-radius: 10px;
        background: linear-gradient(135deg, #ff4d4d 0%, #d32f2f 100%);
        color: #fff !important; text-align: center; font-weight: 700; text-transform: uppercase;
        text-decoration: none; border: none; margin-top: 20px;
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.2); transition: 0.3s;
    }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(211, 47, 47, 0.3); }
</style>

<div class="cart-container">
    <div class="container">
        <h2 class="mb-4" style="font-weight: 700;">Giỏ hàng của bạn</h2>

        <?php if (empty($data['items'])): ?>
            <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                <p class="text-muted mb-4">Giỏ hàng của bạn đang trống.</p>
                <a href="/shop_giay/product" class="btn btn-dark px-4">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['items'] as $item): ?>
                                <tr class="cart-item-row">
                                    <td>
                                        <div class="product-box">
                                            <img src="/shop_giay/public/uploads/<?= htmlspecialchars($item['primary_image']) ?>" 
                                                 class="product-img" alt="product">
                                            <div class="product-info">
                                                <a href="/shop_giay/product/detail/<?= $item['slug'] ?>"><?= htmlspecialchars($item['name']) ?></a>
                                                <span class="size-badge">Size: <?= htmlspecialchars($item['size']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span style="color: #666;"><?= number_format($item['price'], 0, ',', '.') ?>đ</span></td>
                                    <td>
                                        <form action="/shop_giay/cart/update" method="POST" class="qty-form">
                                            <div class="qty-wrapper">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                                                <button type="submit" class="btn-update" title="Cập nhật">↻</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td><strong style="color: #333;"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</strong></td>
                                    <td>
                                        <a href="/shop_giay/cart/remove/<?= $item['product_id'] ?>" 
                                           class="btn-remove" 
                                           onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')" title="Xóa">✕</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5 class="mb-4" style="font-weight: 700;">Tóm tắt đơn hàng</h5>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Tạm tính:</span>
                            <span><?= number_format($data['total'], 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Phí vận chuyển:</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span style="font-weight: 600;">Tổng cộng:</span>
                            <span class="total-price"><?= number_format($data['total'], 0, ',', '.') ?>đ</span>
                        </div>
                        
                        <a href="/shop_giay/order/checkout" class="btn-checkout">
                            Tiến hành thanh toán
                        </a>
                        
                        <div class="text-center mt-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="15" class="mx-2" style="filter: grayscale(1);">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" height="12" class="mx-2" style="filter: grayscale(1);">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" height="15" class="mx-2" style="filter: grayscale(1);">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>