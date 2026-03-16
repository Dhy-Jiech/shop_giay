<?php include 'app/views/layouts/header.php'; ?>

<style>
.contact-page {
    padding: 80px 0;
    background: #fff;
}
.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 50px;
}
.contact-info-section h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #333;
}
.contact-info-list {
    margin: 40px 0;
}
.contact-info-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}
.contact-icon {
    width: 60px;
    height: 60px;
    background: #fff5f6;
    color: #ff4757;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}
.info-text h4 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 5px;
}
.info-text p {
    color: #666;
    line-height: 1.6;
}
.contact-form-section {
    background: #f8f9fa;
    padding: 40px;
    border-radius: 20px;
}
.form-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 30px;
}
.contact-form .form-group {
    margin-bottom: 20px;
}
.contact-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #555;
}
.contact-form .form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}
.contact-form textarea.form-control {
    height: 150px;
    resize: none;
}
.btn-submit {
    background: #ff4757;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    width: 100%;
}
.btn-submit:hover {
    background: #ff6b81;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}
@media (max-width: 968px) {
    .contact-container {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="contact-page">
    <div class="contact-container">
        <div class="contact-info-section">
            <h1>Kết nối với Đớ Store</h1>
            <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn 24/7. Đừng ngần ngại liên hệ!</p>
            
            <div class="contact-info-list">
                <!-- THÔNG TIN ĐỊA CHỈ: Bạn có thể cập nhật bên dưới -->
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-text">
                        <h4>Địa chỉ cửa hàng</h4>
                        <p>123 Đường Phố wall, Quận , Sao Hỏa</p>
                    </div>
                </div>

                <!-- THÔNG TIN ĐIỆN THOẠI: Bạn có thể cập nhật bên dưới -->
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-text">
                        <h4>Hotline hỗ trợ</h4>
                        <p>1900 1234 - (028) 3822 1234</p>
                    </div>
                </div>

                <!-- THÔNG TIN EMAIL: Bạn có thể cập nhật bên dưới -->
                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-text">
                        <h4>Email liên hệ</h4>
                        <p>support@dostore.vn</p>
                        <p>business@dostore.vn</p>
                    </div>
                </div>
            </div>

            <div class="social-links" style="display: flex; gap: 15px;">
                <a href="#" style="font-size: 1.5rem; color: #1877f2;"><i class="fab fa-facebook"></i></a>
                <a href="#" style="font-size: 1.5rem; color: #e4405f;"><i class="fab fa-instagram"></i></a>
                <a href="#" style="font-size: 1.5rem; color: #ff0000;"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="contact-form-section">
            <h3 class="form-title">Gửi tin nhắn cho chúng tôi</h3>
            <form action="#" class="contact-form">
                <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" class="form-control" placeholder="Nhập tên của bạn">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Nhập email">
                </div>
                <div class="form-group">
                    <label>Chủ đề</label>
                    <select class="form-control">
                        <option>Hỗ trợ đơn hàng</option>
                        <option>Tư vấn sản phẩm</option>
                        <option>Khiếu nại/Góp ý</option>
                        <option>Hợp tác kinh doanh</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea class="form-control" placeholder="Bạn muốn nói gì với Đớ?"></textarea>
                </div>
                <button type="button" class="btn-submit">Gửi yêu cầu ngay</button>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
