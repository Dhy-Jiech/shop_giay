<?php include 'app/views/layouts/header.php'; ?>

<style>
:root {
    --primary-red: #ff4757;
    --primary-red-dark: #ff6b81;
    --gradient-red: linear-gradient(135deg, #ff4757, #ff6b81);
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
    --shadow-md: 0 5px 20px rgba(0,0,0,0.08);
    --shadow-lg: 0 10px 30px rgba(255,71,87,0.15);
    --border-radius: 16px;
}

body {
    background: #f8f9fa;
}

.buy-now-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}

.buy-now-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid rgba(255,71,87,0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    padding: 25px 30px;
    border-bottom: 1px solid #e9ecef;
}

.card-header h4 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
}

.card-header i {
    color: var(--primary-red);
}

.card-body {
    padding: 30px;
}

/* Collection Badge */
.collection-badge {
    display: inline-block;
    background: #f1f3f5;
    color: #495057;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.collection-badge i {
    color: var(--primary-red);
    margin-right: 5px;
}

/* Product Image */
.product-image-wrapper {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
}

.product-image-wrapper img {
    width: 100%;
    height: auto;
    max-height: 300px;
    object-fit: contain;
}

/* Variant Options */
.variant-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 300px;
    overflow-y: auto;
    padding-right: 10px;
}

