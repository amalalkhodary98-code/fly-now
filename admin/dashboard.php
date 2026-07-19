<?php
session_start();
include "../lang.php";
include "../config.php";


if (!isset($_SESSION['role'])) {

    die($langcod == 'ar' ? "🚫 يجب تسجيل الدخول" : "🚫 Login required");

}


$newBookings = mysqli_query(
$conn,
"SELECT * FROM bookings WHERE seen='0'"
);

$countBookings = mysqli_num_rows($newBookings);


$bookings = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM bookings")
);

$flights = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM flights")
);


$users = mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM users")
);


$delayed = mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM flights
WHERE status='متأخرة'"
)
);


$cancelled = mysqli_num_rows(
mysqli_query(
$conn,
"SELECT * FROM flights
WHERE status='ملغية'"
)
);

?>

<!DOCTYPE html>

<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta charset="UTF-8">

<title>
<?= $langcod == 'ar' ? 'لوحة التحكم' : 'Dashboard' ?>
</title>

<link rel="stylesheet"href="../assets/css/admin/dashboard.css">
</head>

<body class="admin-page">

<div class="dashboard-container">

<h1>
<?= $langcod == 'ar' ? 'لوحة تحكم الأدمن' : 'Admin Dashboard' ?>
</h1>

<div class="stats">

    <div class="stat-card">

        <h2>
            <?php echo $users; ?>
        </h2>

        <p>
            <?= $langcod == 'ar' ? 'المستخدمين' : 'Users' ?>
        </p>

    </div>

    <div class="stat-card">

        <h2>
            <?php echo $flights; ?>
        </h2>

        <p>
            <?= $langcod == 'ar' ? 'الرحلات' : 'Flights' ?>
        </p>

    </div>

    <div class="stat-card">

        <h2>
            <?php echo $bookings; ?>
        </h2>

        <p>
            <?= $langcod == 'ar' ? 'الحجوزات' : 'Bookings' ?>
        </p>

    </div>

    <div class="stat-card">

        <h2>
            <?php echo $delayed; ?>
        </h2>

        <p>
            <?= $langcod == 'ar' ? 'رحلات متأخرة' : 'Delayed Flights' ?>
        </p>

    </div>

    <div class="stat-card">

        <h2>
            <?php echo $cancelled; ?>
        </h2>

        <p>
            <?= $langcod == 'ar' ? 'رحلات ملغية' : 'Cancelled Flights' ?>
        </p>

    </div>

</div>


<div class="dashboard-buttons">

    <a href="add_flight.php" class="dashboard-btn">
        <?= $langcod == 'ar' ? 'إضافة رحلة' : 'Add Flight' ?>
    </a>

    <a href="manage_bookings.php" class="dashboard-btn">
        <?= $langcod == 'ar' ? 'إدارة الحجوزات' : 'Manage Bookings' ?>
    </a>

    <a href="gaza_request.php" class="dashboard-btn">
        <?= $langcod == 'ar' ? 'طلبات أهل غزة' : 'Gaza Requests' ?>
    </a>

    <a href="manage_flights.php" class="dashboard-btn">
        <?= $langcod == 'ar' ? 'إدارة الرحلات' : 'Manage Flights' ?>
    </a>

    <a href="reports.php" class="dashboard-btn">
        <?= $langcod == 'ar' ? 'التقارير' : 'Reports' ?>
    </a>

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

</div>

</body>
</html>