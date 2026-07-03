<?php
session_start();

include "../config.php";

$langcod = $_SESSION['lang'] ?? 'ar';

if (!isset($_SESSION['role'])) {
    die($langcod=='ar' ? "🚫 يجب تسجيل الدخول" : "🚫 Login required");
}

if ($_SESSION['role'] != 'admin') {
    die($langcod=='ar' ? "🚫 ليس لديك صلاحية" : "🚫 No permission");
}

$users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$flights = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM flights"));
$bookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings"));

$delayed = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM flights WHERE status='متأخرة'"));
$cancelled = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM flights WHERE status='ملغية'"));
$ontime = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM flights WHERE status='في الموعد'"));

$profitQuery = mysqli_query($conn, "SELECT SUM(price) AS total FROM flights");
$profitData = mysqli_fetch_assoc($profitQuery);
$totalProfit = $profitData['total'] ?? 0;

$airlineQuery = mysqli_query($conn, "SELECT airline, COUNT(*) AS total FROM flights GROUP BY airline ORDER BY total DESC LIMIT 1");
$airlineData = mysqli_fetch_assoc($airlineQuery);

$destinationQuery = mysqli_query($conn, "SELECT to_city, COUNT(*) AS total FROM bookings JOIN flights ON bookings.flight_id = flights.id GROUP BY to_city ORDER BY total DESC LIMIT 1");
$destinationData = mysqli_fetch_assoc($destinationQuery);
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod=='ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod=='ar' ? 'التقارير' : 'Reports' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/reports.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="dashboard-container animated-fadeIn">

    <h1>
        <?= $langcod=='ar' ? 'التقارير والإحصائيات' : 'Reports & Statistics' ?>
    </h1>

    <div class="stats-grid">

        <div class="stat-card">
            <h2><?php echo $users; ?></h2>
            <p><?= $langcod=='ar' ? 'المستخدمين' : 'Users' ?></p>
        </div>

        <div class="stat-card">
            <h2><?php echo $flights; ?></h2>
            <p><?= $langcod=='ar' ? 'الرحلات' : 'Flights' ?></p>
        </div>

        <div class="stat-card">
            <h2><?php echo $bookings; ?></h2>
            <p><?= $langcod=='ar' ? 'الحجوزات' : 'Bookings' ?></p>
        </div>

        <div class="stat-card profit-card">
            <h2><?php echo $totalProfit; ?>$</h2>
            <p><?= $langcod=='ar' ? 'إجمالي الأرباح' : 'Total Profit' ?></p>
        </div>

        <div class="stat-card status-delayed">
            <h2><?php echo $delayed; ?></h2>
            <p><?= $langcod=='ar' ? 'رحلات متأخرة' : 'Delayed Flights' ?></p>
        </div>

        <div class="stat-card status-cancelled">
            <h2><?php echo $cancelled; ?></h2>
            <p><?= $langcod=='ar' ? 'رحلات ملغية' : 'Cancelled Flights' ?></p>
        </div>

        <div class="stat-card status-ontime">
            <h2><?php echo $ontime; ?></h2>
            <p><?= $langcod=='ar' ? 'في الموعد' : 'On Time' ?></p>
        </div>

        <div class="stat-card text-badge-card">
            <h2>
                <?php
                if($airlineData && !empty($airlineData['airline'])){
                    echo htmlspecialchars($airlineData['airline']);
                } else {
                    echo $langcod=='ar' ? "لا يوجد" : "None";
                }
                ?>
            </h2>
            <p><?= $langcod=='ar' ? 'أكثر شركة استخدامًا' : 'Top Airline' ?></p>
        </div>

        <div class="stat-card text-badge-card">
            <h2>
                <?php
                if($destinationData && !empty($destinationData['to_city'])){
                    echo htmlspecialchars($destinationData['to_city']);
                } else {
                    echo $langcod=='ar' ? "لا يوجد" : "None";
                }
                ?>
            </h2>
            <p><?= $langcod=='ar' ? 'أكثر وجهة محجوزة' : 'Top Destination' ?></p>
        </div>

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
