<?php include 'app/views/layouts/header.php'; ?>

<style>
/* Hero Section */
.hero-section {
    position: relative;
    height: 600px;
    overflow: hidden;
}

.hero-slider {
    position: relative;
    width: 100%;
    height: 100%;
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
    visibility: hidden;
    transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
    z-index: 1;
}

.hero-slider .slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
}

.hero-content {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    max-width: 600px;
    opacity: 1;
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
    z-index: 10;
    pointer-events: none;
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
    pointer-events: auto;
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
    z-index: 10;
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

/* Features Section - Giữ nguyên */
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
    background: #fff;
    overflow: hidden;
}

.collections-tabs {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 35px;
    flex-wrap: wrap;
}

.collection-tab {
    padding: 10px 25px;
    border: 1px solid #e0e0e0;
    background: #fff;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    color: #555;
}

.collection-tab.active {
    background: #020101;
    color: #fff;
    border-color: #000;
}

.collection-panel {
    display: none;
    width: 100%;
    animation: fadeIn 0.5s ease-in-out;
}

.collection-panel.active {
    display: block;
}

.collection-banner {
    position: relative;
    width: 100%;
    height: 550px;
    border-radius: 12px;
    overflow: hidden;
    background: #222;
}

.collection-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    filter: brightness(0.7);
}

.banner-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: rgba(0, 0, 0, 0.35);
    padding: 20px;
    z-index: 2;
}

