<?php include 'app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <div class="auth-container">
        <h2 class="text-center mb-3" style="color: var(--primary-color);">Tạo tài khoản mới</h2>
        
        <?php if(isset($data['error'])): ?>
            <div class="alert alert-error"><?= $data['error'] ?></div>
        <?php endif; ?>

        <form action="/shop_giay/auth/register" method="POST">
            <div class="form-group">
                <label class="form-label" for="full_name">Họ và tên *</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="username">Tên đăng nhập *</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Địa chỉ</label>
                <input type="text" id="address" name="address" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu *</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Đăng ký</button>
        </form>
        
        <p class="text-center mt-3">
            Đã có tài khoản? <a href="/shop_giay/auth/login">Đăng nhập</a>
        </p>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
