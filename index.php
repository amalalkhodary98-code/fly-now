<?php
session_start();
include "config.php";
include "lang.php";
$langcod = $_SESSION['lang'] ?? 'ar';
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'رحلة - منصتك الأولى للسفر وحجز الرحلات' : 'Rehla - Your Travel Partner' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<header class="main-header">
    <div class="header-container">
        <div class="logo">
            <i class="fa-solid fa-plane-departure"></i>
            <span><?= $langcod == 'ar' ? 'رحلة' : 'Rehla' ?></span>
        </div>
        
        <button id="menuToggle" class="menu-toggle-btn" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        
        <nav class="nav-links">
            <a href="index.php?lang=<?= $langcod ?>" class="active">
                <i class="fa-solid fa-house"></i> <?= $langcod == 'ar' ? 'الرئيسية' : 'Home' ?>
            </a>
            <a href="pages/about.php?lang=<?= $langcod ?>">
                <i class="fa-solid fa-circle-info"></i> <?= $langcod == 'ar' ? 'اكتشف قصتنا' : 'Discover our story' ?>
            </a>
            <a href="pages/flights.php?lang=<?= $langcod ?>">
                <i class="fa-solid fa-plane"></i> <?= $langcod == 'ar' ? 'الرحلات' : 'Flights' ?>
            </a>
            <a href="pages/gaza_check.php?lang=<?= $langcod ?>">
                <i class="fa-solid fa-earth-asia"></i> <?= $langcod == 'ar' ? 'قطاع غزة' : 'Gaza Section' ?>
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="pages/my_bookings.php?lang=<?= $langcod ?>">
                    <i class="fa-solid fa-ticket"></i> <?= $langcod == 'ar' ? 'حجوزاتي' : 'My Bookings' ?>
                </a>
            <?php endif; ?>
            
            <a href="pages/contact.php?lang=<?= $langcod ?>">
                <i class="fa-solid fa-envelope"></i> <?= $langcod == 'ar' ? 'اتصل بنا' : 'Contact Us' ?>
            </a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin/dashboard.php" style="color: #64748b; font-weight: bold;">
                    <i class="fa-solid fa-gear"></i> <?= $langcod == 'ar' ? 'لوحة التحكم' : 'Admin Panel' ?>
                </a>
            <?php endif; ?>
        </nav>

        <div class="header-actions">
            <a href="?lang=<?= $langcod == 'ar' ? 'en' : 'ar' ?>" class="lang-switch-btn">
                <i class="fa-solid fa-globe"></i> <?= $langcod == 'ar' ? 'English' : 'العربية' ?>
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="user-info" title="<?= htmlspecialchars($_SESSION['user_name'] ?? ''); ?>">
                    <i class="fa-solid fa-user"></i> 
                    <?php 
                    $full_name = $_SESSION['user_name'] ?? '';
                    $name_parts = explode(' ', trim($full_name));
                    echo htmlspecialchars($name_parts[0]); 
                    ?>
                </span>
                <a href="pages/logout.php" class="login-btn logout-theme">
                    <i class="fa-solid fa-right-from-bracket"></i> <?= $langcod == 'ar' ? 'خروج' : 'Logout' ?>
                </a>
            <?php else: ?>
                <a href="pages/login.php?lang=<?= $langcod ?>" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket"></i> <?= $langcod == 'ar' ? 'تسجيل الدخول' : 'Login' ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
