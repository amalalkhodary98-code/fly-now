<?php
session_start();
include "../config.php";
include "../lang.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die($langcod == 'ar' ? "🚫 غير مسموح بالوصول" : "🚫 No permission");
}

$id = $_GET['id'] ?? 0;
$id = mysqli_real_escape_string($conn, $id);

if (!$id) {
    die($langcod == 'ar' ? "❌ لا يوجد رحلة" : "❌ Flight not found");
}

$query = "SELECT * FROM flights WHERE id='$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die($langcod == 'ar' ? "❌ الرحلة غير موجودة" : "❌ Flight does not exist");
}

if (isset($_POST['update'])) {

    $from_city = mysqli_real_escape_string($conn, $_POST['from_city']);
    $to_city   = mysqli_real_escape_string($conn, $_POST['to_city']);
    $price     = mysqli_real_escape_string($conn, $_POST['price']);
    $seats     = mysqli_real_escape_string($conn, $_POST['seats']);
    $airline   = mysqli_real_escape_string($conn, $_POST['airline']);
    $status    = mysqli_real_escape_string($conn, $_POST['status']);

    $update = "UPDATE flights SET
        from_city='$from_city',
        to_city='$to_city',
        price='$price',
        seats='$seats',
        airline='$airline',
        status='$status'
        WHERE id='$id'
    ";

    if (mysqli_query($conn, $update)) {
        echo "<script>
            let lang = '$langcod';
            let msg = (lang == 'ar') ? '✅ تم تعديل الرحلة بنجاح' : 'Flight updated successfully';
            alert(msg);
            window.location.href='manage_flights.php';
        </script>";
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
    <title><?= $langcod == 'ar' ? 'تعديل الرحلة' : 'Edit Flight' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/edit_flight.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="main-wrapper animated-fadeIn">

    <div class="edit-container">

        <h2>
            ✏️ <?= $langcod == 'ar' ? 'تعديل الرحلة' : 'Edit Flight' ?>
        </h2>

        <div class="info-box">
            <p><span>✈️ <?= $langcod == 'ar' ? 'من' : 'From' ?>:</span> <strong><?= htmlspecialchars($row['from_city']) ?></strong></p>
            <p><span>🛬 <?= $langcod == 'ar' ? 'إلى' : 'To' ?>:</span> <strong><?= htmlspecialchars($row['to_city']) ?></strong></p>
            <p><span>💰 <?= $langcod == 'ar' ? 'السعر' : 'Price' ?>:</span> <strong><?= htmlspecialchars($row['price']) ?>$</strong></p>
            <p><span>🪑 <?= $langcod == 'ar' ? 'المقاعد' : 'Seats' ?>:</span> <strong><?= htmlspecialchars($row['seats']) ?></strong></p>
        </div>

        <form method="POST" class="edit-form">

            <div class="form-grid">
                <div class="form-group">
                    <label><?= $langcod == 'ar' ? 'مدينة الانطلاق' : 'From City' ?></label>
                    <input type="text" name="from_city" value="<?= htmlspecialchars($row['from_city']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= $langcod == 'ar' ? 'مدينة الوصول' : 'To City' ?></label>
                    <input type="text" name="to_city" value="<?= htmlspecialchars($row['to_city']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= $langcod == 'ar' ? 'السعر' : 'Price' ?></label>
                    <input type="number" name="price" value="<?= htmlspecialchars($row['price']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= $langcod == 'ar' ? 'عدد المقاعد' : 'Seats' ?></label>
                    <input type="number" name="seats" value="<?= htmlspecialchars($row['seats']) ?>" required>
                </div>

                <div class="form-group full">
                    <label><?= $langcod == 'ar' ? 'شركة الطيران' : 'Airline' ?></label>
                    <input type="text" name="airline" value="<?= htmlspecialchars($row['airline'] ?? '') ?>" required>
                </div>

                <div class="form-group full">
                    <label><?= $langcod == 'ar' ? 'حالة الرحلة' : 'Status' ?></label>
                    <select name="status" required>
                        <option value="في الموعد" <?= ($row['status']=='في الموعد') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'في الموعد' : 'On Time' ?></option>
                        <option value="متأخرة" <?= ($row['status']=='متأخرة') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'متأخرة' : 'Delayed' ?></option>
                        <option value="ملغية" <?= ($row['status']=='ملغية') ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'ملغية' : 'Cancelled' ?></option>
                    </select>
                </div>
            </div>

            <button type="submit" name="update" class="save-btn">
                💾 <?= $langcod == 'ar' ? 'حفظ التعديل' : 'Save Changes' ?>
            </button>

        </form>

    </div>

    <div class="back-buttons">
        <a href="../index.php" class="back-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>

        <a href="javascript:history.back()" class="back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

</body>
</html>
