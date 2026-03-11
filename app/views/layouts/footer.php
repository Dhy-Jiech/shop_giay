<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>ĐỚ Store</h3>
                <p>Thương hiệu giày thể thao Việt Nam với thiết kế độc quyền và chất lượng cao cấp.</p>
            </div>
            <div class="footer-section">
                <h4>Liên hệ</h4>
                <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận XYZ, Hà Nội</p>
                <p><i class="fas fa-phone"></i> 1900 1234</p>
                <p><i class="fas fa-envelope"></i> info@dostore.vn</p>
            </div>
            <div class="footer-section">
                <h4>Hỗ trợ khách hàng</h4>
                <ul class="footer-links">
                    <li><a href="/shop_giay/order/tracking"><i class="fas fa-map-marker-alt"></i> Theo dõi đơn hàng</a></li>
                    <li><a href="/shop_giay/home/about">Về Đớ Store</a></li>
                    <li><a href="/shop_giay/home/contact">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Theo dõi chúng tôi</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 ĐỚ Store. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
            
            document.getElementById(`collection-${collection}`).classList.add('active');
        });
    });
    
    // Product filters
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>

<style>
.footer {
    background: var(--primary-color);
    color: var(--white);
    padding: 40px 0 20px;
    margin-top: 60px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    margin-bottom: 30px;
}

.footer-section h3,
.footer-section h4 {
    color: var(--white);
    margin-bottom: 15px;
}

.footer-section p {
    margin-bottom: 8px;
    opacity: 0.8;
}

.footer-section i {
    margin-right: 8px;
    color: var(--secondary-color);
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-links a {
    color: var(--white);
    font-size: 1.2rem;
    transition: var(--transition);
}

.social-links a:hover {
    color: var(--secondary-color);
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: var(--white);
    text-decoration: none;
    opacity: 0.8;
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.footer-links a i {
    width: 20px;
}

.footer-links a:hover {
    opacity: 1;
    color: var(--secondary-color);
    padding-left: 5px;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
    opacity: 0.7;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>
</body>
</html>