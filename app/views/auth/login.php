<?php include 'app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 2rem;">
    <div class="auth-container">
        <h2 class="text-center mb-3 text-primary">Đăng nhập tài khoản</h2>
        
        <?php if(isset($data['error'])): ?>
            <div class="alert alert-error"><?= $data['error'] ?></div>
        <?php endif; ?>

        <form action="/shop_giay/auth/login" method="POST">
            <div class="form-group">
                <label class="form-label" for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Đăng nhập</button>
        </form>
        
        <p class="text-center mt-3">
            Chưa có tài khoản? <a href="/shop_giay/auth/register">Đăng ký ngay</a>
        </p>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
