<?php
session_start();

include "../lang.php";
include "../config.php";

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

$query = "
SELECT * FROM gaza_requests
WHERE id='$id'
";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if(!$row){
    die($langcod == 'ar' ? "❌ الطلب غير موجود" : "❌ Request not found");
}

if(
    $row['request_status'] == 'مقبول'
    ||
    $row['request_status'] == 'مرفوض'
    ||
    $row['request_status'] == 'approved'
    ||
    $row['request_status'] == 'rejected'
){
    die($langcod == 'ar' ? "❌ لا يمكن تعديل الطلب بعد المراجعة" : "❌ Cannot edit after review");
}


if(isset($_POST['update'])){

    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $phone           = mysqli_real_escape_string($conn, $_POST['phone']);
    $travel_reason   = mysqli_real_escape_string($conn, $_POST['travel_reason']);
    $destination     = mysqli_real_escape_string($conn, $_POST['destination']);
    $companions      = mysqli_real_escape_string($conn, $_POST['companions']);
    $notes           = mysqli_real_escape_string($conn, $_POST['notes']);
    $travel_date     = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $travel_time     = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $border_crossing = mysqli_real_escape_string($conn, $_POST['border_crossing']);
    $city            = mysqli_real_escape_string($conn, $_POST['city']);

    $update = "
    UPDATE gaza_requests SET
    name='$name',
    phone='$phone',
    travel_reason='$travel_reason',
    destination='$destination',
    companions='$companions',
    notes='$notes',
    travel_date='$travel_date',
    travel_time='$travel_time',
    border_crossing='$border_crossing',
    city='$city'
    WHERE id='$id'
    ";

    if(mysqli_query($conn, $update)){
        $alert_msg = ($langcod == 'ar') ? "تم تعديل الطلب بنجاح" : "Request updated successfully";
        echo "
        <script>
        alert('$alert_msg');
        window.location.href='check_gaza_request.php';
        </script>
        ";
        exit();

    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'تعديل الطلب' : 'Edit Request' ?></title>
    <link rel="stylesheet" href="../assets/css/edit-request-style.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="edit-box animated-fadeIn">

    <h2>✏️ <?= $langcod == 'ar' ? 'تعديل طلب السفر' : 'Edit Travel Request' ?></h2>

    <form method="POST" class="edit-form">

        <div class="form-grid">
            <div class="form-group">
                <label><?= $langcod == 'ar' ? '👤 الاسم الكامل' : 'Full Name' ?></label>
                <input type="text" name="name" value="<?= htmlspecialchars($row['name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '📞 رقم الهاتف' : 'Phone Number' ?></label>
                <input type="text" name="phone" value="<?= htmlspecialchars($row['phone'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '✈️ سبب السفر' : 'Travel Reason' ?></label>
                <select name="travel_reason" required>
                    <option value="علاج/إصابة" <?= ($row['travel_reason']=="علاج/إصابة") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'علاج/إصابة' : 'Medical/Treatment' ?></option>
                    <option value="دراسة" <?= ($row['travel_reason']=="دراسة") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'دراسة' : 'Study' ?></option>
                    <option value="إقامة" <?= ($row['travel_reason']=="إقامة") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'إقامة' : 'Residence' ?></option>
                    <option value="زيارة" <?= ($row['travel_reason']=="زيارة") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'زيارة' : 'Visit' ?></option>
                    <option value="حالة إنسانية" <?= ($row['travel_reason']=="حالة إنسانية") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'حالة إنسانية' : 'Humanitarian Case' ?></option>
                </select>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '🌍 الوجهة النهائية' : 'Destination' ?></label>
                <input type="text" name="destination" value="<?= htmlspecialchars($row['destination'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '👥 عدد المرافقين' : 'Companions' ?></label>
                <input type="number" name="companions" value="<?= htmlspecialchars($row['companions'] ?? '') ?>" min="0">
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '🏙 المحافظة' : 'City' ?></label>
                <select name="city">
                    <option value="غزة" <?= ($row['city']=="غزة") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'غزة' : 'Gaza' ?></option>
                    <option value="خانيونس" <?= ($row['city']=="خانيونس") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'خانيونس' : 'Khan Younis' ?></option>
                    <option value="رفح" <?= ($row['city']=="رفح") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'رفح' : 'Rafah' ?></option>
                    <option value="جباليا" <?= ($row['city']=="جباليا") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'جباليا' : 'Jabalia' ?></option>
                    <option value="دير البلح" <?= ($row['city']=="دير البلح") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'دير البلح' : 'Deir Al-Balah' ?></option>
                </select>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '📅 تاريخ السفر' : 'Travel Date' ?></label>
                <input type="date" name="travel_date" value="<?= htmlspecialchars($row['travel_date'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? '⏰ وقت السفر' : 'Travel Time' ?></label>
                <input type="time" name="travel_time" value="<?= htmlspecialchars($row['travel_time'] ?? '') ?>">
            </div>

            <div class="form-group full-width">
                <label><?= $langcod == 'ar' ? '🚧 المعبر المفترض' : 'Crossing' ?></label>
                <select name="border_crossing">
                    <option value="معبر رفح" <?= ($row['border_crossing']=="معبر رفح") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'معبر رفح' : 'Rafah Crossing' ?></option>
                    <option value="كرم أبو سالم" <?= ($row['border_crossing']=="كرم أبو سالم") ? "selected" : "" ?>><?= $langcod == 'ar' ? 'كرم أبو سالم' : 'Kerem Shalom' ?></option>
                </select>
            </div>

            <div class="form-group full-width">
                <label><?= $langcod == 'ar' ? '📝 الملاحظات الإضافية' : 'Notes' ?></label>
                <textarea name="notes" rows="4"><?= htmlspecialchars($row['notes'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="update" class="save-btn">
                💾 <?= $langcod == 'ar' ? 'حفظ التعديلات الحالية' : 'Save Changes' ?>
            </button>
            
            <a href="check_gaza_request.php" class="back-btn">
                ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
            </a>
        </div>

    </form>

</div>

</body>
</html>
