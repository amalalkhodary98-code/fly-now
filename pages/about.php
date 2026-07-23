<?php
session_start();
include "../config.php"; 
include "../lang.php";  
$langcod = $_SESSION['lang'] ?? 'ar';
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'من نحن - رحلة' : 'About Us - Rehla' ?></title>
    <link rel="stylesheet" href="../assets/css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <style>
        .responsive-section {
            padding: 0 20px !important;
        }
        @media (min-width: 768px) {
            .responsive-section {
                padding: 0 60px !important;
            }
        }
    </style>
</head>
<body>

<section class="section-title" style="margin-top: 40px; padding: 0 20px; text-align: center;">
    <span>✈ <?= $langcod == 'ar' ? 'تعرف علينا' : 'Get to Know Us' ?></span>
    <h2><?= $langcod == 'ar' ? 'من نحن وماذا نقدم؟' : 'Who We Are & What We Offer' ?></h2>
    <p><?= $langcod == 'ar' ? 'منصتك الأولى لتسهيل السفر وحجز الرحلات والأنشطة الترفيهية.' : 'Your premier platform for flight bookings and leisure activities.' ?></p>
</section>

<section class="about-story responsive-section" style="max-width: 1200px; margin: 0 auto 60px auto; display: flex; gap: 40px; align-items: center; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 300px;">
        <h3 style="color: #c9a46a; margin-bottom: 15px; font-size: 24px;">
            <?= $langcod == 'ar' ? 'رؤيتنا ورسالتنا' : 'Our Vision & Mission' ?>
        </h3>
        <p style="color: #555; line-height: 1.8; margin-bottom: 15px;">
            <?= $langcod == 'ar' 
            ? 'تأسست منصة "رحلة" لتكون الجسر الذي يربطك بالعالم بكل سهولة وأمان. نحن لا نقدم مجرد حجز تذاكر، بل نسعى لتذليل كافة عقبات السفر، خصوصاً عبر توفير خدمات مخصصة وتنسيقات دقيقة لأهلنا في قطاع غزة لتسهيل حركتهم وتنقلهم بكرامة وراحة.' 
            : '"Rehla" was founded to be the bridge connecting you to the world safely and easily. We do not just offer ticket bookings; we strive to overcome all travel obstacles, especially by providing tailored services for Gaza sector to facilitate movement with comfort.' ?>
        </p>
    </div>
    
    <div style="flex: 1; min-width: 300px; width: 100%;">
        <video autoplay loop muted playsinline style="width: 100%; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); object-fit: cover; height: 300px;">
            <source src="../assets/videos.mp4/your-video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>

<section class="about-flex-section">
    <div class="about-flex-container">
        <div class="about-text-side">
            <span class="special-badge"><?= $langcod == 'ar' ? 'خدمة مخصصة واستثنائية' : 'Dedicated & Exceptional Service' ?></span>
            <h2><?= $langcod == 'ar' ? 'بوابة التسهيل والتنسيق لأهلنا في قطاع غزة' : 'Facilitation & Coordination Gateway for Gaza' ?></h2>
            <p>
                <?= $langcod == 'ar' 
                    ? 'لأننا نعلم مدى أهمية الوقت والراحة في رحلاتكم، أفردنا في منصة "رحلة" مساحة متكاملة ومخصصة لخدمات قطاع غزة. نهدف من خلالها إلى تبسيط وتسهيل كافة إجراءات تنسيقات السفر، متابعة المعابر خطوة بخطوة، وتوفير تحديثات مباشرة وموثوقة تضمن لكم رحلة آمنة ومنظمة من البداية وحتى الوصول.' 
                    : 'Understanding the vital importance of time and comfort for your journeys, Rehla dedicates a fully integrated section for Gaza Strip services. We aim to simplify travel coordination procedures, track crossing statuses step-by-step, and provide reliable, live updates ensuring a safe and organized journey from start to finish.' ?>
            </p>
        </div>
<div class="phone-mockup-large">
    <div class="phone-speaker"></div>
    <div class="phone-screen">
        <!-- الكود يقوم بفحص اللغة، فإذا كانت إنجليزي يعرض الصورة الإنجليزية، وإلا يعرض الصورة العربية -->
        <?php if ($langcod == 'en'): ?>
            <img src="../assets/images/about-main/3_en.png" alt="Gaza Services Mobile App">
        <?php else: ?>
            <img src="../assets/images/about-main/3.png" alt="Gaza Services Mobile App">
        <?php endif; ?>
    </div>
    <div class="phone-home-btn"></div>
