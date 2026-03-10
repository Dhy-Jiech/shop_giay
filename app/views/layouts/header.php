<!-- app/views/layouts/header.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'ĐỚ Store - Giày thể thao chính hãng' ?></title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/shop_giay/public/css/style.css">
</head>
<body>

<!-- Header -->
<header class="header">
    <!-- Top bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <span><i class="fas fa-truck"></i> Miễn phí vận chuyển cho đơn hàng từ 500K</span>
                    <span><i class="fas fa-phone-alt"></i> Hotline: 1900 1234</span>
                </div>
                <div class="top-bar-right">
                    <?php if(isset($_SESSION['user_id']) || isset($_SESSION['customer_id'])): ?>
                        <span><i class="fas fa-user"></i> Xin chào, <?= $_SESSION['full_name'] ?? $_SESSION['customer_name'] ?? 'User' ?></span>
                        <a href="/shop_giay/auth/logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                    <?php else: ?>
                        <a href="/shop_giay/auth/login"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        <a href="/shop_giay/auth/register"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main header -->
    <div class="main-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <a href="/shop_giay/home/index" class="logo">
                    <span class="logo-text">ĐỚ<span>HA</span></span>
                    <span class="logo-slogan">Sneaker Store</span>
                </a>

                <!-- Search bar -->
                <div class="search-wrapper">
                    <form action="/shop_giay/product/index" method="GET" class="search-form">
                        <input type="text" 
                               name="q" 
                               class="search-input" 
                               placeholder="Tìm kiếm giày, phụ kiện..." 
                               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Header actions -->
                <div class="header-actions">
                    <a href="/shop_giay/cart/index" class="action-item cart">
                        <div class="icon-wrapper">
                            <i class="fas fa-shopping-bag"></i>
                            <?php 
                            $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                            if($cart_count > 0): 
                            ?>
                                <span class="cart-count"><?= $cart_count ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="action-text">Giỏ hàng</span>
                    </a>

                    <?php if(isset($_SESSION['user_id']) || isset($_SESSION['customer_id'])): ?>
                        <div class="action-item user-menu">
                            <div class="user-info">
                                <div class="icon-wrapper">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <span class="action-text">Tài khoản</span>
                            </div>
                            <div class="dropdown-menu">
                                <a href="/shop_giay/user/profile"><i class="fas fa-user"></i> Thông tin cá nhân</a>
                                <a href="/shop_giay/order/history"><i class="fas fa-history"></i> Lịch sử đơn hàng</a>
                                <a href="/shop_giay/user/changePassword"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                                <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="/shop_giay/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Quản trị</a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="/shop_giay/auth/logout" class="text-danger"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/shop_giay/auth/login" class="action-item">
                            <div class="icon-wrapper">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="action-text">Đăng nhập</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation menu -->
    <nav class="nav-menu">
        <div class="container">
            <ul class="nav-list">
                <li class="nav-item <?= basename($_SERVER['REQUEST_URI']) == 'home' || $_SERVER['REQUEST_URI'] == '/shop_giay/' ? 'active' : '' ?>">
                    <a href="/shop_giay/home/index"><i class="fas fa-home"></i> Trang chủ</a>
                </li>
                <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'product') !== false ? 'active' : '' ?>">
                    <a href="/shop_giay/product/index"><i class="fas fa-shoe-prints"></i> Sản phẩm</a>
                </li>
                <li class="nav-item has-megamenu">
                    <a href="#"><i class="fas fa-tags"></i> Danh mục <i class="fas fa-chevron-down"></i></a>
                    <div class="megamenu">
                        <div class="megamenu-content">
                            <div class="row">
                                <div class="col">
                                    <h4>Giày Nam</h4>
                                    <a href="/shop_giay/product/index?category=1&gender=Men">Giày thể thao</a>
                                    <a href="/shop_giay/product/index?category=2&gender=Men">Giày chạy bộ</a>
                                    <a href="/shop_giay/product/index?category=3&gender=Men">Giày bóng rổ</a>
                                    <a href="/shop_giay/product/index?category=4&gender=Men">Giày thời trang</a>
                                </div>
                                <div class="col">
                                    <h4>Giày Nữ</h4>
                                    <a href="/shop_giay/product/index?category=1&gender=Women">Giày thể thao</a>
                                    <a href="/shop_giay/product/index?category=2&gender=Women">Giày chạy bộ</a>
                                    <a href="/shop_giay/product/index?category=5&gender=Women">Giày cao gót</a>
                                    <a href="/shop_giay/product/index?category=6&gender=Women">Sandal</a>
                                </div>
                                <div class="col">
                                    <h4>Phụ kiện</h4>
                                    <a href="/shop_giay/product/index?category=7">Tất/vớ</a>
                                    <a href="/shop_giay/product/index?category=8">Dây giày</a>
                                    <a href="/shop_giay/product/index?category=9">Balo/túi</a>
                                    <a href="/shop_giay/product/index?category=10">Nước vệ sinh giày</a>
                                </div>
                                <div class="col highlight">
                                    <h4>Sale Off</h4>
                                    <a href="/shop_giay/product/index?discount=true" class="sale-link">Giảm đến 50%</a>
                                    <img src="/shop_giay/public/images/sale-banner.jpg" alt="Sale" class="menu-banner">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'about') !== false ? 'active' : '' ?>">
                    <a href="/shop_giay/home/about"><i class="fas fa-info-circle"></i> Về Đớ</a>
                </li>
                <li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], 'tracking') !== false ? 'active' : '' ?>">
                    <a href="/shop_giay/order/tracking"><i class="fas fa-map-marker-alt"></i> Tra cứu đơn</a>
                </li>
                <li class="nav-item">
                    <a href="/shop_giay/home/news"><i class="fas fa-newspaper"></i> Tin tức</a>
                </li>
                <li class="nav-item">
                    <a href="/shop_giay/home/contact"><i class="fas fa-envelope"></i> Liên hệ</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main class="main-content">