<section class="hero-section">
    <div class="hero-video-container">
        <div class="hero-overlay"></div>
    </div>
    
    <div class="hero-content">
        <h1><?= $langcod == 'ar' ? 'وجهتك القادمة تبدأ بضغطة زر' : 'Your Next Destination Starts with a Click' ?></h1>
        <p><?= $langcod == 'ar' ? 'منصة متكاملة لتسهيل حجوزات الطيران، تذاكر السفر، وتنسيقات المسافرين بكل أمان وراحة.' : 'An integrated platform to facilitate flight bookings, travel tickets, and passenger coordination safely and comfortably.' ?></p>
    </div>

    <div class="booking-widget-container">
        <div class="widget-tabs">
            <button class="tab-btn active"><i class="fa-solid fa-plane"></i> <?= $langcod == 'ar' ? 'احجز رحلة طيران' : 'Book a Flight' ?></button>
            <button class="tab-btn"><i class="fa-solid fa-briefcase"></i> <?= $langcod == 'ar' ? 'الباقات / التوقف المؤقت' : 'Packages / Stopover' ?></button>
            <button class="tab-btn"><i class="fa-solid fa-clipboard-list"></i> <?= $langcod == 'ar' ? 'إدارة الحجز / تسجيل الدخول' : 'Manage Booking / Login' ?></button>
            <button class="tab-btn"><i class="fa-solid fa-clock"></i> <?= $langcod == 'ar' ? 'حالة الرحلة' : 'Flight Status' ?></button>
        </div>

        <form action="pages/flights.php" method="GET" class="booking-form">
            <div class="flight-type-row">
                <label class="radio-label">
                    <input type="radio" name="flight_type" value="round" checked>
                    <span class="custom-radio"></span>
                    <?= $langcod == 'ar' ? 'رحلة ذهاب وعودة' : 'Round trip' ?>
                </label>
                <label class="radio-label">
                    <input type="radio" name="flight_type" value="oneway">
                    <span class="custom-radio"></span>
                    <?= $langcod == 'ar' ? 'اتجاه واحد' : 'One way' ?>
                </label>
                <label class="radio-label">
                    <input type="radio" name="flight_type" value="multi">
                    <span class="custom-radio"></span>
                    <?= $langcod == 'ar' ? 'وجهات متعددة' : 'Multi-city' ?>
                </label>
            </div>

            <div class="booking-fields-grid">
                <div class="field-group destination-picker">
                    <div class="inner-input">
                        <label><?= $langcod == 'ar' ? 'من' : 'From' ?></label>
                        <input type="text" name="from_city" placeholder="<?= $langcod == 'ar' ? 'مدينة المغادرة' : 'Departure City' ?>" required>
                    </div>
                    <button type="button" class="swap-locations-btn"><i class="fa-solid fa-arrows-rotate"></i></button>
                    <div class="inner-input">
                        <label><?= $langcod == 'ar' ? 'إلى' : 'To' ?></label>
                        <input type="text" name="to_city" placeholder="<?= $langcod == 'ar' ? 'مدينة الوصول' : 'Arrival City' ?>" required>
                    </div>
                </div>

                <div class="field-group date-picker-group">
                    <div class="inner-input">
                        <label><?= $langcod == 'ar' ? 'رحلة المغادرة' : 'Departure' ?></label>
                        <input type="date" name="departure_date" required>
                    </div>
                    <div class="inner-input">
                        <label><?= $langcod == 'ar' ? 'رحلة ذهاب وعودة' : 'Return' ?></label>
                        <input type="date" name="return_date">
                    </div>
                </div>

                <div class="field-group passengers-group">
                    <label><?= $langcod == 'ar' ? 'المسافرون / درجة السفر' : 'Passengers / Class' ?></label>
                    <select name="passengers_class">
                        <option value="1_economy">1 <?= $langcod == 'ar' ? 'المسافر، الدرجة السياحية' : 'Passenger, Economy' ?></option>
                        <option value="2_economy">2 <?= $langcod == 'ar' ? 'مسافرين، الدرجة السياحية' : 'Passengers, Economy' ?></option>
                        <option value="1_business">1 <?= $langcod == 'ar' ? 'المسافر، درجة الأعمال' : 'Passenger, Business' ?></option>
                    </select>
                </div>
            </div>

            <div class="booking-footer-row">
                <div class="promo-code-box">
                    <button type="button" class="promo-toggle-btn"><i class="fa-solid fa-plus"></i> <?= $langcod == 'ar' ? 'إضافة رمز ترويجي' : 'Add promo code' ?></button>
                </div>
                <button type="submit" class="search-flights-btn">
                    <?= $langcod == 'ar' ? 'ابحث عن الرحلات' : 'Search flights' ?>
                </button>
            </div>
        </form>
    </div>
</section>


<section class="next-content-section" style="padding: 140px 20px 60px 20px; background: #fbf9f6; text-align: center;">
    <h2><?= $langcod == 'ar' ? 'سافر ولا تفوّت أهم الفعاليات' : 'Travel and Don\'t Miss the Best Events' ?></h2>
