<?php include 'app/views/layouts/header.php'; ?>

<style>
.success-page {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.success-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    max-width: 500px;
    width: 100%;
}

.success-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #28a745, #20c997);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
    box-shadow: 0 10px 20px rgba(40,167,69,0.3);
}

.success-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
}

.order-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin: 2rem 0;
}

.order-code {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ff4757;
    margin: 0.5rem 0;
}

.btn-group {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, #ff4757, #ff6b81);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,71,87,0.3);
}

.btn-secondary {
    background: white;
    color: #333;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    border: 2px solid #e0e0e0;
    transition: all 0.3s;
}

.btn-secondary:hover {
    border-color: #ff4757;
    color: #ff4757;
}
</style>

<div class="success-page">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Đặt hàng thành công!</h1>
        
        <div class="order-info">
            <p style="margin-bottom: 0.5rem;">Mã đơn hàng của bạn là:</p>
            <div class="order-code"><?= htmlspecialchars($order['order_code'] ?? '') ?></div>
        </div>
        
        <p style="color: #666; margin-bottom: 2rem;">
            Cảm ơn bạn đã mua sắm tại Đớ Store. Đơn hàng của bạn đang được xử lý.
        </p>
        
        <div class="btn-group">
            <a href="/shop_giay/product/index" class="btn-secondary">
                <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>