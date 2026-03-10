<?php include 'app/views/layouts/header.php'; ?>

<!-- Hero Section với Slideshow -->
<section class="hero-section">
    <div class="hero-slider">
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-bg-1.jpg')">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Bộ sưu tập mới 2026</span>
                    <h1 class="hero-title">THỂ HIỆN <span class="highlight">CHẤT RIÊNG</span><br>CÙNG ĐỚ</h1>
                    <p class="hero-description">Khám phá những mẫu giày thể thao thiết kế độc quyền, phong cách hiện đại và cực kỳ thoải mái.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Mua ngay
                        </a>
                        <a href="/shop_giay/collection/index" class="btn btn-outline-light btn-large">
                            <i class="fas fa-eye"></i>
                            Xem bộ sưu tập
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Thêm các slide khác nếu cần -->
    </div>
    
    <!-- Slider Controls -->
    <div class="slider-controls">
        <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
    </div>
    
    <div class="slider-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="feature-content">
                    <h3>Miễn phí vận chuyển</h3>
                    <p>Cho đơn hàng từ 500.000đ</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="feature-content">
                    <h3>Đổi trả dễ dàng</h3>
                    <p>30 ngày miễn phí đổi trả</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-content">
                    <h3>Bảo hành chính hãng</h3>
                    <p>12 tháng bảo hành sản phẩm</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="feature-content">
                    <h3>Quà tặng hấp dẫn</h3>
                    <p>Nhiều ưu đãi bất ngờ</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Danh mục nổi bật</h2>
            <p class="section-subtitle">Khám phá các dòng giày được yêu thích nhất</p>
        </div>
        
        <div class="categories-grid">
            <div class="category-card large">
                <img src="/shop_giay/public/images/cat-men.jpg" alt="Giày Nam">
                <div class="category-overlay">
                    <h3>Giày Nam</h3>
                    <a href="/shop_giay/product/index?gender=Men" class="btn btn-outline-light btn-sm">Xem ngay</a>
                </div>
            </div>
            <div class="category-card">
                <img src="/shop_giay/public/images/cat-women.jpg" alt="Giày Nữ">
                <div class="category-overlay">
                    <h3>Giày Nữ</h3>
                    <a href="/shop_giay/product/index?gender=Women" class="btn btn-outline-light btn-sm">Xem ngay</a>
                </div>
            </div>
            <div class="category-card">
                <img src="/shop_giay/public/images/cat-sport.jpg" alt="Giày Thể Thao">
                <div class="category-overlay">
                    <h3>Thể thao</h3>
                    <a href="/shop_giay/product/index?category=sport" class="btn btn-outline-light btn-sm">Xem ngay</a>
                </div>
            </div>
            <div class="category-card">
                <img src="/shop_giay/public/images/cat-casual.jpg" alt="Giày Casual">
                <div class="category-overlay">
                    <h3>Casual</h3>
                    <a href="/shop_giay/product/index?category=casual" class="btn btn-outline-light btn-sm">Xem ngay</a>
                </div>
            </div>
            <div class="category-card">
                <img src="/shop_giay/public/images/cat-accessories.jpg" alt="Phụ kiện">
                <div class="category-overlay">
                    <h3>Phụ kiện</h3>
                    <a href="/shop_giay/product/index?category=accessories" class="btn btn-outline-light btn-sm">Xem ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Collections Section -->