</section>
<section class="main-gateways">
    <div class="gateway-container">
        <div class="gate-box">
            <div class="gate-icon"><i class="fa-solid fa-plane-up"></i></div>
            <h3><?= $langcod == 'ar' ? 'حجوزات الطيران العالمية' : 'Global Flight Bookings' ?></h3>
            <p><?= $langcod == 'ar' ? 'رحلات دولية لأكثر من 500 وجهة حول العالم بأفضل الأسعار المتاحة.' : 'International flights to over 500 destinations around the world at the best available rates.' ?></p>
            <a href="pages/flights.php" class="gate-btn"><?= $langcod == 'ar' ? 'استكشف الرحلات' : 'Explore Flights' ?></a>
        </div>
        <div class="gate-box active-gate">
            <div class="gate-icon"><i class="fa-solid fa-passport"></i></div>
            <h3><?= $langcod == 'ar' ? 'تنسيقات قطاع غزة' : 'Gaza Sector Coordination' ?></h3>
            <p><?= $langcod == 'ar' ? 'تسهيل معاملات السفر وتوفير كشوفات التنسيق الموثوقة لراحتكم وتسهيل حركتكم.' : 'Facilitating travel procedures and providing reliable coordination lists for your comfort.' ?></p>
            <a href="pages/gaza_check.php" class="gate-btn"><?= $langcod == 'ar' ? 'فحص التنسيقات' : 'Check Coordination' ?></a>
        </div>
        <div class="gate-box">
            <div class="gate-icon"><i class="fa-solid fa-hotel"></i></div>
            <h3><?= $langcod == 'ar' ? 'الفنادق والخدمات السياحية' : 'Hotels & Tourism Services' ?></h3>
            <p><?= $langcod == 'ar' ? 'حجوزات مؤكدة في أرقى الفنادق والمنتجعات مع تنظيم برامج ترفيهية متكاملة.' : 'Confirmed bookings in luxury hotels and resorts with fully organized leisure programs.' ?></p>
            <a href="pages/about.php" class="gate-btn"><?= $langcod == 'ar' ? 'احجز إقامتك' : 'Book Your Stay' ?></a>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="features-title">
        <h2><?= $langcod == 'ar' ? 'لماذا يعتمد المسافرون على منصة رحلة' : 'Why Travelers Trust Rehla Platform?' ?></h2>
    </div>
    <div class="features-grid">
        <div class="feature-item">
            <div class="feat-circle"><i class="fa-solid fa-shield-halved"></i></div>
            <h4><?= $langcod == 'ar' ? 'أعلى درجات الأمان' : 'Highest Security Levels' ?></h4>
            <p><?= $langcod == 'ar' ? 'بياناتك وحجوزاتك مشفرة ومحمية بالكامل وفق المعايير العالمية.' : 'Your data and bookings are fully encrypted and protected according to global standards.' ?></p>
        </div>
        <div class="feature-item">
            <div class="feat-circle"><i class="fa-solid fa-bolt"></i></div>
            <h4><?= $langcod == 'ar' ? 'سرعة فائقة ومعالجة فورية' : 'Super Fast & Instant' ?></h4>
            <p><?= $langcod == 'ar' ? 'إتمام عمليات الحجز الفوري وإصدار التذاكر الإلكترونية خلال دقائق معدودة.' : 'Complete instant booking processes and issue electronic tickets within minutes.' ?></p>
        </div>
        <div class="feature-item">
            <div class="feat-circle"><i class="fa-solid fa-headset"></i></div>
            <h4><?= $langcod == 'ar' ? 'دعم متواصل 24/7' : 'Continuous 24/7 Support' ?></h4>
            <p><?= $langcod == 'ar' ? 'طاقم دعم مخصص متواجد على مدار الساعة لمساعدتك طوال فترة رحلتك.' : 'A dedicated support team available around the clock to assist you throughout your journey.' ?></p>
        </div>
    </div>
</section>

<section class="video-carousel-section">
    <div class="features-title">
        <h2><?= $langcod == 'ar' ? 'فيديوهات ترويجية ورحلات ملهمة' : 'Promotional Videos & Inspiring Journeys' ?></h2>
    </div>
    <div class="carousel-grid">
        <div class="carousel-card">
            <div class="video-wrapper">
                <video autoplay loop muted playsinline class="card-video">
                    <source src="assets/videos.mp4/dubai.mp4" type="video/mp4">
                </video>
            </div>
            <h4><?= $langcod == 'ar' ? 'استكشف سحر دبي والخليج' : 'Explore the Magic of Dubai' ?></h4>
        </div>
        <div class="carousel-card">
            <div class="video-wrapper">
                <video autoplay loop muted playsinline class="card-video">
                    <source src="assets/videos.mp4/tips.mp4" type="video/mp4">
                </video>
            </div>
            <h4><?= $langcod == 'ar' ? 'نصائح وإرشادات المسافرين' : 'Travelers Tips & Guidelines' ?></h4>
        </div>
        <div class="carousel-card">
            <div class="video-wrapper">
                <video autoplay loop muted playsinline class="card-video clickable-video">
                    <source src="assets/videos.mp4/gaza_crossing.mp4" type="video/mp4">
                </video>
                <div class="video-audio-btn"><i class="fa-solid fa-volume-xmark"></i></div>
            </div>
            <h4><?= $langcod == 'ar' ? 'آلية تسهيل السفر عبر المعابر' : 'Crossing Travel Procedures' ?></h4>
        </div>
    </div>
</section>

