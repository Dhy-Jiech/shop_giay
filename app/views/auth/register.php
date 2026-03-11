<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #d32f2f; /* Màu đỏ thương hiệu ĐỎHA */
        --secondary-color: #333;
        --bg-gray: #f4f7f6;
    }

    body { background-color: var(--bg-gray); }

    .auth-section {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 0;
    }

    .auth-card {
        background: #fff;
        width: 100%;
        max-width: 650px; /* Rộng hơn login để chia 2 cột */
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .auth-header { text-align: center; margin-bottom: 35px; }
    .auth-header h2 { 
        font-weight: 800; 
        color: var(--secondary-color); 
        letter-spacing: -1px;
        margin-bottom: 10px;
    }
    .auth-header p { color: #888; font-size: 0.95rem; }

    /* Chia lưới cho form */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group { margin-bottom: 20px; }
    .form-group.full-width { grid-column: span 2; }

    .form-label { 
        display: block; 
        margin-bottom: 8px; 
        font-weight: 600; 
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #eee;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fdfdfd;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
    }

    .btn-register {
        width: 100%;
        padding: 16px;
        background: var(--secondary-color);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        text-transform: uppercase;
    }

    .btn-register:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .alert-error {
        background: #fff5f5;
        color: #c53030;
        padding: 12px;
        border-radius: 8px;
        border-left: 4px solid #c53030;
        margin-bottom: 25px;
        font-size: 0.9rem;
    }

    .auth-footer {
        text-align: center;
        margin-top: 30px;
        font-size: 0.95rem;
        color: #666;
    }
    .auth-footer a { 
        color: var(--primary-color); 
        text-decoration: none; 
        font-weight: 600;
    }

    /* Responsive cho mobile */
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: span 1; }
        .auth-card { padding: 30px 20px; }
    }
</style>

<div class="auth-section">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Tham gia cùng ĐỚHA</h2>
            <p>Tạo tài khoản để nhận ưu đãi và quản lý đơn hàng tốt hơn</p>
        </div>

        <?php if(isset($data['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <form action="/shop_giay/auth/register" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Họ và tên *</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tên đăng nhập *</label>
                    <input type="text" name="username" class="form-control" placeholder="username123" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@vi du.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" placeholder="090 123 4567">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <input type="text" name="address" class="form-control" placeholder="Số nhà, tên đường, quận/huyện...">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Mật khẩu *</label>
                    <input type="password" name="password" class="form-control" placeholder="Ít nhất 6 ký tự" required>
                </div>
            </div>
            
            <button type="submit" class="btn-register">Tạo tài khoản ngay</button>
        </form>
        
        <div class="auth-footer">
            Đã có tài khoản rồi? <a href="/shop_giay/auth/login">Đăng nhập tại đây</a>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>