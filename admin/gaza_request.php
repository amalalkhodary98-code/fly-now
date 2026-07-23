<?php
session_start();
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en' ? "🚫 Access denied" : "🚫 يجب تسجيل الدخول كمسؤول");
}

$langcod = $_SESSION['lang'] ?? 'ar';

$result = mysqli_query($conn, "SELECT * FROM gaza_requests ORDER BY id DESC");

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'طلبات غزة' : 'Gaza Requests' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/gaza_request.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">
</head>
<body class="admin-page">

<div class="requests-container animated-fadeIn">

    <h1 class="page-title">
        🇵🇸 <?= $langcod == 'ar' ? 'طلبات أهل غزة' : 'Gaza Requests' ?>
    </h1>

    <?php 
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) { 
            $status_raw = $row['request_status'] ?? 'pending';
            $status_class = "pending";
            if($status_raw == "approved") { $status_class = "approved"; }
            if($status_raw == "rejected") { $status_class = "rejected"; }
        ?>

        <div class="request-card">
            <div class="gaza-card">

                <div class="card-top-header">
                    <h3>
                        <?= $langcod == 'ar' ? 'طلب خاص لأهل غزة' : 'Special Gaza Request' ?> 🇵🇸
                    </h3>
                    
                    <span class="status-badge <?= $status_class ?>">
                        <?php
                        if($status_raw == "pending") { echo $langcod == 'ar' ? "قيد المراجعة" : "Pending"; }
                        elseif($status_raw == "approved") { echo $langcod == 'ar' ? "تم القبول" : "Approved"; }
                        elseif($status_raw == "rejected") { echo $langcod == 'ar' ? "تم الرفض" : "Rejected"; }
                        else { echo htmlspecialchars($status_raw); }
                        ?>
                    </span>
                </div>

                <div class="gaza-info">
                    <div class="box full">
                        <span><?= $langcod == 'ar' ? 'الاسم الكامل' : 'Full Name' ?></span>
                        <div><?= htmlspecialchars($row['name'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'رقم الهوية' : 'ID Number' ?></span>
                        <div><?= htmlspecialchars($row['national_id'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'رقم الجواز' : 'Passport' ?></span>
                        <div><?= htmlspecialchars($row['passport'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'رقم الهاتف' : 'Phone' ?></span>
                        <div><?= htmlspecialchars($row['phone'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' ?></span>
                        <div><?= htmlspecialchars($row['birth_date'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'المحافظة' : 'City' ?></span>
                        <div><?= htmlspecialchars($row['city'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'الجنس' : 'Gender' ?></span>
                        <div><?= htmlspecialchars($row['gender'] ?? '') ?></div>
                    </div>

                    <div class="box full">
                        <span><?= $langcod == 'ar' ? 'سبب السفر' : 'Travel Reason' ?></span>
                        <div><?= htmlspecialchars($row['travel_reason'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'الوجهة النهائية' : 'Destination' ?></span>
                        <div><?= htmlspecialchars($row['destination'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'عدد المرافقين' : 'Companions' ?></span>
                        <div><?= htmlspecialchars($row['companions'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'المعبر' : 'Border Crossing' ?></span>
                        <div><?= htmlspecialchars($row['border_crossing'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'تاريخ السفر' : 'Travel Date' ?></span>
                        <div><?= htmlspecialchars($row['travel_date'] ?? '') ?></div>
                    </div>

                    <div class="box">
                        <span><?= $langcod == 'ar' ? 'وقت السفر' : 'Travel Time' ?></span>
                        <div><?= htmlspecialchars($row['travel_time'] ?? '') ?></div>
                    </div>

                    <div class="box full">
                        <span><?= $langcod == 'ar' ? 'هل يوجد إصابة؟' : 'Injured?' ?></span>
                        <div><?= htmlspecialchars($row['injured'] ?? '') ?></div>
                    </div>

                    <div class="box full">
                        <span><?= $langcod == 'ar' ? 'ملاحظات' : 'Notes' ?></span>
                        <div><?= htmlspecialchars($row['notes'] ?? '') ?></div>
                    </div>
                </div>

              <div class="action-buttons">

    <a href="accept_gaza_request.php?id=<?= $row['id'] ?>" class="accept-btn">
        <?= $langcod == 'ar' ? 'قبول الطلب' : 'Accept' ?>
    </a>

                    <a href="edit_gaza_request.php?id=<?= $row['id'] ?>" class="edit-btn">
                        <?= $langcod == 'ar' ? 'تعديل البيانات' : 'Edit' ?>
                    </a>

                    <a href="delete_gaza_request.php?id=<?= $row['id'] ?>" class="delete-btn"
                       onclick="return confirm('<?= $langcod == 'ar' ? 'هل أنت متأكد من الحذف؟' : 'Are you sure?' ?>')">
                        <?= $langcod == 'ar' ? 'حذف الطلب' : 'Delete' ?>
                    </a>
                </div>

            </div>
        </div> 

        <?php 
        } 
    } else {
        echo "<div style='text-align:center; padding: 40px; color:#64748b;'><h3>" . ($langcod == 'ar' ? "لا توجد طلبات حالياً." : "No requests found.") . "</h3></div>";
    }
    ?>
    <div class="back-buttons">
        <a href="../index.php" class="back-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>

        <button onclick="history.back()" class="back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </button>
    </div>

</div>

</body>
</html>
