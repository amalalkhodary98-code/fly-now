<?php
session_start();
include "../config.php";

$langcod = $_SESSION['lang'] ?? 'ar';

$result = null;
$searched = false; 

if(isset($_POST['search'])){
    $searched = true;
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);

    $query = mysqli_query($conn,
    "SELECT * FROM gaza_requests 
    WHERE national_id='$national_id'
    ORDER BY id DESC LIMIT 1");

    $result = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'متابعة الطلب' : 'Track Request' ?></title>
    <link rel="stylesheet" href="../assets/css/request-style.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="check-container">

    <div class="page-header">
        <div class="icon-badge">🔍</div>
        <h1><?= $langcod == 'ar' ? 'متابعة طلب أهل غزة' : 'Gaza Request Tracking' ?></h1>
        <p class="subtitle"><?= $langcod == 'ar' ? 'استعلم عن حالة طلب السفر الخاص بك فوراً وبسهولة' : 'Check the status of your travel request instantly' ?></p>
    </div>

    <form class="search-form" method="POST">
        <div class="input-wrapper">
            <span class="input-icon">🆔</span>
            <input 
                type="text"
                name="national_id"
                placeholder="<?= $langcod == 'ar' ? 'يرجى كتابة رقم الهوية أو جواز السفر' : 'Enter National ID or Passport' ?>"
                required
                class="search-input"
                value="<?= isset($_POST['national_id']) ? htmlspecialchars($_POST['national_id']) : '' ?>"
            >
        </div>
        <button type="submit" name="search" class="search-btn">
            <span><?= $langcod == 'ar' ? 'ابحث الآن' : 'Search' ?></span>
        </button>
    </form>

<?php if($result){ ?>

<div class="result-card animated-fadeIn">

    <div class="card-top-bar">
        <h2><?= $result['name'] ?? '' ?></h2>
        <span class="badge-id"># <?= $result['id'] ?? '' ?></span>
    </div>

    <div class="result-grid">

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'رقم الهوية / الجواز' : 'National ID' ?></span>
            <p class="box-value"><?= $result['national_id'] ?? '' ?></p>
        </div>

        <?php
        $status = $result['request_status'] ?? '';
        $status_class = '';
        $status_text = $status;
        $status_icon = '⏳';

        if($status == "pending" || $status == "قيد المراجعة"){
            $status_class = 'pending';
            $status_text = ($langcod == 'ar' ? "قيد المراجعة" : "Pending");
            $status_icon = '⏳';
        }
        elseif($status == "approved" || $status == "مقبول"){
            $status_class = 'approved';
            $status_text = ($langcod == 'ar' ? "تم القبول" : "Approved");
            $status_icon = '✅';
        }
        elseif($status == "rejected" || $status == "مرفوض"){
            $status_class = 'rejected';
            $status_text = ($langcod == 'ar' ? "مرفوض" : "Rejected");
            $status_icon = '❌';
        }
        ?>
        <div class="result-box status-box <?= $status_class ?>">
            <span class="box-title"><?= $langcod == 'ar' ? 'حالة الطلب الحالية' : 'Status' ?></span>
            <p class="box-value"><strong><?= $status_icon ?> <?= $status_text ?></strong></p>
        </div>

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'سبب السفر الرئيسي' : 'Travel Reason' ?></span>
            <p class="box-value"><?= $result['travel_reason'] ?? ($langcod=='ar' ? "غير متوفر" : "Not available") ?></p>
        </div>

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'نقطة الانطلاق' : 'Departure Point' ?></span>
            <p class="box-value">🛫 <?= $result['departure_point'] ?? ($langcod=='ar' ? "غير متوفر" : "Not available") ?></p>
        </div>

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'نقطة الوصول' : 'Meeting Point' ?></span>
            <p class="box-value">🛬 <?= $result['meeting_point'] ?? ($langcod=='ar' ? "غير متوفر" : "Not available") ?></p>
        </div>

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'المعبر المستخدم' : 'Border Crossing' ?></span>
            <p class="box-value">🚧 <?= $result['border_crossing'] ?? ($langcod=='ar' ? "غير متوفر" : "Not available") ?></p>
        </div>

        <div class="result-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'تاريخ السفر المتوقع' : 'Travel Date' ?></span>
            <p class="box-value">📅 <?= $result['travel_date'] ?? ($langcod=='ar' ? "غير متوفر" : "Not available") ?></p>
        </div>

        <div class="result-box notes-box">
            <span class="box-title"><?= $langcod == 'ar' ? 'ملاحظات وتوجيهات الإدارة' : 'Admin Notes' ?></span>
            <p class="box-value">
            <?= !empty($result['admin_notes']) 
                ? $result['admin_notes'] 
                : ($langcod=='ar' ? "لا توجد أي ملاحظات مسجلة من الإدارة حالياً." : "No admin notes recorded."); ?>
            </p>
        </div>

    </div>

    <div class="request-buttons">
        <a href="edit_my_gaza_request.php?id=<?= $result['id']; ?>" class="edit-btn">
            <span>✏️</span> <?= $langcod == 'ar' ? 'تعديل بيانات الطلب' : 'Edit Request' ?>
        </a>
        <a href="../index.php" class="home-btn">
            <span>🏠</span> <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
    </div>

</div>

<?php } elseif($searched) { ?>
    <div class="no-result-card animated-fadeIn">
        <div class="no-result-icon">⚠️</div>
        <h3><?= $langcod == 'ar' ? 'عذراً، لم نجد أي طلب!' : 'No Request Found!' ?></h3>
        <p><?= $langcod == 'ar' ? 'يرجى التأكد من كتابة رقم الهوية أو جواز السفر بشكل صحيح وإعادة المحاولة.' : 'Please make sure the National ID or Passport number is correct.' ?></p>
    </div>
<?php } ?>

</div>

</body>
</html>
