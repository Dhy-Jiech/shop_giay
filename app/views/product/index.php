<?php include 'app/views/layouts/header.php'; ?>

<div class="container" style="display: flex; gap: 2rem; align-items: flex-start;">
    
    <!-- Sidebar Filters -->
    <aside style="width: 250px; background: var(--surface-color); padding: 1.5rem; border-radius: 8px; box-shadow: var(--shadow-sm);">
        <h3 class="mb-2" style="color: var(--primary-color);">Danh mục</h3>
        <ul style="display: flex; flex-direction: column; gap: 0.5rem;">
            <li>
                <a href="/shop_giay/product/index" style="<?= empty($data['currentCollection']) ? 'font-weight: bold;' : '' ?>">
                    Tất cả sản phẩm
                </a>
            </li>
            <?php foreach ($data['collections'] as $col): ?>
                <li>
                    <a href="/shop_giay/product/index?collection=<?= $col['slug'] ?>" style="<?= ($data['currentCollection'] == $col['slug']) ? 'font-weight: bold;' : '' ?>">
                        <?= htmlspecialchars($col['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Main Content -->
    <div style="flex: 1;">
        <h2 class="mb-3"><?= htmlspecialchars($data['title']) ?></h2>

        <?php if (empty($data['products'])): ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($data['products'] as $product): ?>
                    <div class="product-card">
                        <a href="/shop_giay/product/detail/<?= $product['slug'] ?>">
                            <img src="<?= htmlspecialchars($product['primary_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        </a>
                        <div class="product-info">
                            <p style="color: var(--text-muted); font-size: 0.9rem;"><?= htmlspecialchars($product['collection_name']) ?></p>
                            <a href="/shop_giay/product/detail/<?= $product['slug'] ?>">
                                <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                            </a>
                            <p class="product-price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
                            <div class="product-actions mt-auto text-center" style="margin-top:auto">
                                <form action="/shop_giay/cart/add" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100" style="width: 100%;">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
