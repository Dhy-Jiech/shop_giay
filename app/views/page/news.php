<?php include 'app/views/layouts/header.php'; ?>

<style>
.news-page {
    padding: 60px 0;
    background: #f8f9fa;
}
.news-header {
    text-align: center;
    margin-bottom: 50px;
}
.news-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #333;
    margin-bottom: 15px;
}
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.news-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}
.news-card:hover {
    transform: translateY(-10px);
}
.news-image {
    height: 200px;
    background: #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.news-content {
    padding: 25px;
}
.news-date {
    font-size: 0.85rem;
    color: #ff4757;
    font-weight: 600;
    margin-bottom: 10px;
    display: block;
}
.news-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
    line-height: 1.4;
}
.news-excerpt {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
}
.read-more {
    color: #333;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s;
}
.read-more:hover {
    color: #ff4757;
}
</style>

<div class="news-page">
    <div class="container">
        <div class="news-header">
            <h1 class="news-title">Tin tức mới nhất</h1>
            <p>Cập nhật những thông tin mới nhất về thời trang và sneakers</p>
        </div>

        <div class="news-grid">
            <!-- BẮT ĐẦU ĐOẠN TIN TỨC: Bạn có thể sao chép đoạn này để thêm bài viết mới -->
            <article class="news-card">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=800&q=80" alt="News 1">
                </div>
                <div class="news-content">
                    <span class="news-date">16 Tháng 3, 2024</span>
                    <h3 class="news-card-title">Top 5 đôi giày Marvel đang làm mưa làm gió hiện nay</h3>
                    <p class="news-excerpt">Khám phá danh sách những đôi giày lấy cảm hứng từ vũ trụ Marvel với thiết kế cực ngầu...</p>
                    <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
            <!-- KẾT THÚC ĐOẠN TIN TỨC -->

            <article class="news-card">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80" alt="News 2">
                </div>
                <div class="news-content">
                    <span class="news-date">14 Tháng 3, 2024</span>
                    <h3 class="news-card-title">Cách vệ sinh giày Sneaker trắng như mới tại nhà</h3>
                    <p class="news-excerpt">Mẹo đơn giản giúp đôi giày của bạn luôn trắng sáng mà không cần tốn quá nhiều chi phí...</p>
                    <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="news-card">
                <div class="news-image">
                    <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&q=80" alt="News 3">
                </div>
                <div class="news-content">
                    <span class="news-date">12 Tháng 3, 2024</span>
                    <h3 class="news-card-title">Xu hướng thời trang dạo phố năm 2024</h3>
                    <p class="news-excerpt">Những phong cách phối đồ cực đỉnh kết hợp cùng giày sneaker đang dẫn đầu xu hướng...</p>
                    <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
