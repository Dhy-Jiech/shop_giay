<?php include 'app/views/layouts/header.php'; ?>

<?php $product = $data['product']; ?>

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

.product-detail-page {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 2rem 0;
}

.product-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(255,71,87,0.1);
}

.product-card:hover {
    box-shadow: var(--shadow-lg);
}

/* Gallery Styles */
.gallery-main {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    border: 1px solid #eee;
}

.gallery-main img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-main:hover img {
    transform: scale(1.02);
}

.gallery-thumbnails {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    overflow-x: auto;
    padding-bottom: 10px;
    scrollbar-width: thin;
    scrollbar-color: var(--primary-red) #f0f0f0;
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 5px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: #f0f0f0;
    border-radius: 10px;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background: var(--primary-red);
    border-radius: 10px;
}

.thumbnail-item {
    flex: 0 0 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    opacity: 0.7;
}

.thumbnail-item:hover {
    opacity: 1;
    border-color: var(--primary-red);
    transform: translateY(-3px);
}

.thumbnail-item.active {
    opacity: 1;
    border-color: var(--primary-red);
    box-shadow: 0 3px 10px rgba(255,71,87,0.3);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info Styles */
.product-badge {
    display: inline-block;
    background: var(--gradient-red);
    color: white;
    padding: 6px 15px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    box-shadow: 0 3px 10px rgba(255,71,87,0.2);
}

.product-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
    color: #333;
}

.product-price-box {
    background: linear-gradient(135deg, #fff5f6, #fff);
    padding: 1.2rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255,71,87,0.2);
}

.product-price {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary-red);
    margin: 0;
    line-height: 1;
}

.product-price small {
    font-size: 1rem;
    font-weight: 400;
    color: #999;
    margin-left: 10px;
}