<section class="collections-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Bộ sưu tập</h2>
            <p class="section-subtitle">Khám phá các BST độc quyền từ ĐỚ</p>
        </div>
        
        <div class="collections-tabs">
            <?php foreach ($data['collections'] as $index => $collection): ?>
                <button class="collection-tab <?= $index === 0 ? 'active' : '' ?>" 
                        data-collection="<?= $collection['slug'] ?>">
                    <?= htmlspecialchars($collection['name']) ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <div class="collections-content">
            <?php foreach ($data['collections'] as $index => $collection): ?>
                <div class="collection-panel <?= $index === 0 ? 'active' : '' ?>" 
                     id="collection-<?= $collection['slug'] ?>">
                    <div class="collection-banner">
                        <img src="/shop_giay/public/images/collection-<?= $collection['slug'] ?>.jpg" 
                             alt="<?= htmlspecialchars($collection['name']) ?>">
                        <div class="banner-content">
                            <h3><?= htmlspecialchars($collection['name']) ?></h3>
                            <p><?= htmlspecialchars($collection['description'] ?? '') ?></p>
                            <a href="/shop_giay/product/index?collection=<?= $collection['slug'] ?>" 
                               class="btn btn-primary">
                                Xem tất cả <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Sản phẩm mới nhất</h2>
            <p class="section-subtitle">Cập nhật xu hướng mới nhất với những thiết kế độc đáo</p>
        </div>
        
        <div class="product-filters">
            <button class="filter-btn active" data-filter="all">Tất cả</button>
            <button class="filter-btn" data-filter="new">Mới nhất</button>
            <button class="filter-btn" data-filter="trending">Xu hướng</button>
            <button class="filter-btn" data-filter="sale">Đang giảm giá</button>
        </div>
        
        <div class="product-grid">
            <?php foreach ($data['products'] as $product): ?>
                <div class="product-card" data-category="<?= $product['category_slug'] ?? '' ?>">
                    <div class="product-badges">
                        <?php if ($product['is_new'] ?? false): ?>
                            <span class="badge new">Mới</span>
                        <?php endif; ?>
                        <?php if (($product['discount_percent'] ?? 0) > 0): ?>
                            <span class="badge sale">-<?= $product['discount_percent'] ?>%</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-image-wrapper">
                        <a href="/shop_giay/product/detail/<?= $product['slug'] ?>">
                            <img src="<?= htmlspecialchars($product['primary_image']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>" 
                                 class="product-image front">
                            <?php if (!empty($product['hover_image'])): ?>
                                <img src="<?= htmlspecialchars($product['hover_image']) ?>" 
                                     alt="<?= htmlspecialchars($product['name']) ?>" 
                                     class="product-image hover">
                            <?php endif; ?>
                        </a>
                        
                        <div class="product-actions">
                            <button class="action-btn quick-view" 
                                    data-product-id="<?= $product['id'] ?>"
                                    title="Xem nhanh">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn add-to-wishlist" 
                                    data-product-id="<?= $product['id'] ?>"
                                    title="Thêm vào yêu thích">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn add-to-compare" 
                                    data-product-id="<?= $product['id'] ?>"
                                    title="So sánh">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                        </div>
                        
                        <form action="/shop_giay/cart/add" method="POST" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="variant_id" value="<?= $product['default_variant_id'] ?? '' ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Thêm vào giỏ</span>
                            </button>
                        </form>
                    </div>
                    
                    <div class="product-info">
                        <p class="product-category"><?= htmlspecialchars($product['category_name'] ?? '') ?></p>
                        <a href="/shop_giay/product/detail/<?= $product['slug'] ?>" class="product-title-link">
                            <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                        </a>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?= $i <= ($product['rating'] ?? 5) ? 'active' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-count">(<?= number_format($product['review_count'] ?? 0) ?>)</span>
                        </div>
                        
                        <div class="product-price-wrapper">
                            <?php if (!empty($product['old_price'])): ?>
                                <span class="old-price"><?= number_format($product['old_price'], 0, ',', '.') ?>đ</span>
                            <?php endif; ?>
                            <span class="current-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-footer">
            <a href="/shop_giay/product/index" class="btn btn-outline-primary">
                Xem tất cả sản phẩm <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Banner Section -->
<section class="banner-section">
    <div class="container">
        <div class="banner-grid">
            <div class="banner-item">
                <img src="/shop_giay/public/images/banner-1.jpg" alt="Summer Sale">
                <div class="banner-content">
                    <span class="banner-tag">Summer Sale</span>
                    <h3>Giảm đến 50%</h3>
                    <p>Cho các mẫu giày thể thao mới nhất</p>
                    <a href="/shop_giay/product/index?sale=true" class="btn btn-primary btn-sm">Mua ngay</a>
                </div>
            </div>
            <div class="banner-item">
                <img src="/shop_giay/public/images/banner-2.jpg" alt="New Collection">
                <div class="banner-content">
                    <span class="banner-tag">New</span>
                    <h3>Bộ sưu tập mới</h3>
                    <p>Khám phá phong cách thời thượng</p>
                    <a href="/shop_giay/collection/new" class="btn btn-primary btn-sm">Khám phá</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Brands Section -->