.variant-item {
    display: block;
    cursor: pointer;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.variant-item:hover {
    border-color: var(--primary-red);
    background: #fff5f6;
}

.variant-item input[type="radio"] {
    display: none;
}

.variant-item input[type="radio"]:checked + .variant-content {
    background: var(--gradient-red);
    color: white;
}

.variant-item.out-of-stock {
    opacity: 0.6;
    cursor: not-allowed;
}

.variant-content {
    display: grid;
    grid-template-columns: 2fr 2fr 1fr 1fr;
    gap: 15px;
    padding: 15px 20px;
    border-radius: 8px;
    align-items: center;
}

.variant-size, .variant-color, .variant-price, .variant-stock {
    font-size: 0.95rem;
    font-weight: 500;
}

.variant-price {
    font-weight: 700;
    color: var(--primary-red);
}

.variant-item input[type="radio"]:checked + .variant-content .variant-price {
    color: white;
}

/* Quantity Selector */
.quantity-selector {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

.quantity-selector button {
    width: 45px;
    height: 45px;
    border: none;
    background: white;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-selector button:hover {
    background: var(--gradient-red);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.quantity-selector input {
    width: 80px;
    height: 45px;
    text-align: center;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    background: white;
}

/* Price Box */
.price-box {
    background: linear-gradient(135deg, #fff5f6, #ffffff);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid rgba(255,71,87,0.2);
    margin: 20px 0;
}

.price-box .label {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
}

.price-box .amount {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-red);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.btn-submit {
    flex: 1;
    background: var(--gradient-red);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,71,87,0.4);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-back {
    flex: 1;
    background: white;
    color: #2c3e50;
    border: 2px solid #e9ecef;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.btn-back:hover {
    border-color: var(--primary-red);
    color: var(--primary-red);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 10px;
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

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

/* Responsive */
@media (max-width: 768px) {
    .variant-content {
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding: 12px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .quantity-selector {
        justify-content: center;
    }
    
    .card-header h4 {
        font-size: 1.2rem;
    }
}
</style>

<?php 
// Đảm bảo các key tồn tại
$productName = $product['name'] ?? 'Sản phẩm';
$productSlug = $product['slug'] ?? 'san-pham-' . ($product['id'] ?? '');
$productImage = $product['primary_image'] ?? '/public/images/no-image.png';
$productId = $product['id'] ?? 0;
$collectionName = $product['collection_name'] ?? 'BST Mới';
$variants = $variants ?? [];
?>

<div class="buy-now-container">
    <div class="buy-now-card">
        <div class="card-header">
            <h4>
                <i class="fas fa-bolt me-2"></i>
                Mua ngay: <?= htmlspecialchars($productName) ?>
            </h4>
        </div>
        
        <div class="card-body">
            <!-- Hiển thị lỗi nếu có -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['info'])): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <?= $_SESSION['info']; unset($_SESSION['info']); ?>
                </div>
            <?php endif; ?>

            <!-- Collection Name -->
            <?php if (!empty($collectionName)): ?>
                <div class="collection-badge">
                    <i class="fas fa-tag"></i>
                    <?= htmlspecialchars($collectionName) ?>
                </div>
            <?php endif; ?>

            <form action="/shop_giay/order/buyNow/<?= $productId ?>" method="POST">
                <input type="hidden" name="product_id" value="<?= $productId ?>">
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="product-image-wrapper text-center">
                            <img src="<?= htmlspecialchars($productImage) ?>" 
                                 alt="<?= htmlspecialchars($productName) ?>"
                                 class="img-fluid">
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <h5 class="mb-4" style="font-weight: 600; color: #2c3e50;">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-red);"></i>
                            Thông tin sản phẩm
                        </h5>
                        
                        <!-- Tên sản phẩm -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2" style="color: #6c757d;">Tên sản phẩm:</label>
                            <p class="h5"><?= htmlspecialchars($productName) ?></p>
                        </div>

                        <!-- Chọn Size và Màu -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2" style="color: #6c757d;">
                                <i class="fas fa-palette me-1" style="color: var(--primary-red);"></i>
                                Chọn phân loại <span class="text-danger">*</span>
                            </label>
                            
                            <?php if (empty($variants)): ?>
                                <p class="text-danger">Sản phẩm hiện không có phân loại</p>
                            <?php else: ?>
                                <div class="variant-options">
                                    <?php foreach ($variants as $variant): 
                                        $isOutOfStock = ($variant['stock_quantity'] ?? 0) <= 0;
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
                                                <span class="variant-size">
                                                    <i class="fas fa-ruler me-1"></i>
                                                    Size: <?= htmlspecialchars($variant['size'] ?? 'N/A') ?>
                                                </span>
                                                <span class="variant-color">
                                                    <i class="fas fa-palette me-1"></i>
                                                    Màu: <?= htmlspecialchars($variant['color'] ?? 'N/A') ?>
                                                </span>
                                                <span class="variant-price">
                                                    <?= isset($variant['sale_price']) ? number_format($variant['sale_price'], 0, ',', '.') : '0' ?>đ
                                                </span>
                                                <?php if ($isOutOfStock): ?>
                                                    <span class="badge bg-secondary">Hết hàng</span>
                                                <?php else: ?>
                                                    <span class="variant-stock">
                                                        <i class="fas fa-box me-1"></i>
                                                        Còn: <?= $variant['stock_quantity'] ?? 0 ?>
                                                    </span>
                                                <?php endif; ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Số lượng -->
                        <div class="mb-4">
                            <label class="fw-bold mb-2" style="color: #6c757d;">
                                <i class="fas fa-cubes me-1" style="color: var(--primary-red);"></i>
                                Số lượng
                            </label>
                            
                            <div class="quantity-selector">
                                <button type="button" onclick="decreaseQuantity()">−</button>
                                <input type="number" name="quantity" id="quantity" 
                                       value="1" min="1" readonly>
                                <button type="button" onclick="increaseQuantity()">+</button>
                            </div>
                            
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Tối đa: <span id="max-stock">10</span> sản phẩm
                            </small>
                        </div>

                        <!-- Hiển thị giá -->
                        <div class="price-box">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="label">
                                    <i class="fas fa-calculator me-1"></i>
                                    Tạm tính:
                                </span>
                                <span class="amount" id="display-price">0đ</span>
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-submit" id="submit-btn" <?= empty($variants) ? 'disabled' : '' ?>>
                                <i class="fas fa-bolt"></i>
                                Xác nhận mua ngay
                            </button>
                            
                            <a href="/shop_giay/product/detail/<?= $productSlug ?>" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
            
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > maxStock) {
                quantityInput.value = maxStock;
            }
            quantityInput.max = maxStock;
            
            updatePrice();
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