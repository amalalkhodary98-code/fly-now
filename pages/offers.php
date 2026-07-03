<?php
include "../lang.php";
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'العروض الحصرية - رحلة' : 'Exclusive Offers - Rehla' ?></title>
    
    <link rel="stylesheet" href="../assets/css/offers_style.css">
    
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="offers-tabs-nav">
    <button class="tab-btn active" onclick="switchCategory('summer')"><?= $langcod == 'ar' ? 'خصومات الصيف' : 'Summer Discounts' ?></button>
    <button class="tab-btn" onclick="switchCategory('dubai')"><?= $langcod == 'ar' ? 'رحلات دبي' : 'Dubai Trips' ?></button>
    <button class="tab-btn" onclick="switchCategory('europe')"><?= $langcod == 'ar' ? 'عروض أوروبا' : 'Europe Offers' ?></button>
</div>

<div class="fullscreen-bg-slider" id="imageSlider"></div>
<div class="slider-overlay"></div>

<button class="slider-arrow prev-arrow" onclick="prevSlide()"><i class="fa-solid fa-chevron-left"></i></button>
<button class="slider-arrow next-arrow" onclick="nextSlide()"><i class="fa-solid fa-chevron-right"></i></button>

<div class="glass-offer-card">
    <h1 id="offerTitle">☀️ <?= $langcod == 'ar' ? 'خصومات الصيف' : 'Summer Discounts' ?></h1>
    
    <p class="description" id="offerDesc">
        <?= $langcod == 'ar' ? 'عروض صيفية مميزة وخصومات تصل إلى 30% على أجمل الرحلات السياحية الشاطئية والعائلية.' : 'Special summer offers with up to 30% discount on the best beach and family travel packages.' ?>
    </p>

    <div class="price-badge">
        <span class="price-label" id="priceLabel"><?= $langcod == 'ar' ? 'السعر المخفض:' : 'Price:' ?></span>
        <h2 class="price-tag" id="offerPrice">250$</h2>
    </div>

    <a href="booking.php?lang=<?= $langcod ?>" class="book-btn">
        <?= $langcod == 'ar' ? 'احجز رحلتك الآن' : 'Book Your Trip Now' ?>
    </a>

    <div class="back-home-wrapper">
        <a href="../index.php?lang=<?= $langcod ?>" class="home-link-minimal">
            <i class="fa-solid fa-house"></i>
            <span><?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?></span>
        </a>
    </div>
</div>

</div>
<script src="../js/script.js"></script>
</body>
</html>