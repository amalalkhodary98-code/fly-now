<?php
session_start();
include "../lang.php";
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?lang=".$langcod);
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $booking_id = mysqli_real_escape_string($conn, $_GET['delete']);

    $bookingQuery = "
    SELECT * FROM bookings
    WHERE id='$booking_id'
    AND user_id='$user_id'
    ";

    $bookingResult = mysqli_query($conn, $bookingQuery);
    $bookingData = mysqli_fetch_assoc($bookingResult);

    if($bookingData){
        $flight_id = $bookingData['flight_id'];

        $flightQuery = "
        SELECT * FROM flights
        WHERE id='$flight_id'
        ";

        $flightResult = mysqli_query($conn, $flightQuery);
        $flightData = mysqli_fetch_assoc($flightResult);

        $newSeats = $flightData['seats'] + 1;

        mysqli_query(
            $conn,
            "UPDATE flights SET seats='$newSeats' WHERE id='$flight_id'"
        );

        $delete = "
        DELETE FROM bookings
        WHERE id='$booking_id'
        AND user_id='$user_id'
        ";

        mysqli_query($conn, $delete);

        $_SESSION['msg'] =
        $langcod == 'ar'
        ? "تم إلغاء الحجز بنجاح ❌"
        : "Booking cancelled successfully ❌";
    }

    header("Location: my_bookings.php?lang=".$langcod);
    exit();
}

$sql = "
SELECT bookings.*,
flights.from_city,
flights.to_city,
flights.price,
flights.airline,
flights.from_airport,
flights.to_airport,
flights.status AS flight_status
FROM bookings
JOIN flights ON bookings.flight_id = flights.id
WHERE bookings.user_id = '$user_id'
ORDER BY bookings.id DESC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'حجوزاتي' : 'My Bookings' ?></title>
    <link rel="stylesheet" href="../assets/css/my-bookings-style.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="bookings-container">

    <h1><?= $langcod == 'ar' ? 'حجوزاتي' : 'My Bookings' ?></h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo "<div class='success-msg'>".$_SESSION['msg']."</div>";
        unset($_SESSION['msg']);
    }
    ?>

    <div class="cards-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>

        <div class="booking-card">
            <div class="booking-header">
                <h2>
                <?php
                $from_city = $row['from_city'];
                $to_city = $row['to_city'];

                if($langcod == 'en'){
                    if($from_city == 'عمان') { $from_city = 'Amman'; }
                    elseif($from_city == 'دبي') { $from_city = 'Dubai'; }

                    if($to_city == 'عمان') { $to_city = 'Amman'; }
                    elseif($to_city == 'دبي') { $to_city = 'Dubai'; }
                }
                ?>
                <?= $from_city; ?> <span class="arrow-icon">✈️</span> <?= $to_city; ?>
                </h2>
                <span class="booking-price"><?= $row['price']; ?>$</span>
            </div>

            <div class="booking-body">
                <div class="info-row">
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'شركة الطيران:' : 'Airline:' ?></span>
                        <strong><?= $row['airline']; ?></strong>
                    </div>
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'الاسم:' : 'Name:' ?></span>
                        <strong><?= $row['name']; ?></strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'مطار الإقلاع:' : 'Departure:' ?></span>
                        <strong><?= $row['from_airport']; ?></strong>
                    </div>
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'مطار الوصول:' : 'Arrival:' ?></span>
                        <strong><?= $row['to_airport']; ?></strong>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'التاريخ والوقت:' : 'Date & Time:' ?></span>
                        <strong>📅 <?= $row['travel_date']; ?> | ⏰ <?= $row['travel_time']; ?></strong>
                    </div>
                    <div class="info-item">
                        <span>📞 <?= $langcod == 'ar' ? 'الهاتف:' : 'Phone:' ?></span>
                        <strong><?= $row['phone']; ?></strong>
                    </div>
                </div>

                <div class="info-row flex-3">
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'الدرجة:' : 'Class:' ?></span>
                        <strong>
                        <?php
                        $class = $row['class_type'];
                        if($langcod == 'en'){
                            if($class == 'اقتصادية') { echo 'Economy'; }
                            elseif($class == 'رجال أعمال') { echo 'Business'; }
                            elseif($class == 'أولى') { echo 'First Class'; }
                            else { echo $class; }
                        } else {
                            echo $class;
                        }
                        ?>
                        </strong>
                    </div>
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'المقعد:' : 'Seat:' ?></span>
                        <strong><?= $row['seat']; ?></strong>
                    </div>
                    <div class="info-item">
                        <span><?= $langcod == 'ar' ? 'الحقائب:' : 'Bags:' ?></span>
                        <strong><?= $row['bags']; ?></strong>
                    </div>
                </div>

                <div class="status-row">
                    <div class="info-item">
                        <span>💳 <?= $langcod == 'ar' ? 'الدفع:' : 'Payment:' ?></span>
                        <strong><?= $row['payment_method']; ?></strong>
                    </div>
                    
                    <div class="status-tags">
                        <?php
                        if($row['flight_status'] == 'On Time' || $row['flight_status'] == 'في الموعد'){
                            echo "<span class='flight-tag ontime'>✅ ".($langcod=='ar'?'في الموعد':'On Time')."</span>";
                        } elseif($row['flight_status'] == 'Delayed' || $row['flight_status'] == 'متأخرة'){
                            echo "<span class='flight-tag delayed'>⏳ ".($langcod=='ar'?'متأخرة':'Delayed')."</span>";
                        } elseif($row['flight_status'] == 'Cancelled' || $row['flight_status'] == 'ملغية'){
                            echo "<span class='flight-tag cancelled'>❌ ".($langcod=='ar'?'ملغية':'Cancelled')."</span>";
                        }
                        ?>

                        <span class="status-tag">
                            📌 
                            <?php
                            $status = $row['status'];
                            if($langcod == 'en'){
                                if($status == 'تم التأكيد') { echo 'Confirmed'; }
                                elseif($status == 'قيد المراجعة') { echo 'Pending'; }
                                elseif($status == 'ملغي') { echo 'Cancelled'; }
                                else { echo $status; }
                            } else {
                                echo $status;
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="booking-buttons">
                <a href="ticket.php?id=<?= $row['id']; ?>" class="ticket-btn">
                    🎫 <?= $langcod == 'ar' ? 'عرض التذكرة' : 'View Ticket' ?>
                </a>
                <a href="my_bookings.php?delete=<?= $row['id']; ?>&lang=<?= $langcod ?>"
                   class="cancel-btn"
                   onclick="return confirm('<?= $langcod == 'ar' ? 'هل أنت متأكد من الإلغاء؟' : 'Are you sure?' ?>')">
                    ❌ <?= $langcod == 'ar' ? 'إلغاء الحجز' : 'Cancel' ?>
                </a>
            </div>
        </div>

        <?php endwhile; ?>
    <?php else: ?>
        <p class="empty-bookings">
            <?= $langcod == 'ar' ? 'لا يوجد حجوزات حتى الآن 😢' : 'No bookings yet 😢' ?>
        </p>
    <?php endif; ?>
    </div>

    <div class="back-buttons">
        <a href="../index.php" class="back-btn home-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
        <a href="javascript:history.back()" class="back-btn prev-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

</body>
</html>