</div>

</section>
<section class="about-services responsive-section" style="background: #ffffff; padding-top: 60px !important; padding-bottom: 60px !important; border-top: 1px solid rgba(0,0,0,0.03); border-bottom: 1px solid rgba(0,0,0,0.03);">
    <div class="section-title" style="margin: 0 0 40px 0; text-align: center;">
        <h2><?= $langcod == 'ar' ? 'خدماتنا الشاملة' : 'Our Comprehensive Services' ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
        
        <div style="background: #fdfdfd; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <img src="../assets/images/about-main/transport.jpg" alt="Transportation" style="width: 100%; height: 180px; object-fit: cover;">
            <div style="padding: 20px;">
                <h4 style="color: #c9a46a; margin-bottom: 10px;"><i class="fa-solid fa-bus"></i> <?= $langcod == 'ar' ? 'تأمين وسائل النقل' : 'Transportation Services' ?></h4>
                <p style="font-size: 14px; color: #666;"><?= $langcod == 'ar' ? 'نوفر خدمات نقل مريحة وآمنة من وإلى المطارات والمعابر لتضمن وصولاً سهلاً بدون عناء.' : 'We provide comfortable and safe transport services to and from airports and crossings.' ?></p>
            </div>
        </div>

        <div style="background: #fdfdfd; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <img src="../assets/images/about-main/restaurants.jpg" alt="Restaurants" style="width: 100%; height: 180px; object-fit: cover;">
            <div style="padding: 20px;">
                <h4 style="color: #c9a46a; margin-bottom: 10px;"><i class="fa-solid fa-utensils"></i> <?= $langcod == 'ar' ? 'أفضل المطاعم والفنادق' : 'Restaurants & Dining' ?></h4>
                <p style="font-size: 14px; color: #666;"><?= $langcod == 'ar' ? 'نساعدك في استكشاف وحجز تذاكر لأرقى المطاعم وأماكن الإقامة المفضلة في وجهتك القادمة.' : 'We help you discover and book tickets for top-rated restaurants and stays in your destination.' ?></p>
            </div>
        </div>

        <div style="background: #fdfdfd; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <img src="../assets/images/about-main/safari.jpg" alt="Safari Trips" style="width: 100%; height: 180px; object-fit: cover;">
            <div style="padding: 20px;">
                <h4 style="color: #c9a46a; margin-bottom: 10px;"><i class="fa-solid fa-compass"></i> <?= $langcod == 'ar' ? 'رحلات السفاري والمغامرات' : 'Safari & Adventure Trips' ?></h4>
                <p style="font-size: 14px; color: #666;"><?= $langcod == 'ar' ? 'باقات سياحية حصرية لعشاق الطبيعة والمغامرات مع مرشدين سياحيين محترفين.' : 'Exclusive tour packages for nature and adventure lovers with professional guides.' ?></p>
            </div>
        </div>

        <div style="background: #fdfdfd; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <img src="../assets/images/about-main/entertainment.jpg" alt="Entertainment" style="width: 100%; height: 180px; object-fit: cover;">
            <div style="padding: 20px;">
                <h4 style="color: #c9a46a; margin-bottom: 10px;"><i class="fa-solid fa-face-smile"></i> <?= $langcod == 'ar' ? 'الأنشطة الترفيهية' : 'Leisure & Entertainment' ?></h4>
                <p style="font-size: 14px; color: #666;"><?= $langcod == 'ar' ? 'تنظيم كامل للأنشطة الترفيهية العائلية والفعاليات الثقافية والترفيهية الحصرية في الإمارات ومختلف الدول.' : 'Full organization of family leisure activities and exclusive cultural events worldwide.' ?></p>
            </div>
        </div>

    </div>
</section>


<div class="back-nav-container <?= $langcod == 'ar' ? 'rtl-lang' : 'ltr-lang' ?>" style="text-align: center; margin: 30px 0;">
    <a href="../index.php?lang=<?= $langcod ?>" class="back-link-minimal">
        <i class="fa-solid <?= $langcod == 'ar' ? 'fa-chevron-right' : 'fa-chevron-left' ?>"></i>
        <span><?= $langcod == 'ar' ? 'الرئيسية' : 'Home' ?></span>
    </a>
</div>

</body>
</html>