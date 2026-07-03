<?php
session_start();
include "../config.php";
include "../lang.php";

if (!isset($_SESSION['role'])) {
    die($langcod == 'ar' ? "🚫 يجب تسجيل الدخول" : "🚫 Login required");
}

$langcod = $_SESSION['lang'] ?? 'ar';

if(isset($_GET['confirm'])){

    $id = $_GET['confirm'];

    mysqli_query($conn,
    "UPDATE bookings 
     SET status='تم التأكيد'
     WHERE id='$id'");

    echo "<script>
        alert('".($langcod=='ar' ? 'تم تأكيد الحجز' : 'Booking confirmed')."');
        window.location.href='manage_bookings.php';
    </script>";
    exit;
}

if(isset($_GET['cancel'])){

    $id = $_GET['cancel'];

    mysqli_query($conn,
    "UPDATE bookings 
     SET status='ملغي'
     WHERE id='$id'");

    echo "<script>
        alert('".($langcod=='ar' ? 'تم إلغاء الحجز' : 'Booking cancelled')."');
        window.location.href='manage_bookings.php';
    </script>";
    exit;
}

$sql = "SELECT bookings.*, flights.from_city, flights.to_city
        FROM bookings
        JOIN flights
        ON bookings.flight_id = flights.id
        ORDER BY bookings.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod=='ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod=='ar' ? 'إدارة الحجوزات' : 'Manage Bookings' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/manage_bookings.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="main-layout-wrapper animated-fadeIn">

    <h2 class="page-title">
        📋 <?= $langcod=='ar' ? 'إدارة الحجوزات' : 'Bookings Management' ?>
    </h2>

    <div class="bookings-container">

        <?php while($row = mysqli_fetch_assoc($result)) { 
            $status_raw = $row['status'] ?? '';
            $status_class = "pending";
            if ($status_raw == 'تم التأكيد' || strtolower($status_raw) == 'confirmed') { $status_class = "approved"; }
            if ($status_raw == 'ملغي' || strtolower($status_raw) == 'cancelled' || $status_raw == 'ملغية') { $status_class = "rejected"; }
        ?>

        <div class="flight-card">

            <h3>
                <?= htmlspecialchars($row['from_city']) ?> ➜ <?= htmlspecialchars($row['to_city']) ?>
            </h3>

            <div class="card-passenger-data">
                <p><span>👤 <?= $langcod=='ar' ? 'الاسم' : 'Name' ?>:</span> <strong><?php echo htmlspecialchars($row['name']); ?></strong></p>
                <p><span>📞 <?= $langcod=='ar' ? 'الهاتف' : 'Phone' ?>:</span> <strong><?php echo htmlspecialchars($row['phone']); ?></strong></p>
                <p><span>📅 <?= $langcod=='ar' ? 'التاريخ' : 'Date' ?>:</span> <strong><?php echo htmlspecialchars($row['travel_date']); ?></strong></p>
                <p><span>🪑 <?= $langcod=='ar' ? 'المقعد' : 'Seat' ?>:</span> <strong><?php echo htmlspecialchars($row['seat']); ?></strong></p>
                <p><span>🧳 <?= $langcod=='ar' ? 'الحقائب' : 'Bags' ?>:</span> <strong><?php echo htmlspecialchars($row['bags']); ?></strong></p>
                <p><span>💳 <?= $langcod=='ar' ? 'الدفع' : 'Payment' ?>:</span> <strong><?php echo htmlspecialchars($row['payment_method']); ?></strong></p> 
            </div>

            <div class="card-status-wrapper">
                <span class="status-title">📌 <?= $langcod=='ar' ? 'الحالة' : 'Status' ?>:</span>
                <span class="status-badge <?= $status_class ?>">
                    <?php echo htmlspecialchars($status_raw); ?>
                </span>
            </div>

            <div class="card-actions">
                <a class="book-btn" href="?confirm=<?php echo $row['id']; ?>">
                    ✅ <?= $langcod=='ar' ? 'تأكيد' : 'Confirm' ?>
                </a>

                <a class="cancel-btn" href="?cancel=<?php echo $row['id']; ?>">
                    ❌ <?= $langcod=='ar' ? 'إلغاء' : 'Cancel' ?>
                </a>
            </div>

        </div>

        <?php } ?>

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
