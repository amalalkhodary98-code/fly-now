<?php
session_start();

include("../config.php");
include("../lang.php");

$langcod = $_SESSION['lang'] ?? 'ar';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php?lang=".$langcod);
    exit();
}

if(!isset($_GET['id'])){
    die($langcod == 'ar' ? "❌ لا يوجد حجز" : "❌ No booking found");
}

$booking_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "
SELECT bookings.*,
flights.from_city,
flights.to_city,
flights.price,
flights.airline,
flights.from_airport,
flights.to_airport
FROM bookings
JOIN flights ON bookings.flight_id = flights.id
WHERE bookings.id='$booking_id'
AND bookings.user_id='$user_id'
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(!$row){
    die($langcod == 'ar' ? '❌ التذكرة غير موجودة' : '❌ Ticket not found');
}
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'تذكرتي الرقمية' : 'My Ticket' ?></title>
    <link rel="stylesheet" href="../assets/css/ticket.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="ticket-container animated-fadeIn">

    <div class="ticket-card">

        <div class="ticket-header">
            <h1>Fly Now ✈️</h1>
            <span class="pass-type-badge"><?= $langcod == 'ar' ? 'بطاقة صعود الطائرة' : 'BOARDING PASS' ?></span>
        </div>

        <div class="ticket-body">
            
            <div class="flight-route-section">
                <div class="route-city">
                    <h2><?= htmlspecialchars($row['from_city']); ?></h2>
                    <small>🛫 <?= htmlspecialchars($row['from_airport']); ?></small>
                </div>
                <div class="route-plane-divider">
                    <div class="dashed-line"></div>
                    <span class="plane-icon">✈️</span>
                </div>
                <div class="route-city">
                    <h2><?= htmlspecialchars($row['to_city']); ?></h2>
                    <small>🛬 <?= htmlspecialchars($row['to_airport']); ?></small>
                </div>
            </div>
ة
            <div class="ticket-info-grid">
                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'اسم المسافر رباعي' : 'Passenger Name' ?></h3>
                    <p><?= htmlspecialchars($row['name']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'رقم وثيقة الحجز' : 'Booking ID' ?></h3>
                    <p class="highlight-id"># <?= htmlspecialchars($row['id']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'الناقل الجوي' : 'Airline Carrier' ?></h3>
                    <p>🏢 <?= htmlspecialchars($row['airline']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'تاريخ السفر' : 'Travel Date' ?></h3>
                    <p>📅 <?= htmlspecialchars($row['travel_date']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'وقت الإقلاع' : 'Travel Time' ?></h3>
                    <p>🕒 <?= htmlspecialchars($row['travel_time']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'رقم المقعد' : 'Seat' ?></h3>
                    <p class="seat-badge">💺 <?= htmlspecialchars($row['seat']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'الأمتعة والحقائب' : 'Bags' ?></h3>
                    <p>💼 <?= htmlspecialchars($row['bags']); ?></p>
                </div>

                <div class="info-box">
                    <h3><?= $langcod == 'ar' ? 'طريقة وسيلة الدفع' : 'Payment Method' ?></h3>
                    <p>💳 <?= htmlspecialchars($row['payment_method']); ?></p>
                </div>
            </div>

            <div class="qr-section-wrapper">
                <div class="qr-code-holder">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=FlyNowBooking<?= $row['id']; ?>" alt="Ticket QR Code">
                </div>
                <div class="price-summary-box">
                    <small><?= $langcod == 'ar' ? 'ثمن التذكرة الإجمالي' : 'Total Fair' ?></small>
                    <strong><?= htmlspecialchars($row['price']); ?>$</strong>
                </div>
            </div>

            <div class="ticket-footer-action">
                <button onclick="window.print()" class="print-pill-btn">
                    🖨️ <?= $langcod == 'ar' ? 'تحميل أو طباعة التذكرة' : 'Download / Print Pass' ?>
                </button>
            </div>

        </div>
    </div>

    <div class="navigation-footer">
        <a href="../index.php?lang=<?= $langcod ?>" class="nav-pill-btn home-pill">
            Home 🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
    </div>

</div>

</body>
</html>
