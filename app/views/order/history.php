<?php include 'app/views/layouts/header.php'; ?>

<style>
:root {
    --primary-red: #ef4444;
    --gradient-red: linear-gradient(135deg, #ef4444, #b91c1c);
    --bg-gray: #f8fafc;
}

.history-page {
    background: var(--bg-gray);
    min-height: 80vh;
    padding: 40px 20px;
}

.history-container {
    max-width: 1200px;
    margin: 0 auto;
}

.history-header {
    text-align: center;
    margin-bottom: 40px;
}

.history-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
}

.history-subtitle {
    color: #64748b;
    font-size: 1.1rem;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(239, 68, 68, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: #fee2e2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: var(--primary-red);
}

.stat-info h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 5px;
}

.stat-info p {
    color: #64748b;
    font-size: 0.95rem;
}

/* Orders List */
.orders-list {
    background: white;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}

.list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.list-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.order-count {
    background: #f1f5f9;
    padding: 6px 15px;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
}

.order-item {
    display: grid;
    grid-template-columns: auto 1fr auto auto auto;
    align-items: center;
    gap: 20px;
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.order-item:hover {
    background: #f8fafc;
    transform: translateX(5px);
    border-radius: 12px;
}

.order-item:last-child {
    border-bottom: none;
}

.order-status-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.status-pending { background: #fff7ed; color: #f97316; }
.status-confirmed { background: #f0fdf4; color: #16a34a; }
.status-shipping { background: #eff6ff; color: #2563eb; }
.status-completed { background: #faf5ff; color: #9333ea; }
.status-cancelled { background: #fef2f2; color: #dc2626; }

.order-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 5px;
}

.order-code {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 5px;
}

.order-code span {
    font-weight: 600;
    color: var(--primary-red);
}

.order-date {
    font-size: 0.85rem;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 5px;
}

.order-amount {
    font-weight: 700;
    color: #1e293b;
}

.order-items {
    color: #64748b;
    font-size: 0.9rem;
}

.order-status-badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 4rem;
    color: var(--primary-red);
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 10px;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 30px;
}

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--gradient-red);
    color: white;
    padding: 14px 30px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .order-item {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .order-status-icon {
        margin: 0 auto;
    }
}
</style>

<div class="history-page">
    <div class="history-container">
        <div class="history-header">
            <h1 class="history-title">Lịch sử đơn hàng</h1>
            <p class="history-subtitle">Theo dõi tất cả đơn hàng của bạn tại Đớ Store</p>
        </div>

        <?php if (!empty($orders)): 
            // Tính toán thống kê
            $totalOrders = count($orders);
            $completedOrders = 0;
            $pendingOrders = 0;
            $totalSpent = 0;
            
            foreach ($orders as $order) {
                if ($order['order_status'] == 'Completed') {
                    $completedOrders++;
                } elseif ($order['order_status'] == 'Pending' || $order['order_status'] == 'Confirmed' || $order['order_status'] == 'Shipping') {
                    $pendingOrders++;
                }
                $totalSpent += $order['final_amount'];
            }
        ?>
        
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalOrders ?></h3>
                        <p>Tổng số đơn hàng</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $completedOrders ?></h3>
                        <p>Đơn hoàn thành</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= $pendingOrders ?></h3>
                        <p>Đơn đang xử lý</p>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="orders-list">
                <div class="list-header">
                    <h2>Danh sách đơn hàng</h2>
                    <span class="order-count"><?= $totalOrders ?> đơn</span>
                </div>

                <?php foreach ($orders as $order): 
                    $statusClass = strtolower($order['order_status']);
                    $statusLabels = [
                        'Pending' => 'Chờ xác nhận',
                        'Confirmed' => 'Đã xác nhận',
                        'Shipping' => 'Đang giao',
                        'Completed' => 'Hoàn thành',
                        'Cancelled' => 'Đã hủy'
                    ];
                ?>
                    <a href="/shop_giay/order/detail/<?= $order['order_code'] ?>" class="order-item">
                        <div class="order-status-icon status-<?= $statusClass ?>">
                            <?php 
                                $icons = [
                                    'Pending' => 'fa-clock',
                                    'Confirmed' => 'fa-check-circle',
                                    'Shipping' => 'fa-truck',
                                    'Completed' => 'fa-check-double',
                                    'Cancelled' => 'fa-times-circle'
                                ];
                            ?>
                            <i class="fas <?= $icons[$order['order_status']] ?? 'fa-box' ?>"></i>
                        </div>
                        
                        <div class="order-info">
                            <h4>Mã đơn: <span class="order-code"><?= $order['order_code'] ?></span></h4>
                            <div class="order-date">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                            </div>
                        </div>
                        
                        <div class="order-items">
                            <i class="fas fa-box"></i>
                            <?= $order['item_count'] ?? 0 ?> sản phẩm
                        </div>
                        
                        <div class="order-amount">
                            <?= number_format($order['final_amount'], 0, ',', '.') ?>đ
                        </div>
                        
                        <div class="order-status-badge status-<?= $statusClass ?>">
                            <?= $statusLabels[$order['order_status']] ?? $order['order_status'] ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Chưa có đơn hàng nào</h3>
                <p>Bạn chưa đặt mua sản phẩm nào. Hãy khám phá các sản phẩm của chúng tôi!</p>
                <a href="/shop_giay/product/index" class="btn-shop">
                    <i class="fas fa-shopping-bag"></i>
                    Mua sắm ngay
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>