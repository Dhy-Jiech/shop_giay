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
/* Rating Styles */
.product-rating-section {
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    margin-top: 2rem;
}
.rating-summary {
    border-bottom: 1px solid #eee;
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
}
.big-rating-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-red);
}
.star-rating i {
    color: #ffc107;
    margin-right: 2px;
}
.star-rating i.far {
    color: #ddd;
}
.review-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f5f5f5;
}
.review-user {
    font-weight: 600;
    margin-bottom: 0.2rem;
}
.review-date {
    font-size: 0.8rem;
    color: #999;
}
.review-content {
    margin-top: 0.5rem;
    color: #444;
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
<style>
    /* CSS Tùy chỉnh cho phần Đánh giá - ĐỚ Store */
    :root {
        --do-red-gradient: linear-gradient(135deg, #ff416c, #ff4b2b);
        --do-star-color: #ffc107;
        --do-text-muted: #6c757d;
    }

    .do-rating-section {
        background: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-top: 2rem;
    }

    .do-rating-header {
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .do-big-rating {
        font-size: 3.5rem;
        font-weight: 700;
        color: #ff4b2b;
        line-height: 1;
    }

    .do-star-avg, .do-review-stars {
        color: var(--do-star-color);
    }

    /* Style cho Form nhập */
    .do-add-review-box {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    .do-add-review-box h5 {
        color: #333;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .do-add-review-box .form-label {
        font-weight: 500;
        color: #555;
        font-size: 0.9rem;
    }

    .do-add-review-box .form-control, 
    .do-add-review-box .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 0.6rem 1rem;
        width: 100%; /* Đảm bảo rộng hết cỡ theo khung chứa */
        display: block;
    }

    /* Riêng cho ô nội dung đánh giá */
    .do-add-review-box textarea.form-control {
        resize: vertical; /* Cho phép kéo dài chiều cao nhưng không làm lệch chiều ngang */
        min-height: 200px; /* Độ cao mặc định lớn để người dùng ghi được nhiều */
    }

    .do-add-review-box .form-control:focus {
        border-color: #ff4b2b;
        box-shadow: 0 0 0 0.2rem rgba(255, 75, 43, 0.1);
        outline: none;
    }

    .do-btn-submit {
        background: var(--do-red-gradient);
        color: white;
        border: none;
        padding: 0.7rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .do-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(255, 75, 43, 0.2);
        color: white;
    }

    /* Style cho danh sách bình luận */
    .do-review-item {
        padding: 1.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .do-review-item:last-child {
        border-bottom: none;
    }

    .do-review-user-icon {
        width: 45px;
        height: 45px;
        background: #eee;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 1.2rem;
    }

    .do-review-user-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 0;
    }

    .do-review-date {
        font-size: 0.8rem;
        color: var(--do-text-muted);
    }

    .do-review-content {
        color: #555;
        margin-top: 0.8rem;
        line-height: 1.6;
        background: #fdfdfd;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #f1f1f1;
    }
</style>

<div class="container do-rating-section">
    <div class="row do-rating-header align-items-center">
        <div class="col-md-4 text-center border-end">
            <h4 class="mb-3">Đánh giá sản phẩm</h4>
            <div class="do-big-rating">
                <?= isset($ratingData) ? round($ratingData['stars'], 1) : '0' ?><span style="font-size: 1.5rem; color: #999;">/5</span>
            </div>
            <div class="do-star-avg my-2" style="font-size: 1.2rem;">
                <?php 
                $avg = isset($ratingData) ? $ratingData['stars'] : 0;
                for($i=1; $i<=5; $i++): ?>
                    <i class="<?= $i <= round($avg) ? 'fas' : 'far' ?> fa-star"></i>
                <?php endfor; ?>
            </div>
            <p class="text-muted mb-0">(<?= isset($ratingData) ? $ratingData['count'] : 0 ?> đánh giá thực tế)</p>
        </div>
        <div class="col-md-8 ps-md-5">
            <h5 class="text-muted">Chia sẻ trải nghiệm của bạn</h5>
            <p>Chúng tôi luôn trân trọng mọi ý kiến đóng góp của bạn để hoàn thiện sản phẩm và dịch vụ tại ĐỚ Store.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="do-add-review-box shadow-sm">
                <h5 class="mb-4"><i class="fas fa-edit" style="color: #ff4b2b;"></i> Viết đánh giá của bạn</h5>
                <form action="/shop_giay/product/addReview" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Tên hiển thị <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Ví dụ: Anh Thao" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phân loại (Số sao) <span class="text-danger">*</span></label>
                        <select name="rating" class="form-select" required style="color: var(--do-star-color); font-weight: bold;">
                            <option value="5" selected>⭐⭐⭐⭐⭐ - Tuyệt vời</option>
                            <option value="4">⭐⭐⭐⭐ - Tốt</option>
                            <option value="3">⭐⭐⭐ - Trung bình</option>
                            <option value="2">⭐⭐ - Tệ</option>
                            <option value="1">⭐ - Rất tệ</option>
                        </select>
                    </div>

                    <div class="mb-3">
    <label class="form-label font-weight-bold">Nội dung đánh giá <span class="text-danger">*</span></label>
    <textarea 
        name="comment" 
        class="form-control" 
        rows="8" 
        placeholder="Hãy chia sẻ cảm nhận chi tiết của bạn về chất lượng sản phẩm và dịch vụ tại ĐỚ Store..." 
        required
    ></textarea>
</div>

                    <div class="text-end">
                        <button type="submit" class="do-btn-submit">
                            <i class="fas fa-paper-plane"></i> Gửi đánh giá ngay
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7 ps-lg-4">
            <h5 class="mb-4">Bình luận từ khách hàng</h5>
            <div class="do-reviews-list" style="max-height: 550px; overflow-y: auto; padding-right: 15px;">
                <?php if(!empty($reviews)): ?>
                    <?php foreach($reviews as $rev): ?>
                        <div class="do-review-item">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="do-review-user-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="do-review-user-name"><?= htmlspecialchars($rev['fullname']) ?></p>
                                        <span class="do-review-date">
                                            <i class="far fa-clock me-1"></i>
                                            <?= date('d/m/Y', strtotime($rev['created_at'])) ?>
                                        </span>
                                    </div>
                                    <div class="do-review-stars" style="font-size: 0.85rem;">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i class="<?= $i <= $rev['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="do-review-content shadow-sm">
                                <?= nl2br(htmlspecialchars($rev['comment'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5 border rounded" style="background: #fefefe;">
                        <i class="fas fa-comments fa-3x mb-3" style="color: #ddd;">
                        </i>
                        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                        <p class="small text-muted">Hãy là người đầu tiên chia sẻ cảm nhận!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    </form>
</div>
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