.banner-content h3 {
    font-size: 3.5rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.banner-content p {
    font-size: 1.1rem;
    max-width: 500px;
    margin-bottom: 25px;
    color: white;
}

.banner-content .btn-primary {
    background: #fff;
    color: #000;
    padding: 12px 35px;
    border-radius: 4px;
    font-weight: 700;
    transition: 0.3s ease;
}

.banner-content .btn-primary:hover {
    background: transparent;
    color: #fff;
    border: 1px solid white;
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

/* Responsive */
@media (max-width: 1024px) {
    .features-grid,
    .categories-grid,
    .product-grid {
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
    .banner-grid {
        grid-template-columns: 1fr;
    }
    
    .collections-tabs {
        flex-wrap: wrap;
    }
    
    .banner-content h3 {
        font-size: 2rem;
    }
}
</style>

<!-- Hero Section với Slideshow -->
<section class="hero-section">
    <div class="hero-slider">
        <!-- Slide 1: Urban Collection -->
        <div class="slide active" 
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-urban.jpg')"
             data-collection="urban-explorer">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Urban Explorer Collection</span>
                    <h1 class="hero-title">PHONG CÁCH <span class="highlight">ĐƯỜNG PHỐ</span><br>CÁ TÍNH</h1>
                    <p class="hero-description">Khám phá BST giày thể thao urban với thiết kế mạnh mẽ, phá cách dành cho giới trẻ.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index?collection=urban-explorer" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2: Elegant Lady Collection -->
        <div class="slide" 
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-elegant.jpg')"
             data-collection="elegant-lady">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Elegant Lady Collection</span>
                    <h1 class="hero-title">THANH LỊCH VÀ <span class="highlight">TINH TẾ</span></h1>
                    <p class="hero-description">BST giày nữ cao cấp với thiết kế sang trọng, tôn lên vẻ đẹp thanh lịch của phái đẹp.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index?collection=elegant-lady" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3: Sport Power Collection -->
        <div class="slide" 
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-sport.jpg')"
             data-collection="sport-power">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Sport Power Collection</span>
                    <h1 class="hero-title">BỨT PHÁ <span class="highlight">GIỚI HẠN</span></h1>
                    <p class="hero-description">Giày thể thao hiệu suất cao với công nghệ đệm tiên tiến, đồng hành cùng mọi vận động.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index?collection=sport-power" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 4: Summer Breeze Collection -->
        <div class="slide" 
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-summer.jpg')"
             data-collection="summer-breeze">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Summer Breeze Collection</span>
                    <h1 class="hero-title">MÁT MẺ - <span class="highlight">THOẢI MÁI</span></h1>
                    <p class="hero-description">BST hè với sandal và giày thoáng mát, đồng hành cùng bạn trong mọi chuyến du lịch.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index?collection=summer-breeze" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 5: Kid Fun Collection -->
        <div class="slide" 
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/shop_giay/public/images/hero-kid.jpg')"
             data-collection="kid-fun">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-subtitle">Kid Fun Collection</span>
                    <h1 class="hero-title">ĐÁNG YÊU - <span class="highlight">AN TOÀN</span></h1>
                    <p class="hero-description">Giày trẻ em với thiết kế ngộ nghĩnh, chất liệu an toàn cho đôi chân của bé.</p>
                    <div class="hero-buttons">
                        <a href="/shop_giay/product/index?collection=kid-fun" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-bag"></i>
                            Khám phá ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Slider Controls -->
    <div class="slider-controls">
        <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
    </div>
    
    <div class="slider-dots">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
        <span class="dot" data-slide="2"></span>
        <span class="dot" data-slide="3"></span>
        <span class="dot" data-slide="4"></span>
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
                        
                        <div class="product-actions-bottom" style="display: flex; gap: 10px; padding: 0 15px 15px;">
                            <a href="/shop_giay/order/buyNow/<?= $product['id'] ?>" class="btn-buy-now" style="flex: 1; background: linear-gradient(135deg, #ff4757, #ff6b81); color: white; text-decoration: none; padding: 10px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.3s; box-shadow: 0 4px 15px rgba(255,71,87,0.2);">
                                <i class="fas fa-bolt"></i>
                                Mua ngay
                            </a>
                            <form action="/shop_giay/cart/add" method="POST" class="add-to-cart-form" style="flex: 1;">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="variant_id" value="<?= $product['default_variant_id'] ?? '' ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-to-cart" style="width: 100%; background: white; color: #333; border: 1px solid #ddd; padding: 10px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.3s; cursor: pointer;">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                </button>
                            </form>
                        </div>
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

<!-- Quick View Modal -->
<div class="modal" id="quickViewModal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="quick-view-content"></div>
    </div>
</div>

<!-- JavaScript - CHỈ MỘT BẢN DUY NHẤT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Slider functionality
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentSlide = 0;
    let slideInterval;
    const totalSlides = slides.length;

    console.log('Total slides:', totalSlides);

    function showSlide(index) {
        if (index < 0) {
            index = totalSlides - 1;
        } else if (index >= totalSlides) {
            index = 0;
        }
        
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        currentSlide = index;
        console.log('Showing slide:', index);
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function startAutoSlide() {
        if (slideInterval) clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoSlide() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
    }

    // Event listeners
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            showSlide(index);
            stopAutoSlide();
            startAutoSlide();
        });
    });

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            prevSlide();
            stopAutoSlide();
            startAutoSlide();
        });
        
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            nextSlide();
            stopAutoSlide();
            startAutoSlide();
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevSlide();
            stopAutoSlide();
            startAutoSlide();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextSlide();
            stopAutoSlide();
            startAutoSlide();
        }
    });

    // Touch events
    let touchStartX = 0;
    let touchEndX = 0;
    const heroSection = document.querySelector('.hero-section');

    if (heroSection) {
        heroSection.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        heroSection.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const swipeThreshold = 50;
            
            if (touchEndX < touchStartX - swipeThreshold) {
                nextSlide();
                stopAutoSlide();
                startAutoSlide();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                prevSlide();
                stopAutoSlide();
                startAutoSlide();
            }
            
            touchStartX = 0;
            touchEndX = 0;
        }, { passive: true });
    }

    // Hover pause
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopAutoSlide);
        heroSection.addEventListener('mouseleave', startAutoSlide);
    }

    // Initialize
    if (totalSlides > 0) {
        showSlide(0);
        startAutoSlide();
    }
    
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
            
            const activePanel = document.getElementById(`collection-${collection}`);
            if (activePanel) activePanel.classList.add('active');
        });
    });
});
</script>

<?php include 'app/views/layouts/footer.php'; ?>