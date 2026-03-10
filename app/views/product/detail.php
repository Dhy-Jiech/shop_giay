<?php include 'app/views/layouts/header.php'; ?>

<?php $product = $data['product']; ?>

<div class="container">
    <div class="row" style="background: var(--surface-color); padding: 2rem; border-radius: 12px; box-shadow: var(--shadow-sm);">
        <div class="col-md-6">
            <?php 
                $primaryImg = 'public/images/default-shoe.jpg';
                if(!empty($product['images'])) {
                    foreach($product['images'] as $img) {
                        if($img['is_primary']) {
                            $primaryImg = $img['image_url'];
                            break;
                        }
                    }
                    if($primaryImg == 'public/images/default-shoe.jpg') {
                        $primaryImg = $product['images'][0]['image_url'];
                    }
                }
            ?>
            <img src="<?= htmlspecialchars($primaryImg) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; border-radius: 8px;">
            
            <!-- Gallery (if any) -->
            <div style="display:flex; gap:10px; margin-top:10px; overflow-x:auto;">
                <?php if(!empty($product['images'])): ?>
                    <?php foreach($product['images'] as $img): ?>
                        <img src="<?= htmlspecialchars($img['image_url']) ?>" style="width:80px; height:80px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
            <p style="color: var(--primary-color); font-weight: 600; text-transform: uppercase;">
                <?= htmlspecialchars($product['collection_name'] ?? 'Giày Đớ') ?>
            </p>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price" style="font-size: 2rem; color: var(--text-color); margin-bottom: 1.5rem;">
                <?= number_format($product['price'], 0, ',', '.') ?>đ
            </p>
            
            <p style="margin-bottom: 1rem;"><strong>Size:</strong> <?= htmlspecialchars($product['size']) ?></p>
            <p style="margin-bottom: 2rem; color: var(--text-muted); line-height: 1.8;">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </p>

            <form action="/shop_giay/cart/add" method="POST" style="display: flex; gap: 1rem; align-items: center;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div style="display: flex; align-items: center; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                    <button type="button" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)" style="border:none; background:#f8f9fa; padding:10px 15px; cursor:pointer; font-size:1.2rem;">-</button>
                    <input type="number" id="qty" name="quantity" value="1" min="1" style="width: 50px; text-align: center; border: none; outline: none; font-size:1.1rem;-moz-appearance: textfield;">
                    <button type="button" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value) + 1" style="border:none; background:#f8f9fa; padding:10px 15px; cursor:pointer; font-size:1.2rem;">+</button>
                </div>
                <button type="submit" class="btn btn-primary" style="flex: 1; padding: 12px; font-size: 1.1rem;">Thêm vào giỏ hàng</button>
            </form>
            
            <div style="margin-top: 1rem;">
                <?php if ($product['stock_quantity'] > 0): ?>
                    <span style="color: #0f5132; background: #d1e7dd; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;">Còn <?= $product['stock_quantity'] ?> sản phẩm</span>
                <?php else: ?>
                    <span style="color: #842029; background: #f8d7da; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;">Hết hàng</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>
