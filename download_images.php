<?php
$imagesDir = __DIR__ . '/public/images/';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0777, true);
}

$images = [
    'hero-bg-1.jpg' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=1920&q=80',
    'cat-men.jpg' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=800&q=80',
    'cat-women.jpg' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=800&q=80',
    'cat-sport.jpg' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80',
    'cat-casual.jpg' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&q=80',
    'cat-accessories.jpg' => 'https://images.unsplash.com/photo-1584916201218-f4242ceb4809?auto=format&fit=crop&w=800&q=80',
    'collection-mua-he-soi-dong.jpg' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=1200&q=80',
    'collection-street-style.jpg' => 'https://images.unsplash.com/photo-1514989940723-e8e51635b782?auto=format&fit=crop&w=1200&q=80',
    'banner-1.jpg' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=800&q=80',
    'banner-2.jpg' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&q=80',
    'brand-nike.png' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg',
    'brand-adidas.png' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg',
    'brand-puma.png' => 'https://upload.wikimedia.org/wikipedia/commons/a/a1/Puma_Logo.svg',
    'brand-converse.png' => 'https://upload.wikimedia.org/wikipedia/commons/3/30/Converse_logo.svg',
    'brand-vans.png' => 'https://upload.wikimedia.org/wikipedia/commons/9/9d/Vans_logo.svg',
    'brand-newbalance.png' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/New_Balance_logo.svg',
];

foreach ($images as $filename => $url) {
    if (!file_exists($imagesDir . $filename)) {
        echo "Downloading $filename...\n";
        $content = @file_get_contents($url);
        if ($content) {
            file_put_contents($imagesDir . $filename, $content);
        }
        else {
            echo "Failed to download $filename\n";
        }
    }
    else {
        echo "Skipping $filename (already exists)\n";
    }
}
echo "Done.";