/* Size Selector */
.size-selector {
    background: #f8f9fa;
    padding: 1.2rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.size-selector label {
    font-weight: 600;
    color: #555;
    margin-bottom: 10px;
    display: block;
}

.size-options {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.size-option {
    position: relative;
    min-width: 60px;
}

.size-option input[type="radio"] {
    display: none;
}

.size-option .size-label {
    display: block;
    padding: 10px 15px;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-weight: 600;
    color: #666;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-option input[type="radio"]:checked + .size-label {
    background: var(--gradient-red);
    border-color: transparent;
    color: white;
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
    transform: translateY(-2px);
}

.size-option .size-label.out-of-stock {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f5f5f5;
}

/* Quantity Selector */
.quantity-selector-modern {
    background: #f8f9fa;
    padding: 1.2rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.quantity-selector-modern label {
    font-weight: 600;
    color: #555;
    margin-bottom: 10px;
    display: block;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-btn {
    width: 45px;
    height: 45px;
    border: none;
    background: white;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #666;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover:not(:disabled) {
    background: var(--gradient-red);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-input {
    width: 80px;
    height: 45px;
    text-align: center;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    background: white;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 1.5rem;
}

.btn-cart {
    flex: 1;
    height: 55px;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: white;
    color: #333;
    border: 2px solid #e0e0e0;
}

.btn-cart:hover {
    border-color: var(--primary-red);
    color: var(--primary-red);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-buy-now {
    flex: 1;
    height: 55px;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--gradient-red);
    color: white;
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.btn-buy-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,71,87,0.4);
}

/* Stock Status */
.stock-status {
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.stock-status.in-stock {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.stock-status.out-of-stock {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Product Description */
.product-description {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-top: 1.5rem;
}

.product-description h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.product-description h4 i {
    color: var(--primary-red);
}

.product-description p {
    color: #666;
    line-height: 1.8;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .product-title {
        font-size: 1.8rem;
    }
    
    .product-price {
        font-size: 1.8rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .gallery-main img {
        height: 300px;
    }
    
    .size-options {
        justify-content: center;
    }
}
/* Reviews Styles */
.reviews-section {
    background: white;
    border-radius: var(--border-radius);
    padding: 2.5rem;
    margin-top: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255,71,87,0.1);
}

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 1.5rem;
}

.rating-summary {
    display: flex;
    align-items: center;
    gap: 20px;
}

.avg-rating-number {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--primary-red);
    line-height: 1;
}

.avg-rating-stars {
    color: #ffc107;
    font-size: 1.2rem;
}

.review-item {
    padding: 1.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.review-item:last-child {
    border-bottom: none;
}

.review-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.reviewer-name {
    font-weight: 600;
    color: #333;
}

.review-date {
    font-size: 0.85rem;
    color: #999;
}

.review-rating {
    color: #ffc107;
    margin-bottom: 0.8rem;
}

.review-comment {
    color: #555;
    line-height: 1.6;
}

.review-form-container {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 12px;
    margin-top: 2rem;
}

.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 10px;
    margin-bottom: 1rem;
}

.star-rating-input input {
    display: none;
}

.star-rating-input label {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: all 0.2s ease;
}

.star-rating-input label:hover,
.star-rating-input label:hover ~ label,
.star-rating-input input:checked ~ label {
    color: #ffc107;
}
</style>

<div class="product-detail-page">
    <div class="container">
        <!-- Breadcrumb -->
        <div style="margin-bottom: 1.5rem;">
            <a href="/shop_giay/home/index" style="color: #666; text-decoration: none;">Trang chủ</a>
            <span style="color: #999; margin: 0 8px;">/</span>
            <a href="/shop_giay/product/index" style="color: #666; text-decoration: none;">Sản phẩm</a>
            <span style="color: #999; margin: 0 8px;">/</span>
            <span style="color: var(--primary-red); font-weight: 500;"><?= htmlspecialchars($product['name']) ?></span>
        </div>

        <!-- Product Card -->
        <div class="product-card">
            <div class="row g-0">
                <!-- Gallery Column -->
                <div class="col-md-6" style="padding: 2rem;">
                    <?php 
                        $primaryImg = 'public/images/default-shoe.jpg';
                        if(!empty($product['images'])) {
                            foreach($product['images'] as $img) {
                                if($img['is_primary']) {
                                    $primaryImg = $img['image_url'];
                                    break;
                                }
                            }
                            if($primaryImg == 'public/images/default-shoe.jpg') {
                                $primaryImg = $product['images'][0]['image_url'];
                            }
                        }
                    ?>
                    
                    <div class="gallery-main">
                        <img id="main-product-image" src="<?= htmlspecialchars($primaryImg) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    
                    <?php if(!empty($product['images']) && count($product['images']) > 1): ?>
                    <div class="gallery-thumbnails">
                        <?php foreach($product['images'] as $index => $img): ?>
                            <div class="thumbnail-item <?= $index === 0 ? 'active' : '' ?>" 
                                 onclick="changeImage(this, '<?= htmlspecialchars($img['image_url']) ?>')">
                                <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="Thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Info Column -->
                <div class="col-md-6" style="padding: 2rem;">
                    <!-- Collection Badge -->
                    <span class="product-badge">
                        <i class="fas fa-tag"></i> 
                        <?= htmlspecialchars($product['collection_name'] ?? 'BST Đặc biệt') ?>
                    </span>

                    <!-- Product Title -->
                    <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

                    <!-- Price Box -->
                    <div class="product-price-box">
                        <div class="product-price">
                            <span id="display-price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?></span>đ
                            <small>(Đã bao gồm VAT)</small>
                        </div>
                    </div>

                    <!-- Size Selection -->
                    <div class="size-selector">
                        <label><i class="fas fa-ruler"></i> Chọn kích cỡ (Size)</label>
                        <div class="size-options">
                            <?php if(!empty($product['variants'])): ?>
                                <?php foreach($product['variants'] as $variant): ?>
                                    <div class="size-option">
                                        <input type="radio" 
                                               name="variant_id" 
                                               id="size-<?= $variant['id'] ?>" 
                                               value="<?= $variant['id'] ?>"
                                               data-price="<?= $variant['sale_price'] ?>" 
                                               data-stock="<?= $variant['stock_quantity'] ?>"
                                               <?= $variant['stock_quantity'] <= 0 ? 'disabled' : '' ?>
                                               onchange="updateVariantInfo(this)">
                                        <label for="size-<?= $variant['id'] ?>" 
                                               class="size-label <?= $variant['stock_quantity'] <= 0 ? 'out-of-stock' : '' ?>">
                                            <?= htmlspecialchars($variant['size']) ?>
                                            <small style="display: block; font-size: 0.7rem;">
                                                <?= $variant['stock_quantity'] > 0 ? "Còn ".$variant['stock_quantity'] : "Hết" ?>
                                            </small>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color: #999; padding: 10px;">Sản phẩm chưa có phân loại</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quantity Selection -->
                    <div class="quantity-selector-modern">
                        <label><i class="fas fa-cubes"></i> Số lượng</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="changeQty(-1)" id="decreaseQty">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" readonly class="quantity-input">
                            <button type="button" class="quantity-btn" onclick="changeQty(1)" id="increaseQty">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div id="stock-status" class="stock-status in-stock">
                        <i class="fas fa-check-circle"></i>
                        <span>Còn hàng</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="button" onclick="addToCart()" class="btn-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Thêm vào giỏ
                        </button>
                        <button type="button" onclick="buyNow()" class="btn-buy-now">
                            <i class="fas fa-bolt"></i>
                            Mua ngay
                        </button>
                    </div>

                    <!-- Hidden Forms -->
                    <form id="buyNowForm" action="/shop_giay/order/buyNow/<?= $product['id'] ?>" method="POST" style="display: none;">
                        <input type="hidden" name="variant_id" id="buyNowVariantId" value="">
                        <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                    </form>

                    <form id="addToCartForm" action="/shop_giay/cart/add" method="POST" style="display: none;">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="variant_id" id="cartVariantId" value="">
                        <input type="hidden" name="quantity" id="cartQuantity" value="1">
                    </form>

                    <!-- Product Description -->
                    <div class="product-description">
                        <h4><i class="fas fa-info-circle"></i> Mô tả sản phẩm</h4>
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section (Có thể thêm sau) -->
        <?php if(isset($data['related_products']) && !empty($data['related_products'])): ?>
        <div style="margin-top: 3rem;">
            <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem; position: relative; padding-bottom: 10px;">
                Sản phẩm liên quan
                <span style="position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: var(--gradient-red); border-radius: 2px;"></span>
            </h3>
            <!-- Thêm grid sản phẩm liên quan ở đây -->
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
let currentVariant = null;
let currentStock = 0;

// Hàm thay đổi ảnh chính
function changeImage(element, imgSrc) {
    document.getElementById('main-product-image').src = imgSrc;
    
    // Cập nhật active state
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
}

// Hàm thay đổi số lượng
function changeQty(val) {
    const qtyInput = document.getElementById('qty');
    let current = parseInt(qtyInput.value);
    let newVal = current + val;
    
    if (newVal >= 1 && newVal <= currentStock) {
        qtyInput.value = newVal;
    } else if (newVal > currentStock) {
        alert('Số lượng vượt quá tồn kho! Chỉ còn ' + currentStock + ' sản phẩm.');
    }
}

// Cập nhật thông tin khi đổi size
function updateVariantInfo(radioElement) {
    if (radioElement.checked) {
        currentVariant = radioElement.value;
        currentStock = parseInt(radioElement.dataset.stock);
        const price = parseInt(radioElement.dataset.price);
        
        // Cập nhật giá
        document.getElementById('display-price').innerText = new Intl.NumberFormat('vi-VN').format(price);
        
        // Cập nhật trạng thái kho
        const stockStatus = document.getElementById('stock-status');
        if (currentStock > 0) {
            stockStatus.className = 'stock-status in-stock';
            stockStatus.innerHTML = '<i class="fas fa-check-circle"></i> <span>Còn ' + currentStock + ' sản phẩm</span>';
            
            // Enable quantity buttons
            document.getElementById('decreaseQty').disabled = false;
            document.getElementById('increaseQty').disabled = false;
            
            // Reset quantity nếu lớn hơn stock
            const qtyInput = document.getElementById('qty');
            if (parseInt(qtyInput.value) > currentStock) {
                qtyInput.value = currentStock;
            }
        } else {
            stockStatus.className = 'stock-status out-of-stock';
            stockStatus.innerHTML = '<i class="fas fa-times-circle"></i> <span>Hết hàng tạm thời</span>';
            
            // Disable quantity buttons
            document.getElementById('decreaseQty').disabled = true;
            document.getElementById('increaseQty').disabled = true;
        }
    }
}

// Hàm xử lý mua ngay
function buyNow() {
    const selectedVariant = document.querySelector('input[name="variant_id"]:checked');
    
    if (!selectedVariant) {
        alert('Vui lòng chọn size sản phẩm!');
        return;
    }
    
    const stock = parseInt(selectedVariant.dataset.stock);
    if (stock <= 0) {
        alert('Sản phẩm này đã hết hàng!');
        return;
    }
    
    const quantity = parseInt(document.getElementById('qty').value);
    
    // Gán giá trị vào form ẩn và submit
    document.getElementById('buyNowVariantId').value = selectedVariant.value;
    document.getElementById('buyNowQuantity').value = quantity;
    document.getElementById('buyNowForm').submit();
}

// Hàm xử lý thêm vào giỏ hàng
function addToCart() {
    const selectedVariant = document.querySelector('input[name="variant_id"]:checked');
    
    if (!selectedVariant) {
        alert('Vui lòng chọn size sản phẩm!');
        return;
    }
    
    const stock = parseInt(selectedVariant.dataset.stock);
    if (stock <= 0) {
        alert('Sản phẩm này đã hết hàng!');
        return;
    }
    
    const quantity = parseInt(document.getElementById('qty').value);
    
    // Gán giá trị vào form ẩn và submit
    document.getElementById('cartVariantId').value = selectedVariant.value;
    document.getElementById('cartQuantity').value = quantity;
    document.getElementById('addToCartForm').submit();
}

// Auto-select first variant on page load
document.addEventListener('DOMContentLoaded', function() {
    const firstVariant = document.querySelector('input[name="variant_id"]');
    if (firstVariant && !firstVariant.disabled) {
        firstVariant.checked = true;
        updateVariantInfo(firstVariant);
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>