<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #d32f2f;
        --secondary-color: #333;
        --bg-gray: #f4f7f6;
    }

    body { background-color: var(--bg-gray); }

    .login-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 0;
    }

    .login-card {
        background: #fff;
        width: 100%;
        max-width: 450px;
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .login-header { text-align: center; margin-bottom: 40px; }
    .login-header h2 { 
        font-weight: 800; 
        color: var(--secondary-color); 
        letter-spacing: -1px;
        margin-bottom: 10px;
    }
    .login-header p { color: #888; font-size: 0.95rem; }

    .form-group { margin-bottom: 25px; }
    .form-label { 
        display: block; 
        margin-bottom: 8px; 
        font-weight: 600; 
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 1.5px solid #eee;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fdfdfd;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        outline: none;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
    }

    .btn-login {
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
        margin-top: 10px;
    }

    .btn-login:hover {
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

    .login-footer {
        text-align: center;
        margin-top: 30px;
        font-size: 0.95rem;
        color: #666;
    }
    .login-footer a { 
        color: var(--primary-color); 
        text-decoration: none; 
        font-weight: 600;
    }
    .login-footer a:hover { text-decoration: underline; }
</style>

<div class="login-section">
    <div class="login-card">
        <div class="login-header">
            <h2>Chào mừng trở lại</h2>
            <p>Đăng nhập để tiếp tục mua sắm tại ĐỎHA</p>
        </div>

        <?php if(isset($data['error'])): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <form action="/shop_giay/auth/login" method="POST">
            <div class="form-group">
                <label class="form-label" for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Nhập tên tài khoản của bạn" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <a href="#" style="font-size: 0.85rem; color: #888; text-decoration: none;">Quên mật khẩu?</a>
            </div>
            
            <button type="submit" class="btn-login">ĐĂNG NHẬP</button>
        </form>
        
        <div class="login-footer">
            Chưa có tài khoản? <a href="/shop_giay/auth/register">Đăng ký ngay</a>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>