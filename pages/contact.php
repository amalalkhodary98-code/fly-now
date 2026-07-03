<?php
session_start();
include "../config.php";
include "../lang.php";

$message_html = "";

if (isset($_POST['send_message'])) {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $message_html = "
    <div class='alert-msg success-msg'>
    ".($langcod == 'ar' ? '✅ تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.' : 'Message sent successfully! We will contact you soon.')."
    </div>";
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'اتصل بنا' : 'Contact Us' ?></title>
    <link rel="stylesheet" href="../assets/css/contact.css">
    <link rel="stylesheet" href="https://cloudflare.com">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="contact-page">

<div class="contact-wrapper animated-fadeIn">

    <div class="contact-container">
        
        <div class="contact-info-panel">
            <h3><?= $langcod == 'ar' ? 'تواصل معنا' : 'Get in Touch' ?></h3>
            <p class="panel-desc"><?= $langcod == 'ar' ? 'يسعدنا الإجابة على استفساراتك. اضغط مباشرة على أي قناة للتواصل الفوري معنا.' : 'We are happy to answer your questions. Click on any channel for instant support.' ?></p>
            
            <div class="info-links-list">
                <a href="https://wa.me" target="_blank" class="contact-clickable-item">
                    <div class="info-item">
                        <i class="fa-brands fa-whatsapp text-whatsapp"></i>
                        <div>
                            <span><?= $langcod == 'ar' ? 'محادثة واتساب' : 'WhatsApp Chat' ?></span>
                            <strong>+970 599 000 000</strong>
                        </div>
                    </div>
                </a>

                <a href="https://facebook.com" target="_blank" class="contact-clickable-item">
                    <div class="info-item">
                        <i class="fa-brands fa-facebook-f text-facebook"></i>
                        <div>
                            <span><?= $langcod == 'ar' ? 'صفحة الفيسبوك' : 'Facebook Page' ?></span>
                            <strong>Fly Now Portal</strong>
                        </div>
                    </div>
                </a>
                
                <a href="https://instagram.com" target="_blank" class="contact-clickable-item">
                    <div class="info-item">
                        <i class="fa-brands fa-instagram text-instagram"></i>
                        <div>
                            <span><?= $langcod == 'ar' ? 'حساب الإنستغرام' : 'Instagram Profile' ?></span>
                            <strong>@flynow_travel</strong>
                        </div>
                    </div>
                </a>

                <div class="info-item static-item">
                    <i class="fa-regular fa-envelope"></i>
                    <div>
                        <span><?= $langcod == 'ar' ? 'البريد الإلكتروني' : 'Email Address' ?></span>
                        <strong>support@flynow.com</strong>
                    </div>
                </div>
            </div>

            <div class="social-pills-bar">
                <a href="https://facebook.com" target="_blank" class="social-pill fb"><i class="fa-brands fa-facebook-f"></i> Facebook</a>
                <a href="https://instagram.com" target="_blank" class="social-pill ig"><i class="fa-brands fa-instagram"></i> Instagram</a>
                <a href="https://wa.me" target="_blank" class="social-pill wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>

        <div class="contact-form-panel">
            <h2><?= $langcod == 'ar' ? 'أرسل لنا رسالة' : 'Send Us a Message' ?></h2>
            
            <?= $message_html ?>

            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label><?= $langcod == 'ar' ? 'الاسم الكامل' : 'Full Name' ?></label>
                        <input type="text" name="name" placeholder="<?= $langcod == 'ar' ? 'أدخل اسمك الكامل' : 'Enter full name' ?>" required>
                    </div>

                    <div class="form-group">
                        <label><?= $langcod == 'ar' ? 'البريد الإلكتروني' : 'Email' ?></label>
                        <input type="email" name="email" placeholder="<?= $langcod == 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter email address' ?>" required>
                    </div>

                    <div class="form-group full-width">
                        <label><?= $langcod == 'ar' ? 'موضوع الرسالة' : 'Subject' ?></label>
                        <input type="text" name="subject" placeholder="<?= $langcod == 'ar' ? 'ما هو موضوع استفسارك؟' : 'Enter message subject' ?>" required>
                    </div>

                    <div class="form-group full-width">
                        <label><?= $langcod == 'ar' ? 'نص الرسالة' : 'Message' ?></label>
                        <textarea name="message" rows="4" placeholder="<?= $langcod == 'ar' ? 'اكتب تفاصيل رسالتك هنا...' : 'Type your message details here...' ?>" required></textarea>
                    </div>
                </div>

                <button type="submit" name="send_message" class="btn-send-pill">
                    <?= $langcod == 'ar' ? 'إرسال الرسالة' : 'Send Message' ?>
                </button>
            </form>
        </div>

    </div>

    <div class="back-buttons">
        <a href="../index.php" class="back-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
        <button onclick="history.back()" class="back-btn">
            ⬅ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </button>
    </div>

</div>

</body>
</html>
