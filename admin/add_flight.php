<?php
session_start();
include "../config.php";
include "../lang.php";

$message_html = ""; 

if(isset($_POST['add']) && isset($_POST['departure_time'])) {

    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $price = $_POST['price'];
    $departure_time = $_POST['departure_time'];
    $airline = $_POST['airline'];
    $from_airport = $_POST['from_airport'];
    $to_airport = $_POST['to_airport'];
    $seats = $_POST['seats'];
    $status = $_POST['status'];

    $sql = "INSERT INTO flights
    (
        from_city,
        to_city,
        departure_time,
        price,
        seats,
        airline,
        from_airport,
        to_airport,
        status
    )
    VALUES
    (
        '$source',
        '$destination',
        '$departure_time',
        '$price',
        '$seats',
        '$airline',
        '$from_airport',
        '$to_airport',
        '$status'
    )";

    if(mysqli_query($conn, $sql)) {
        $message_html = "
        <div class='alert-msg success-msg'>
        ".($langcod == 'ar' ? '✅ تم إضافة الرحلة بنجاح' : 'Flight added successfully')."
        </div>";
    } else {
        $message_html = "
        <div class='alert-msg error-msg'>
        ".($langcod == 'ar' ? '❌ خطأ' : 'Error')." : ". mysqli_error($conn) ."
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'إضافة رحلة' : 'Add Flight' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/add_flight.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="admin-page">

    <div class="main-wrapper animated-fadeIn">

        <div class="admin-container">

            <h2>
                ✈️ <?= $langcod == 'ar' ? 'إضافة رحلة جديدة' : 'Add New Flight' ?>
            </h2>

            <?= $message_html ?>

            <form method="POST" class="admin-form">

                <input type="text" name="source" placeholder="<?= $langcod == 'ar' ? 'من' : 'From' ?>" required>

                <input type="text" name="destination" placeholder="<?= $langcod == 'ar' ? 'إلى' : 'To' ?>" required>

                <input type="text" name="airline" placeholder="<?= $langcod == 'ar' ? 'شركة الطيران' : 'Airline' ?>" required>

                <input type="text" name="from_airport" placeholder="<?= $langcod == 'ar' ? 'مطار الإقلاع' : 'Departure Airport' ?>" required>

                <input type="text" name="to_airport" placeholder="<?= $langcod == 'ar' ? 'مطار الوصول' : 'Arrival Airport' ?>" required>

                <input type="number" name="price" placeholder="<?= $langcod == 'ar' ? 'السعر' : 'Price' ?>" required>

                <input type="number" name="seats" placeholder="<?= $langcod == 'ar' ? 'عدد المقاعد' : 'Seats' ?>" required>

                <input type="text" name="departure_time" class="date-picker" placeholder="<?= $langcod == 'ar' ? 'اختر التاريخ والوقت' : 'Select Date & Time' ?>" required>

                <select name="status" required>
                    <option value="">
                        <?= $langcod == 'ar' ? 'اختر حالة الرحلة' : 'Select Status' ?>
                    </option>
                    <option value="في الموعد"><?= $langcod == 'ar' ? 'في الموعد' : 'On Time' ?></option>
                    <option value="متأخرة"><?= $langcod == 'ar' ? 'متأخرة' : 'Delayed' ?></option>
                    <option value="ملغية"><?= $langcod == 'ar' ? 'ملغية' : 'Cancelled' ?></option>
                </select>

                <button type="submit" name="add">
                    <?= $langcod == 'ar' ? 'إضافة الرحلة' : 'Add Flight' ?>
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    flatpickr(".date-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        locale: "<?= $langcod == 'ar' ? 'ar' : 'default' ?>"
    });
    </script>
</body>
</html>