<!-- Quick View Modal -->
<div class="modal" id="quickViewModal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="quick-view-content"></div>
    </div>
</div>

<!-- Add CSS cho các section mới -->
<style>
/* Hero Section */
.hero-section {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.hero-slider .slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.hero-slider .slide.active {
    opacity: 1;
}

.hero-content {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    max-width: 600px;
}

.hero-subtitle {
    font-size: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 1rem;
    display: block;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.hero-title .highlight {
    color: var(--secondary-color);
}

.hero-description {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
}

.btn-large {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.btn-outline-light {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline-light:hover {
    background: white;
    color: var(--primary-color);
}

.slider-controls {
    position: absolute;
    top: 50%;
    width: 100%;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
}

.slider-controls button {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    transition: var(--transition);
}

.slider-controls button:hover {
    background: white;
    color: var(--primary-color);
}

.slider-dots {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: var(--transition);
}

.dot.active {
    background: white;
    transform: scale(1.2);
}

/* Features Section */
.features-section {
    padding: 60px 0;
    background: white;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: var(--light-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--secondary-color);
}

.feature-content h3 {
    font-size: 1rem;
    margin-bottom: 5px;
}

.feature-content p {
    font-size: 0.9rem;
    color: var(--text-light);
}

/* Categories Section */
.categories-section {
    padding: 60px 0;
    background: var(--light-bg);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.category-card {
    position: relative;
    height: 300px;
    overflow: hidden;
    border-radius: 10px;
}

.category-card.large {
    grid-row: span 2;
    height: 620px;
}

.category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover img {
    transform: scale(1.1);
}

.category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 30px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
}

.category-overlay h3 {
    margin-bottom: 10px;
}

/* Collections Section */
.collections-section {
    padding: 60px 0;
    background: white;
}

.collections-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}

.collection-tab {
    padding: 10px 20px;
    border: 1px solid var(--border-color);
    background: white;
    border-radius: 30px;
    cursor: pointer;
    transition: var(--transition);
}

.collection-tab:hover,
.collection-tab.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.collection-panel {
    display: none;
}

.collection-panel.active {
    display: block;
}

.collection-banner {
    position: relative;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
}

.collection-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    background: rgba(0,0,0,0.6);
    padding: 40px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
}

/* Products Section */
.products-section {
    padding: 60px 0;
    background: var(--light-bg);
}

.product-filters {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}

.filter-btn {
    padding: 8px 20px;
    border: 1px solid var(--border-color);
    background: white;
    border-radius: 30px;
    cursor: pointer;
    transition: var(--transition);
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

.product-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.product-badges {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

.badge {
    padding: 4px 8px;
    border-radius: 3px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge.new {
    background: var(--accent-color);
    color: white;
}

.badge.sale {
    background: var(--secondary-color);
    color: white;
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
}

.product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.product-image.hover {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.product-card:hover .product-image.front {
    opacity: 0;
}

.product-card:hover .product-image.hover {
    opacity: 1;
}

.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    opacity: 0;
    transform: translateX(20px);
    transition: var(--transition);
}

.product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: white;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
}

.btn-add-to-cart {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 12px;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transform: translateY(100%);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.product-card:hover .btn-add-to-cart {
    transform: translateY(0);
}

.btn-add-to-cart:hover {
    background: var(--secondary-color);
}

.product-info {
    padding: 15px;
}

.product-category {
    font-size: 0.8rem;
    color: var(--text-light);
    margin-bottom: 5px;
}

.product-title-link {
    text-decoration: none;
    color: inherit;
}

.product-title {
    font-size: 1rem;
    margin-bottom: 8px;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 8px;
}

.stars i {
    color: #ddd;
    font-size: 0.8rem;
}

.stars i.active {
    color: #f1c40f;
}

.rating-count {
    font-size: 0.8rem;
    color: var(--text-light);
}

.product-price-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.old-price {
    font-size: 0.9rem;
    color: var(--text-light);
    text-decoration: line-through;
}

.current-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--secondary-color);
}

/* Banner Section */
.banner-section {
    padding: 60px 0;
    background: white;
}

.banner-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.banner-item {
    position: relative;
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
}

.banner-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-content {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 40px;
    background: linear-gradient(to right, rgba(0,0,0,0.7), transparent);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.banner-tag {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 10px;
    display: block;
}

.banner-content h3 {
    font-size: 2rem;
    margin-bottom: 10px;
}

/* Testimonials Section */
.testimonials-section {
    padding: 60px 0;
    background: var(--light-bg);
}

.testimonials-slider {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.testimonial-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: var(--shadow);
}

.testimonial-rating {
    color: #f1c40f;
    margin-bottom: 15px;
}

.testimonial-text {
    font-style: italic;
    margin-bottom: 20px;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
}

.testimonial-author img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-author h4 {
    font-size: 1rem;
    margin-bottom: 5px;
}

.testimonial-author p {
    font-size: 0.8rem;
    color: var(--text-light);
}

/* Brands Section */
.brands-section {
    padding: 40px 0;
    background: white;
}

.brands-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 30px;
    align-items: center;
}

.brand-item img {
    max-width: 100%;
    filter: grayscale(100%);
    opacity: 0.5;
    transition: var(--transition);
}

.brand-item:hover img {
    filter: grayscale(0);
    opacity: 1;
}

/* Newsletter Section */
.newsletter-section {
    padding: 60px 0;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
}

.newsletter-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
}

.newsletter-content h3 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.newsletter-content p {
    opacity: 0.9;
}

.newsletter-form .form-group {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.newsletter-form input[type="email"] {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 30px;
    outline: none;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
}

.checkbox-label a {
    color: white;
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 1024px) {
    .features-grid,
    .categories-grid,
    .product-grid,
    .testimonials-slider,
    .brands-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .hero-section {
        height: 500px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-buttons {
        flex-direction: column;
    }
    
    .features-grid,
    .categories-grid,
    .product-grid,
    .testimonials-slider,
    .brands-grid,
    .banner-grid,
    .newsletter-wrapper {
        grid-template-columns: 1fr;
    }
    
    .collections-tabs {
        flex-wrap: wrap;
    }
}
</style>

<!-- Add JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Slider functionality
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentSlide = 0;
    
    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }
    
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);
    
    // Collection tabs
    const tabs = document.querySelectorAll('.collection-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const collection = this.dataset.collection;
            
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelectorAll('.collection-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            
            document.getElementById(`collection-${collection}`).classList.add('active');
        });
    });
    
    // Product filters
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter products logic here
            const products = document.querySelectorAll('.product-card');
            products.forEach(product => {
                if (filter === 'all') {
                    product.style.display = 'block';
                } else {
                    // Add your filtering logic
                    product.style.display = 'block';
                }
            });
        });
    });
    
    // Quick view modal
    const quickViewBtns = document.querySelectorAll('.quick-view');
    const modal = document.getElementById('quickViewModal');
    const modalClose = document.querySelector('.modal-close');
    
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
            // Fetch product details via AJAX
            fetch(`/shop_giay/product/quickView/${productId}`)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.quick-view-content').innerHTML = html;
                    modal.style.display = 'block';
                });
        });
    });
    
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    window.addEventListener('click', function(e) {
        if (e.target == modal) {
            modal.style.display = 'none';
        }
    });
    
    // Add to cart animation
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const button = this.querySelector('.btn-add-to-cart');
                    const originalText = button.innerHTML;
                    
                    button.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
                    button.style.background = '#2ecc71';
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.style.background = '';
                    }, 2000);
                    
                    // Update cart count
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                        cartCount.classList.add('pulse');
                        setTimeout(() => {
                            cartCount.classList.remove('pulse');
                        }, 300);
                    }
                    
                    showToast('Đã thêm vào giỏ hàng!', 'success');
                }
            });
        });
    });
    
    // Add to wishlist
    const wishlistBtns = document.querySelectorAll('.add-to-wishlist');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
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
                    this.querySelector('i').className = 'fas fa-heart';
                    this.querySelector('i').style.color = '#e74c3c';
                    showToast('Đã thêm vào yêu thích!', 'success');
                }
            });
        });
    });
    
    // Toast function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>