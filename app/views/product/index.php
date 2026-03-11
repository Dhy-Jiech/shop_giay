<?php include 'app/views/layouts/header.php'; ?>


<style>
/* Filter Sidebar Styles */
.filter-sidebar {
    width: 280px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    position: sticky;
    top: 90px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.filter-sidebar:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.filter-header {
    padding: 18px 20px;
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%); /* Áp dụng Gradient đỏ */
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-title i {
    font-size: 1rem;
}

.filter-reset {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.filter-reset:hover {
    background: rgba(255,255,255,0.2);
    transform: rotate(180deg);
    color: white;
}

.filter-section {
    border-bottom: 1px solid #f0f0f0;
}

.filter-section-header {
    padding: 15px 20px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.filter-section-header:hover {
    background: #fafafa;
}

.filter-section-title {
    font-weight: 600;
    font-size: 0.95rem;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-section-title i {
    color: #ff4757;
    font-size: 1rem;
}

.toggle-icon {
    font-size: 0.8rem;
    color: #999;
    transition: transform 0.3s ease;
}

.filter-section.collapsed .toggle-icon {
    transform: rotate(-90deg);
}

.filter-section.collapsed .filter-section-content {
    display: none;
}

.filter-section-content {
    padding: 0 20px 20px 20px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Filter Options */
.filter-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-option {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 8px;
    text-decoration: none;
    color: #666;
    transition: all 0.2s ease;
    background: #fafafa;
}

.filter-option:hover {
    background: #fff5f6;
    transform: translateX(3px);
}

.filter-option.active {
    background: linear-gradient(135deg, #ff4757 0%, #ff6b81 100%);
    color: white;
    box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
}

.option-icon {
    width: 24px;
    margin-right: 8px;
    color: inherit;
}

.option-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 12px;
    display: inline-block;
}

.option-text {
    flex: 1;
    font-size: 0.9rem;
}

.option-count {
    font-size: 0.8rem;
    opacity: 0.7;
}

/* Price Range */
.price-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.price-preset {
    padding: 6px 12px;
    background: #f0f0f0;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #666;
    text-decoration: none;
    transition: all 0.2s ease;
}

.price-preset:hover {
    background: #ff4757;
    color: white;
}

.price-range-custom {
    margin-top: 10px;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.price-input-group {
    flex: 1;
}

.price-input-group input {
    width: 100%;
    padding: 8px 10px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.price-input-group input:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.price-separator {
    color: #999;
    font-size: 1rem;
    margin-top: 5px;
}

.apply-price-btn {
    width: 100%;
    padding: 8px;
    background: #ff4757;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.apply-price-btn:hover {
    background: #cc3d4a;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(255, 71, 87, 0.3);
}

/* Size Grid */
.size-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}

.size-item {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 4px;
    background: #f5f5f5;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #666;
    text-decoration: none;
    transition: all 0.2s ease;
}

.size-item:hover {
    background: #ffe3e5;
    color: #ff4757;
    transform: translateY(-2px);
}

.size-item.active {
    background: #ff4757;
    color: white;
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(255, 71, 87, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .filter-sidebar {
        width: 100%;
        position: static;
        margin-bottom: 20px;
    }
    
    .size-grid {
        grid-template-columns: repeat(6, 1fr);
    }
}
.product-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.product-card-modern {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    position: relative;
    border: 1px solid rgba(255,71,87,0.1);
}

.product-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(255,71,87,0.15);
    border-color: rgba(255,71,87,0.3);
}

/* Product Badges */
.product-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    z-index: 10;
    display: flex;
    gap: 8px;
}

.badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.badge.discount {
    background: linear-gradient(135deg, #ff4757, #ff6b81);
    color: white;
}

.badge.new {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
}

/* Product Image */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1/1;
    background: #f8f9fa;
}

.product-link {
    display: block;
    height: 100%;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.product-image.hover {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.product-card-modern:hover .product-image.front {
    opacity: 0;
}

.product-card-modern:hover .product-image.hover {
    opacity: 1;
    transform: scale(1.05);
}

/* Quick Actions */
.quick-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    z-index: 10;
}

.product-card-modern:hover .quick-actions {
    opacity: 1;
    transform: translateX(0);
}

.quick-action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    font-size: 1rem;
}

.quick-action-btn:hover {
    background: #ff4757;
    color: white;
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(255,71,87,0.3);
}

/* Product Info */
.product-info {
    padding: 1.5rem;
}

.product-category {
    color: #ff4757;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.product-name {
    font-size: 1rem;
    margin: 0 0 10px 0;
    font-weight: 600;
    line-height: 1.5;
    height: 3em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-name a {
    text-decoration: none;
    color: #333;
    transition: color 0.2s;
}

.product-name a:hover {
    color: #ff4757;
}

/* Rating */
.product-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.stars {
    display: flex;
    gap: 2px;
}

.stars i {
    color: #ddd;
    font-size: 0.8rem;
}

.stars i.active {
    color: #ffc107;
}

.rating-count {
    color: #999;
    font-size: 0.75rem;
}

/* Price */
.product-price {
    display: flex;
    align-items: baseline;
    gap: 8px;
    margin-bottom: 15px;
}

.current-price {
    color: #ff4757;
    font-weight: 700;
    font-size: 1.2rem;
}

.old-price {
    color: #999;
    font-size: 0.85rem;
    text-decoration: line-through;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-buy-now {
    flex: 1;
    background: linear-gradient(135deg, #ff4757, #ff6b81);
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(255,71,87,0.2);
}

.btn-buy-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,71,87,0.3);
}

.add-to-cart-form {
    flex: 1;
}

.btn-add-to-cart {
    width: 100%;
    background: white;
    color: #333;
    border: 1px solid #ddd;
    padding: 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-add-to-cart:hover {
    background: #ff4757;
    color: white;
    border-color: #ff4757;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,71,87,0.2);
}

/* Animation for add to cart */
@keyframes addToCart {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(0.95);
    }
    100% {
        transform: scale(1);
    }
}

.btn-add-to-cart.adding {
    animation: addToCart 0.3s ease;
    background: #ff4757;
    color: white;
    border-color: #ff4757;
}

.btn-add-to-cart.added {
    background: #2ecc71;
    color: white;
    border-color: #2ecc71;
}

/* Responsive */
@media (max-width: 768px) {
    .product-grid-modern {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }
    
    .product-info {
        padding: 1rem;
    }
    
    .product-name {
        font-size: 0.9rem;
        height: 2.7em;
    }
    
    .current-price {
        font-size: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .quick-actions {
        display: none;
    }
}

</style>

<div class="container" style="display: flex; gap: 2rem; margin-top: 2rem; margin-bottom: 3rem; align-items: flex-start;">
    
     <aside class="filter-sidebar">
        <div class="filter-header">
            <h3 class="filter-title">
                <i class="fas fa-sliders-h"></i>
                Bộ lọc sản phẩm
            </h3>
            <a href="/shop_giay/product/index" class="filter-reset" title="Xóa bộ lọc">
                <i class="fas fa-redo-alt"></i>
            </a>
        </div>

        <!-- Filter: Giới tính -->
        <div class="filter-section">
            <div class="filter-section-header" onclick="toggleFilter(this)">
                <span class="filter-section-title">
                    <i class="fas fa-venus-mars"></i>
                    Giới tính
                </span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="filter-section-content">
                <div class="filter-options">
                    <a href="/shop_giay/product/index?gender=Men" 
                       class="filter-option <?= ($data['currentGender'] == 'Men') ? 'active' : '' ?>">
                        <span class="option-icon"><i class="fas fa-mars"></i></span>
                        <span class="option-text">Giày Nam</span>
                        <span class="option-count">(<?= $data['genderCounts']['Men'] ?? 0 ?>)</span>
                    </a>
                    <a href="/shop_giay/product/index?gender=Women" 
                       class="filter-option <?= ($data['currentGender'] == 'Women') ? 'active' : '' ?>">
                        <span class="option-icon"><i class="fas fa-venus"></i></span>
                        <span class="option-text">Giày Nữ</span>
                        <span class="option-count">(<?= $data['genderCounts']['Women'] ?? 0 ?>)</span>
                    </a>
                    <a href="/shop_giay/product/index?gender=Unisex" 
                       class="filter-option <?= ($data['currentGender'] == 'Unisex') ? 'active' : '' ?>">
                        <span class="option-icon"><i class="fas fa-genderless"></i></span>
                        <span class="option-text">Unisex</span>
                        <span class="option-count">(<?= $data['genderCounts']['Unisex'] ?? 0 ?>)</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter: Bộ sưu tập -->
        <div class="filter-section">
            <div class="filter-section-header" onclick="toggleFilter(this)">
                <span class="filter-section-title">
                    <i class="fas fa-layer-group"></i>
                    Bộ sưu tập
                </span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="filter-section-content">
                <div class="filter-options">
                    <a href="/shop_giay/product/index" 
                       class="filter-option <?= empty($data['currentCollection']) ? 'active' : '' ?>">
                        <span class="option-dot" style="background: #667eea"></span>
                        <span class="option-text">Tất cả sản phẩm</span>
                        <span class="option-count">(<?= array_sum($data['genderCounts']) ?? 0 ?>)</span>
                    </a>
                    <?php foreach ($data['collections'] as $index => $col): ?>
                        <a href="/shop_giay/product/index?collection=<?= $col['slug'] ?>" 
                           class="filter-option <?= ($data['currentCollection'] == $col['slug']) ? 'active' : '' ?>">
                            <span class="option-dot" style="background: <?= 
                                $index == 0 ? '#ff6b6b' : 
                                ($index == 1 ? '#4ecdc4' : 
                                ($index == 2 ? '#45b7d1' : 
                                ($index == 3 ? '#96ceb4' : 
                                ($index == 4 ? '#ffeaa7' : '#667eea')))) ?>">
                            </span>
                            <span class="option-text"><?= htmlspecialchars($col['name']) ?></span>
                            <span class="option-count">(<?= $data['collectionCounts'][$col['slug']] ?? 0 ?>)</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Filter: Khoảng giá -->
        <div class="filter-section">
            <div class="filter-section-header" onclick="toggleFilter(this)">
                <span class="filter-section-title">
                    <i class="fas fa-tag"></i>
                    Khoảng giá
                </span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="filter-section-content">
                <div class="price-presets">
                    <a href="/shop_giay/product/index?max_price=500000" class="price-preset">Dưới 500k</a>
                    <a href="/shop_giay/product/index?min_price=500000&max_price=1000000" class="price-preset">500k - 1tr</a>
                    <a href="/shop_giay/product/index?min_price=1000000&max_price=2000000" class="price-preset">1tr - 2tr</a>
                    <a href="/shop_giay/product/index?min_price=2000000&max_price=3000000" class="price-preset">2tr - 3tr</a>
                    <a href="/shop_giay/product/index?min_price=3000000" class="price-preset">Trên 3tr</a>
                </div>
                
                <div class="price-range-custom">
                    <div class="price-inputs">
                        <div class="price-input-group">
                            <input type="number" id="min-price" placeholder="0" value="<?= $_GET['min_price'] ?? '' ?>">
                        </div>
                        <span class="price-separator">-</span>
                        <div class="price-input-group">
                            <input type="number" id="max-price" placeholder="5.000.000" value="<?= $_GET['max_price'] ?? '' ?>">
                        </div>
                    </div>
                    <button onclick="applyPriceFilter()" class="apply-price-btn">
                        <i class="fas fa-check"></i> Áp dụng
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter: Size -->
        <div class="filter-section">
            <div class="filter-section-header" onclick="toggleFilter(this)">
                <span class="filter-section-title">
                    <i class="fas fa-ruler"></i>
                    Size
                </span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
            <div class="filter-section-content">
                <div class="size-grid">
                    <?php foreach ($data['sizes'] as $size): 
                        $count = $data['sizeCounts'][$size] ?? 0;
                    ?>
                        <a href="/shop_giay/product/index?size=<?= $size ?>" 
                           class="size-item <?= ($data['currentSize'] == $size) ? 'active' : '' ?>">
                            <?= $size ?>
                            <small style="font-size: 0.7rem; margin-left: 2px;">(<?= $count ?>)</small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </aside> 

    <div style="flex: 1;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="margin: 0; font-size: 1.8rem; font-weight: 700; color: #333; position: relative; padding-bottom: 10px;">
            <?= htmlspecialchars($data['title']) ?>
            <span style="position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: linear-gradient(90deg, #ff4757, #ff6b81); border-radius: 2px;"></span>
        </h2>
        <span style="color: #666; font-size: 1rem; background: #f5f5f5; padding: 5px 15px; border-radius: 30px;">
            <i class="fas fa-box" style="margin-right: 5px; color: #ff4757;"></i>
            <?= count($data['products']) ?> sản phẩm
        </span>
    </div>

    <?php if (empty($data['products'])): ?>
        <div style="text-align: center; padding: 5rem; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <i class="fas fa-box-open" style="font-size: 5rem; color: #adb5bd; margin-bottom: 1.5rem; opacity: 0.5;"></i>
            <h3 style="color: #495057; margin-bottom: 1rem;">Không tìm thấy sản phẩm</h3>
            <p style="color: #6c757d; margin-bottom: 2rem;">Không có sản phẩm nào phù hợp với tiêu chí của bạn.</p>
            <a href="/shop_giay/product/index" class="btn" style="background: linear-gradient(135deg, #ff4757, #ff6b81); color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 5px 15px rgba(255,71,87,0.3); transition: all 0.3s;">
                <i class="fas fa-arrow-left"></i> Xem tất cả sản phẩm
            </a>
        </div>
    <?php else: ?>
       
        <!-- Product Grid Modern -->
    <div class="product-grid-modern" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
    <?php foreach ($data['products'] as $product): ?>
        <div class="product-card-modern" data-product-id="<?= $product['id'] ?>">
            <!-- Product Badges -->
            <div class="product-badges">
                <?php if (($product['discount_percent'] ?? 0) > 0): ?>
                    <span class="badge discount">-<?= $product['discount_percent'] ?>%</span>
                <?php endif; ?>
                <?php if ($product['is_new'] ?? false): ?>
                    <span class="badge new">Mới</span>
                <?php endif; ?>
            </div>
                    
                    <!-- Product Image -->
                    <div class="product-image-wrapper">
                <a href="/shop_giay/product/detail/<?= $product['slug'] ?>" class="product-link">
                    <img src="<?= htmlspecialchars($product['primary_image'] ?? '/public/images/no-image.png') ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         class="product-image front">
                    <?php if (!empty($product['hover_image'])): ?>
                        <img src="<?= htmlspecialchars($product['hover_image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>"
                             class="product-image hover">
                    <?php endif; ?>
                </a>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <button class="quick-action-btn" onclick="quickView(<?= $product['id'] ?>)" title="Xem nhanh">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="quick-action-btn" onclick="addToWishlist(<?= $product['id'] ?>)" title="Thêm vào yêu thích">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="quick-action-btn" onclick="compareProduct(<?= $product['id'] ?>)" title="So sánh">
                        <i class="fas fa-chart-bar"></i>
                    </button>
                </div>
            </div>
                    
                    <!-- Product Info -->
                    <div class="product-info">
                <!-- Category/Collection -->
                <div class="product-category">
                    <?= htmlspecialchars($product['collection_name'] ?? 'BST Mới') ?>
                </div>

                <!-- Product Name -->
                <h3 class="product-name">
                    <a href="/shop_giay/product/detail/<?= $product['slug'] ?>">
                        <?= htmlspecialchars($product['name']) ?>
                    </a>
                </h3>

                <!-- Rating -->
                <div class="product-rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= ($product['rating'] ?? 5) ? 'active' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-count">(<?= number_format($product['review_count'] ?? 0) ?> đánh giá)</span>
                </div>
                        
                        <!-- Price -->
                        <div class="product-price">
                    <span class="current-price"><?= isset($product['price']) ? number_format($product['price'], 0, ',', '.') . 'đ' : 'Liên hệ' ?></span>
                    <?php if (!empty($product['old_price'])): ?>
                        <span class="old-price"><?= number_format($product['old_price'], 0, ',', '.') ?>đ</span>
                    <?php endif; ?>
                </div>
                        
                        <!-- Action Buttons -->
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</div>

<script>
function toggleFilter(header) {
    const section = header.closest('.filter-section');
    section.classList.toggle('collapsed');
}

function applyPriceFilter() {
    const minPrice = document.getElementById('min-price').value;
    const maxPrice = document.getElementById('max-price').value;
    
    // Validate
    if (minPrice && maxPrice && parseInt(minPrice) > parseInt(maxPrice)) {
        alert('Giá tối thiểu không thể lớn hơn giá tối đa!');
        return;
    }
    
    let url = '/shop_giay/product/index?';
    
    // Giữ nguyên các filter hiện tại
    const currentUrl = new URL(window.location.href);
    const params = ['gender', 'collection', 'category', 'size'];
    
    params.forEach(param => {
        const value = currentUrl.searchParams.get(param);
        if (value) {
            url += param + '=' + encodeURIComponent(value) + '&';
        }
    });
    
    if (minPrice) url += 'min_price=' + minPrice + '&';
    if (maxPrice) url += 'max_price=' + maxPrice + '&';
    
    // Xóa dấu & hoặc ? thừa ở cuối
    url = url.replace(/[?&]$/, '');
    
    if (url === '/shop_giay/product/index?' || url === '/shop_giay/product/index') {
        window.location.href = '/shop_giay/product/index';
    } else {
        window.location.href = url;
    }
}

// Tự động đóng/mở các section khi load trang
document.addEventListener('DOMContentLoaded', function() {
    // Mặc định mở tất cả các section
    const sections = document.querySelectorAll('.filter-section');
    sections.forEach(section => {
        section.classList.remove('collapsed');
    });
});

// Add to cart function
function addToCart(event, form) {
    event.preventDefault();
    
    const button = form.querySelector('.btn-add-to-cart');
    const originalText = button.innerHTML;
    
    // Show loading state
    button.classList.add('adding');
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    
    // Send AJAX request
    fetch('/shop_giay/cart/add', {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success state
            button.classList.remove('adding');
            button.classList.add('added');
            button.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
            
            // Update cart count in header
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
                cartCount.classList.add('pulse');
                setTimeout(() => cartCount.classList.remove('pulse'), 300);
            }
            
            // Show success notification
            showNotification('Đã thêm vào giỏ hàng!', 'success');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                button.classList.remove('added');
                button.innerHTML = originalText;
            }, 2000);
        } else {
            // Error state
            button.classList.remove('adding');
            button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Lỗi';
            showNotification('Có lỗi xảy ra!', 'error');
            
            setTimeout(() => {
                button.innerHTML = originalText;
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.classList.remove('adding');
        button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Lỗi';
        showNotification('Lỗi kết nối!', 'error');
        
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    });
    
    return false;
}

// Quick view function
function quickView(productId) {
    // You can implement modal here
    console.log('Quick view product:', productId);
    showNotification('Tính năng đang phát triển', 'info');
}

// Add to wishlist function
function addToWishlist(productId) {
    const button = event.currentTarget;
    const icon = button.querySelector('i');
    
    // Show loading
    icon.className = 'fas fa-spinner fa-spin';
    
    fetch('/shop_giay/wishlist/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            icon.className = 'fas fa-heart';
            icon.style.color = '#ff4757';
            showNotification('Đã thêm vào yêu thích!', 'success');
        } else {
            icon.className = 'far fa-heart';
            showNotification('Có lỗi xảy ra!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        icon.className = 'far fa-heart';
        showNotification('Lỗi kết nối!', 'error');
    });
}

// Compare function
function compareProduct(productId) {
    showNotification('Tính năng đang phát triển', 'info');
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 24px;
        background: ${type === 'success' ? '#ff4757' : type === 'error' ? '#dc3545' : '#3498db'};
        color: white;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: slideIn 0.3s ease;
    `;
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add keyframe animations
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
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .cart-count.pulse {
        animation: pulse 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>

<?php include 'app/views/layouts/footer.php'; ?>