<section class="recommended-destinations">
    <div class="features-title">
        <h2><?= $langcod == 'ar' ? 'أفكار لرحلات استثنائية' : 'Ideas for Exceptional Trips' ?></h2>
    </div>
    
    <div class="destinations-qatar-grid">
        <a href="pages/flights.php?lang=<?= $langcod ?>" class="qatar-card">
            <img src="assets/images/newyork.jpg" alt="New York">
            <div class="qatar-overlay">
                <div class="qatar-row top-row">
                    <h4 class="qatar-name"><?= $langcod == 'ar' ? 'مدينة نيويورك' : 'New York City' ?></h4>
                    <p class="qatar-class"><?= $langcod == 'ar' ? 'الدرجة السياحية ' : 'Economy Class ' ?><span class="qatar-price">JOD 735</span></p>
                </div>
                <div class="qatar-row bottom-row">
                    <p class="qatar-date">12 <?= $langcod == 'ar' ? 'سبتمبر' : 'September' ?> 2026 - 14 <?= $langcod == 'ar' ? 'سبتمبر' : 'September' ?> 2026</p>
                </div>
            </div>
        </a>

        <a href="pages/flights.php?lang=<?= $langcod ?>" class="qatar-card">
            <img src="assets/images/kuala_lumpur.jpg" alt="Kuala Lumpur">
            <div class="qatar-overlay">
                <div class="qatar-row top-row">
                    <h4 class="qatar-name"><?= $langcod == 'ar' ? 'كوالالمبور' : 'Kuala Lumpur' ?></h4>
                    <p class="qatar-class"><?= $langcod == 'ar' ? 'الدرجة السياحية ' : 'Economy Class ' ?><span class="qatar-price">JOD 520</span></p>
                </div>
                <div class="qatar-row bottom-row">
                    <p class="qatar-date">07 <?= $langcod == 'ar' ? 'سبتمبر' : 'September' ?> 2026 - 21 <?= $langcod == 'ar' ? 'سبتمبر' : 'September' ?> 2026</p>
                </div>
            </div>
        </a>

        <a href="pages/flights.php?lang=<?= $langcod ?>" class="qatar-card">
            <img src="assets/images/london1.jpg" alt="London">
            <div class="qatar-overlay">
                <div class="qatar-row top-row">
                    <h4 class="qatar-name"><?= $langcod == 'ar' ? 'لندن' : 'London' ?></h4>
                    <p class="qatar-class"><?= $langcod == 'ar' ? 'الدرجة السياحية ' : 'Economy Class ' ?><span class="qatar-price">JOD 610</span></p>
                </div>
                <div class="qatar-row bottom-row">
                    <p class="qatar-date">06 <?= $langcod == 'ar' ? 'نوفمبر' : 'November' ?> 2026 - 11 <?= $langcod == 'ar' ? 'نوفمبر' : 'November' ?> 2026</p>
                </div>
            </div>
        </a>
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-box">
            <h2><i class="fa-solid fa-plane-departure"></i> <?= $langcod == 'ar' ? 'رحلة' : 'Rehla' ?></h2>
            <p><?= $langcod == 'ar' ? 'بوابتك الذكية لتسهيل معاملات السفر وحجوزات الطيران حول العالم بكل راحة وسرعة.' : 'Your smart gateway for easy travel arrangements and worldwide flight bookings.' ?></p>
        </div>
        <div class="footer-box">
            <h3><?= $langcod == 'ar' ? 'روابط سريعة' : 'Quick Links' ?></h3>
            <a href="index.php"><?= $langcod == 'ar' ? 'الرئيسية' : 'Home' ?></a>
            <a href="pages/about.php"><?= $langcod == 'ar' ? 'من نحن' : 'About Us' ?></a>
            <a href="pages/flights.php"><?= $langcod == 'ar' ? 'الرحلات' : 'Flights' ?></a>
        </div>
        <div class="footer-box">
            <h3><?= $langcod == 'ar' ? 'طرق الدفع المدعومة' : 'Supported Payments' ?></h3>
            <div class="footer-payments">
                <span style="font-size: 12px; color: #666; background: #fff; padding: 5px 10px; border-radius: 4px; border: 1px solid #e2e8f0;">PalPay</span>
                <span style="font-size: 12px; color: #666; background: #fff; padding: 5px 10px; border-radius: 4px; border: 1px solid #e2e8f0;">Visa / MasterCard</span>
            </div>
        </div>
    </div>
    <div class="footer-copy">
        <p>&copy; 2026 <?= $langcod == 'ar' ? 'منصة رحلة. جميع الحقوق محفوظة.' : 'Rehla Platform. All rights reserved.' ?></p>
    </div>
</footer>

<div onclick="this.dataset.clicks = (parseInt(this.dataset.clicks) || 0) + 1; if(parseInt(this.dataset.clicks) === 3) { window.location.href = 'pages/login.php?secret=gaza_safe_gate_2026'; } setTimeout(() => { this.dataset.clicks = 0; }, 2000);" 
     class="perfect-secret-center-gate" 
     data-clicks="0">
     Control Panel
</div>
<script src="js/script.js"></script>
</body>
</html>