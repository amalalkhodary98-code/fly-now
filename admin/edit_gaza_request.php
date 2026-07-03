<?php
session_start();
include "../config.php";
include "../lang.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die($langcod == 'ar' ? "🚫 غير مسموح بالوصول" : "🚫 No permission");
}

$id = $_GET['id'] ?? 0;

$id = mysqli_real_escape_string($conn, $id);

$result = mysqli_query($conn, "SELECT * FROM gaza_requests WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $travel_reason = mysqli_real_escape_string($conn, $_POST['travel_reason']);

    $request_status = mysqli_real_escape_string($conn, $_POST['request_status']);
    $border_crossing = mysqli_real_escape_string($conn, $_POST['border_crossing']);
    $travel_date = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $travel_time = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $meeting_point = mysqli_real_escape_string($conn, $_POST['meeting_point']);
    $departure_point = mysqli_real_escape_string($conn, $_POST['departure_point']);
    $travel_route = mysqli_real_escape_string($conn, $_POST['travel_route']);
    $admin_notes = mysqli_real_escape_string($conn, $_POST['admin_notes']);

    $update = "UPDATE gaza_requests SET
    name='$name',
    phone='$phone',
    travel_reason='$travel_reason',
    request_status='$request_status',
    border_crossing='$border_crossing',
    travel_date='$travel_date',
    travel_time='$travel_time',
    meeting_point='$meeting_point',
    departure_point='$departure_point',
    travel_route='$travel_route',
    admin_notes='$admin_notes'
    WHERE id=$id";

    if(mysqli_query($conn, $update)){
        echo "
        <script>
        let lang = '$langcod';
        let msg = (lang == 'ar') ? '✅ تم التحديث بنجاح' : '✅ Updated successfully';
        alert(msg);
        window.location.href='gaza_request.php';
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
    <title><?= $langcod == 'ar' ? 'تعديل طلب غزة' : 'Edit Gaza Request' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/edit_gaza_request.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="main-wrapper animated-fadeIn">

    <div class="edit-card">

        <h2>
            ✏️ <?= $langcod == 'ar' ? 'تعديل طلب غزة' : 'Edit Gaza Request' ?>
        </h2>

        <div class="user-preview">
            <div>
                <span>👤 <?= $langcod == 'ar' ? 'الاسم' : 'Name' ?>:</span>
                <strong><?= htmlspecialchars($row['name'] ?? '') ?></strong>
            </div>

            <div>
                <span>📞 <?= $langcod == 'ar' ? 'الهاتف' : 'Phone' ?>:</span>
                <strong><?= htmlspecialchars($row['phone'] ?? '') ?></strong>
            </div>

            <div>
                <span>🌍 <?= $langcod == 'ar' ? 'الوجهة' : 'Destination' ?>:</span>
                <strong><?= htmlspecialchars($row['destination'] ?? '') ?></strong>
            </div>
        </div>

        <form method="POST" class="edit-form">

            <div class="form-grid">

                <div class="form-group">
                    <label>👤 <?= $langcod == 'ar' ? 'الاسم الكامل' : 'Full Name' ?></label>
                    <input type="text" name="name" value="<?= htmlspecialchars($row['name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>📞 <?= $langcod == 'ar' ? 'رقم الهاتف' : 'Phone Number' ?></label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($row['phone'] ?? '') ?>" required>
                </div>

                <div class="form-group full">
                    <label>✈️ <?= $langcod == 'ar' ? 'سبب السفر' : 'Travel Reason' ?></label>
                    <input type="text" name="travel_reason" value="<?= htmlspecialchars($row['travel_reason'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>📌 <?= $langcod == 'ar' ? 'حالة الطلب' : 'Request Status' ?></label>
                    <select name="request_status" required>
                        <option value="قيد المراجعة" <?= ($row['request_status']=='قيد المراجعة') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'قيد المراجعة' : 'Pending' ?></option>
                        <option value="مقبول" <?= ($row['request_status']=='مقبول') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'مقبول' : 'Approved' ?></option>
                        <option value="مرفوض" <?= ($row['request_status']=='مرفوض') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'مرفوض' : 'Rejected' ?></option>
                        <option value="تم التنسيق" <?= ($row['request_status']=='تم التنسيق') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'تم التنسيق' : 'Coordinated' ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label>🛣 <?= $langcod == 'ar' ? 'المعبر' : 'Border Crossing' ?></label>
                    <select name="border_crossing" required>
                        <option value="معبر رفح" <?= ($row['border_crossing']=='معبر رفح') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'معبر رفح' : 'Rafah Crossing' ?></option>
                        <option value="كرم أبو سالم" <?= ($row['border_crossing']=='كرم أبو سالم') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'كرم أبو سالم' : 'Kerem Shalom' ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label>📅 <?= $langcod == 'ar' ? 'تاريخ السفر' : 'Travel Date' ?></label>
                    <input type="date" name="travel_date" value="<?= htmlspecialchars($row['travel_date'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>⏰ <?= $langcod == 'ar' ? 'وقت السفر' : 'Travel Time' ?></label>
                    <input type="time" name="travel_time" value="<?= htmlspecialchars($row['travel_time'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>📍 <?= $langcod == 'ar' ? 'نقطة التجمع' : 'Meeting Point' ?></label>
                    <input type="text" name="meeting_point" value="<?= htmlspecialchars($row['meeting_point'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>🚌 <?= $langcod == 'ar' ? 'نقطة الانطلاق' : 'Departure Point' ?></label>
                    <input type="text" name="departure_point" value="<?= htmlspecialchars($row['departure_point'] ?? '') ?>">
                </div>

                <div class="form-group full">
                    <label>🧭 <?= $langcod == 'ar' ? 'مسار الرحلة' : 'Travel Route' ?></label>
                    <input type="text" name="travel_route" value="<?= htmlspecialchars($row['travel_route'] ?? '') ?>">
                </div>

                <div class="form-group full">
                    <label>📝 <?= $langcod == 'ar' ? 'ملاحظات الأدمن' : 'Admin Notes' ?></label>
                    <textarea name="admin_notes" rows="4"><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea>
                </div>

            </div>

            <button type="submit" name="update" class="save-btn">
                💾 <?= $langcod == 'ar' ? 'حفظ التحديث' : 'Save Changes' ?>
            </button>

        </form>

    </div>

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
