<?php include 'app/views/layouts/header.php'; ?>

<?php 
// XÓA dòng var_dump và die() - KHÔNG dùng ở đây
// var_dump($_POST);
// die();

// Đảm bảo các key tồn tại
$productName = $product['name'] ?? 'Sản phẩm';
$productSlug = $product['slug'] ?? 'san-pham-' . ($product['id'] ?? '');
$productImage = $product['primary_image'] ?? '/public/images/no-image.png';
$productId = $product['id'] ?? 0;
$variants = $variants ?? [];
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-bolt text-danger me-2"></i>
                        Mua ngay: <?= htmlspecialchars($productName) ?>
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Hiển thị lỗi nếu có -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['info'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $_SESSION['info']; unset($_SESSION['info']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- SỬA action đúng với controller -->
                    <form action="/shop_giay/order/buyNow/<?= $productId ?>" method="POST">
                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="product-image-wrapper text-center">
                                    <img src="<?= htmlspecialchars($productImage) ?>" 
                                         alt="<?= htmlspecialchars($productName) ?>"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 300px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h5 class="mb-3">Thông tin sản phẩm</h5>
                                
                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên sản phẩm:</label>
                                    <p class="form-control-plaintext"><?= htmlspecialchars($productName) ?></p>
                                </div>

                                <!-- Chọn Size và Màu -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Chọn phân loại <span class="text-danger">*</span></label>
                                    
                                    <?php if (empty($variants)): ?>
                                        <p class="text-danger">Sản phẩm hiện không có phân loại</p>
                                    <?php else: ?>
                                        <div class="variant-options">
                                            <?php foreach ($variants as $variant): 
                                                $isOutOfStock = ($variant['stock_quantity'] ?? 0) <= 0;
                                                // Chọn variant đầu tiên làm mặc định nếu chưa chọn
                                                $isChecked = !isset($_POST['variant_id']) && $variant === reset($variants);
                                            ?>
                                                <label class="variant-item <?= $isOutOfStock ? 'out-of-stock' : '' ?>">
                                                    <input type="radio" 
                                                           name="variant_id" 
                                                           value="<?= $variant['id'] ?? '' ?>"
                                                           data-price="<?= $variant['sale_price'] ?? 0 ?>"
                                                           data-stock="<?= $variant['stock_quantity'] ?? 0 ?>"
                                                           <?= $isOutOfStock ? 'disabled' : '' ?>
                                                           <?= $isChecked ? 'checked' : '' ?>
                                                           required>
                                                    <span class="variant-content">
                                                        <span class="variant-size">Size: <?= htmlspecialchars($variant['size'] ?? 'N/A') ?></span>
                                                        <span class="variant-color">Màu: <?= htmlspecialchars($variant['color'] ?? 'N/A') ?></span>
                                                        <span class="variant-price"><?= isset($variant['sale_price']) ? number_format($variant['sale_price'], 0, ',', '.') : '0' ?>đ</span>
                                                        <?php if ($isOutOfStock): ?>
                                                            <span class="badge bg-secondary">Hết hàng</span>
                                                        <?php else: ?>
                                                            <span class="variant-stock">Còn: <?= $variant['stock_quantity'] ?? 0 ?></span>
                                                        <?php endif; ?>
                                                    </span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Số lượng -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Số lượng</label>
                                    <div class="quantity-selector">
                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                        <input type="number" name="quantity" id="quantity" class="form-control text-center" 
                                               value="1" min="1" max="10" readonly style="width: 80px; display: inline-block;">
                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                                    </div>
                                    <small class="text-muted d-block mt-1">Tối đa: <span id="max-stock">10</span> sản phẩm</small>
                                </div>

                                <!-- Hiển thị giá -->
                                <div class="mb-4 p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Tạm tính:</span>
                                        <span class="h3 text-danger mb-0" id="display-price">0đ</span>
                                    </div>
                                </div>

                                <!-- Nút hành động -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-danger btn-lg" id="submit-btn" <?= empty($variants) ? 'disabled' : '' ?>>
                                        <i class="fas fa-bolt"></i> Xác nhận mua ngay
                                    </button>
                                    <a href="/shop_giay/product/detail/<?= $productSlug ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.variant-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 300px;
    overflow-y: auto;
    padding-right: 10px;
}

.variant-item {
    display: block;
    cursor: pointer;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s;
}

.variant-item:hover {
    border-color: #ff4757;
    background: #fff5f6;
}

.variant-item input[type="radio"] {
    display: none;
}

.variant-item input[type="radio"]:checked + .variant-content {
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
    color: white;
}

.variant-item input[type="radio"]:checked + .variant-content .variant-price {
    color: white;
}

.variant-item.out-of-stock {
    opacity: 0.6;
    cursor: not-allowed;
}

.variant-content {
    display: grid;
    grid-template-columns: 2fr 2fr 1fr 1fr;
    gap: 10px;
    padding: 12px 15px;
    border-radius: 6px;
    align-items: center;
}

.variant-size, .variant-color, .variant-price, .variant-stock {
    font-size: 0.9rem;
}

.variant-price {
    font-weight: 700;
    color: #ff4757;
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-selector button {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .variant-content {
        grid-template-columns: 1fr 1fr;
        gap: 5px;
    }
}
</style>

<script>
let currentPrice = 0;
let maxStock = 10;

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
        updatePrice();
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    if (value < maxStock) {
        input.value = value + 1;
        updatePrice();
    }
}

function updatePrice() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const total = currentPrice * quantity;
    document.getElementById('display-price').textContent = 
        new Intl.NumberFormat('vi-VN').format(total) + 'đ';
}

// Update when variant changes
document.querySelectorAll('input[name="variant_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            currentPrice = parseFloat(this.dataset.price);
            maxStock = parseInt(this.dataset.stock);
            document.getElementById('max-stock').textContent = maxStock;
            
            // Reset quantity if current > max
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > maxStock) {
                quantityInput.value = maxStock;
            }
            quantityInput.max = maxStock;
            
            updatePrice();
            
            // Enable submit button
            document.getElementById('submit-btn').disabled = false;
        }
    });
});

// Initialize with default variant
document.addEventListener('DOMContentLoaded', function() {
    const defaultVariant = document.querySelector('input[name="variant_id"]:checked');
    if (defaultVariant) {
        currentPrice = parseFloat(defaultVariant.dataset.price);
        maxStock = parseInt(defaultVariant.dataset.stock);
        document.getElementById('max-stock').textContent = maxStock;
        document.getElementById('quantity').max = maxStock;
        updatePrice();
        document.getElementById('submit-btn').disabled = false;
    } else {
        document.getElementById('submit-btn').disabled = true;
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>