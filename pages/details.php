<?php
include "../lang.php";
include "../config.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM flights WHERE id = $id";
$result = mysqli_query($conn, $sql);
$flight = mysqli_fetch_assoc($result);

if (!$flight) {
    die($langcod == 'ar' ? "❌ لم يتم العثور على بيانات الرحلة" : "❌ Flight details not found");
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'تفاصيل الرحلة' : 'Flight Details' ?></title>
    <link rel="stylesheet" href="../assets/css/details-style.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="box">

    <h2><?= $langcod == 'ar' ? 'تفاصيل الرحلة' : 'Flight Details' ?></h2>

    <div class="route-display">
        <h3>
            <span><?php echo $flight['from_city']; ?></span>
            <span class="plane-icon">✈️</span>
            <span><?php echo $flight['to_city']; ?></span>
        </h3>
    </div>

    <div class="details-list">
        <div class="detail-item">
            <span class="label">🕒 <?= $langcod == 'ar' ? 'وقت الإقلاع' : 'Departure Time' ?>:</span>
            <span class="value"><?php echo $flight['departure_time']; ?></span>
        </div>

        <div class="detail-item price-item">
            <span class="label">💲 <?= $langcod == 'ar' ? 'السعر الإجمالي' : 'Total Price' ?>:</span>
            <span class="value price-tag"><?php echo $flight['price']; ?>$</span>
        </div>
    </div>

    <div class="action-section">
        <a href="booking.php?flight_id=<?php echo $flight['id']; ?>" class="booking-link">
            <button class="confirm-btn">
                <?= $langcod == 'ar' ? 'تأكيد وحجز الرحلة الآن' : 'Confirm Booking Now' ?>
            </button>
        </a>
    </div>

    <div class="navigation-buttons">
        <a href="../index.php" class="nav-btn home-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
        <button onclick="history.back()" class="nav-btn back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </button>
    </div>

</div>

</body>
</html>
