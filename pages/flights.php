<?php
session_start();

include "../lang.php";
include "../config.php";

$langcod = $_SESSION['lang'] ?? 'ar';

$from    = isset($_GET['from']) ? mysqli_real_escape_string($conn, $_GET['from']) : '';
$to      = isset($_GET['to']) ? mysqli_real_escape_string($conn, $_GET['to']) : '';
$status  = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$airline = isset($_GET['airline']) ? mysqli_real_escape_string($conn, $_GET['airline']) : '';

$conditions = [];

if (!empty($from)) {
    $conditions[] = "(from_city LIKE '%$from%' OR from_city_en LIKE '%$from%')";
}
if (!empty($to)) {
    $conditions[] = "(to_city LIKE '%$to%' OR to_city_en LIKE '%$to%')";
}
if (!empty($status)) {
    $conditions[] = "status = '$status'";
}
if (!empty($airline)) {
    $conditions[] = "airline LIKE '%$airline%'";
}

$sql = "SELECT * FROM flights";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}
$sql .= " ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die($langcod == 'ar' ? "خطأ في الاستعلام" : "Query Error");
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'الرحلات المتاحة' : 'Available Flights' ?></title>
    <link rel="stylesheet" href="../assets/css/flights-list-style.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="page-container">

    <h2><?= $langcod == 'ar' ? 'جدول الرحلات المتوفرة' : 'Available Flight Schedules' ?></h2>

    <div class="search-box">
        <form method="GET">
            <div class="filter-inputs">
                <input type="text" name="from" value="<?= htmlspecialchars($from) ?>" placeholder="<?= $langcod == 'ar' ? '🛫 من مدينة' : '🛫 From' ?>">
                <input type="text" name="to" value="<?= htmlspecialchars($to) ?>" placeholder="<?= $langcod == 'ar' ? '🛬 إلى مدينة' : '🛬 To' ?>">
                <input type="text" name="airline" value="<?= htmlspecialchars($airline) ?>" placeholder="<?= $langcod == 'ar' ? '✈️ شركة الطيران' : '✈️ Airline' ?>">
                
                <select name="status">
                    <option value=""><?= $langcod == 'ar' ? 'كل الحالات' : 'All Status' ?></option>
                    <option value="On Time" <?= $status == 'On Time' ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'في الموعد' : 'On Time' ?></option>
                    <option value="Delayed" <?= $status == 'Delayed' ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'متأخرة' : 'Delayed' ?></option>
                    <option value="Cancelled" <?= $status == 'Cancelled' ? 'selected' : '' ?>><?= $langcod == 'ar' ? 'ملغية' : 'Cancelled' ?></option>
                </select>
            </div>
            
            <button type="submit" class="search-btn">
                🔎 <?= $langcod == 'ar' ? 'تحديث البحث' : 'Search' ?>
            </button>
        </form>
    </div>

    <div class="flights-list-wrapper">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <?php $today = date("Y-m-d H:i:s"); ?>

            <div class="flight-strip-card animated-fadeIn">
                
                <div class="strip-section route-info">
                    <div class="station">
                        <h3><?= ($langcod == 'en' && !empty($row['from_city_en'])) ? $row['from_city_en'] : $row['from_city']; ?></h3>
                        <small>🛫 <?= $row['from_airport']; ?></small>
                    </div>
                    
                    <div class="route-line-divider">
                        <span class="time-text">🕒 <?= $row['departure_time']; ?></span>
                        <div class="line"><span class="plane-bullet">✈️</span></div>
                        <span class="airline-text">🏢 <?= $row['airline']; ?></span>
                    </div>
                    
                    <div class="station">
                        <h3><?= ($langcod == 'en' && !empty($row['to_city_en'])) ? $row['to_city_en'] : $row['to_city']; ?></h3>
                        <small>🛬 <?= $row['to_airport']; ?></small>
                    </div>
                </div>

                <div class="strip-section status-info">
                    <div class="seats-left">
                        <span><?= $langcod == 'ar' ? 'المقاعد المتاحة:' : 'Seats:' ?></span>
                        <strong>💺 <?= $row['seats']; ?></strong>
                    </div>
                    
                    <?php
                    if($row['status'] == 'On Time'){
                        echo "<span class='flight-tag ontime'>✅ ".($langcod=='ar'?'في الموعد':'On Time')."</span>";
                    } elseif($row['status'] == 'Delayed'){
                        echo "<span class='flight-tag delayed'>⏳ ".($langcod=='ar'?'متأخرة':'Delayed')."</span>";
                    } elseif($row['status'] == 'Cancelled'){
                        echo "<span class='flight-tag cancelled'>❌ ".($langcod=='ar'?'ملغية':'Cancelled')."</span>";
                    }
                    ?>
                </div>

                <div class="strip-section price-action">
                    <div class="price-box">
                        <small><?= $langcod == 'ar' ? 'السعر الإجمالي' : 'Total Price' ?></small>
                        <span class="price-value">💲<?= $row['price']; ?></span>
                    </div>
                    
                    <div class="btn-box">
                        <?php if($row['status'] == 'Cancelled'){ ?>
                            <button class="disabled-pill" disabled><?= $langcod == 'ar' ? 'ملغية' : 'Cancelled' ?></button>
                        <?php } elseif ($row['status'] == 'Delayed'){ ?>
                            <button class="disabled-pill" disabled><?= $langcod == 'ar' ? 'متأخرة' : 'Delayed' ?></button>
                        <?php } elseif ($row['departure_time'] <= $today){ ?>
                            <button class="disabled-pill" disabled><?= $langcod == 'ar' ? 'غير متاح' : 'Expired' ?></button>
                        <?php } elseif ($row['seats'] <= 0){ ?>
                            <button class="disabled-pill" disabled><?= $langcod == 'ar' ? 'ممتلئة' : 'Full' ?></button>
                        <?php } else { ?>
                            <a href="booking.php?id=<?= $row['id']; ?>" class="transparent-pill-btn">
                                <?= $langcod == 'ar' ? 'احجز الآن' : 'Book Now' ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>

            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-results-capsule">
            <p>❌ <?= $langcod == 'ar' ? 'عذراً، لم نجد رحلات متوفرة تطابق تصفية البحث الحالية.' : 'No flights match your filter settings.' ?></p>
        </div>
    <?php endif; ?>
    </div>

    <div class="back-buttons">
        <a href="javascript:history.back()" class="back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

</body>
</html>
