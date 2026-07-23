<?php
session_start();

$langcod = $_SESSION['lang'] ?? 'ar';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../config.php";

$flight_id = $_GET['id'] ?? 0;

if (!$flight_id) {
    die($langcod=='ar' ? "❌ لا يوجد رحلة" : "❌ No flight found");
}

$sql = "SELECT * FROM flights WHERE id='$flight_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die($langcod=='ar' ? "لا توجد بيانات للرحلة" : "No flight data found");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkFlight = mysqli_query($conn,
        "SELECT * FROM flights WHERE id='$flight_id'"
    );

    $flightData = mysqli_fetch_assoc($checkFlight);

    if ($flightData['seats'] <= 0) {
        die($langcod=='ar' ? "❌ لا توجد مقاعد متوفرة" : "❌ No seats available");
    }

    if (strtolower($flightData['status']) == 'cancelled') {
        die($langcod=='ar' ? "❌ الرحلة ملغية" : "❌ Flight cancelled");
    }

    $newSeats = $flightData['seats'] - 1;

    mysqli_query($conn,
        "UPDATE flights SET seats='$newSeats' WHERE id='$flight_id'"
    );

    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $date = $_POST['travel_date'] ?? '';
    $time = $_POST['travel_time'] ?? '';
    $trip = $_POST['trip_type'] ?? '';
    $class = $_POST['class_type'] ?? '';
    $seat = $_POST['seat'] ?? '';
    $bags = $_POST['bags'] ?? '';
    $payment = $_POST['payment_method'] ?? '';

    $insert = "
    INSERT INTO bookings (
        flight_id,
        user_id,
        name,
        phone,
        travel_date,
        travel_time,
        trip_type,
        class_type,
        seat,
        bags,
        payment_method
    )
    VALUES (
        '$flight_id',
        '$user_id',
        '$name',
        '$phone',
        '$date',
        '$time',
        '$trip',
        '$class',
        '$seat',
        '$bags',
        '$payment'
    )
    ";

    if (mysqli_query($conn, $insert)) {

        $_SESSION['success'] =
        ($langcod=='ar')
        ? "✅ تم إرسال طلب الحجز للمراجعة"
        : "✅ Booking sent for review";

        header("Location: booking.php?id=$flight_id");
        exit();

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod=='ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod=='ar' ? 'تأكيد الحجز' : 'Booking Confirmation' ?></title>
    <link rel="stylesheet" href="../assets/css/booking-style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="box">

    <h2><?= $langcod=='ar' ? 'تأكيد الحجز' : 'Confirm Booking' ?></h2>

    <?php
    if (isset($_SESSION['success'])) {
        echo "<div class='success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>

    <div class="flight-card">
        <div class="flight-route">
            <div class="route-block">
                <span><?= $langcod=='ar' ? 'من' : 'From' ?></span>
                <strong><?= $row['from_city'] ?></strong>
                <small><?= $row['from_airport'] ?></small>
            </div>
            <div class="route-icon">✈️</div>
            <div class="route-block">
                <span><?= $langcod=='ar' ? 'إلى' : 'To' ?></span>
                <strong><?= $row['to_city'] ?></strong>
                <small><?= $row['to_airport'] ?></small>
            </div>
        </div>
        
        <div class="flight-meta">
            <div class="meta-item">
                <span><?= $langcod=='ar' ? 'شركة الطيران' : 'Airline' ?></span>
                <strong><?= $row['airline'] ?></strong>
            </div>
            <div class="meta-item">
                <span><?= $langcod=='ar' ? 'المقاعد المتاحة' : 'Available Seats' ?></span>
                <strong><?= $row['seats'] ?></strong>
            </div>
            <div class="meta-item">
                <span><?= $langcod=='ar' ? 'السعر' : 'Price' ?></span>
                <strong class="price-tag"><?= $row['price'] ?>$</strong>
            </div>
        </div>

        <?php
        $status = strtolower(trim($row['status']));
        if ($status == 'cancelled' || $status == 'ملغي') {
            echo "<div class='flight-status cancelled'>❌ ".($langcod=='ar' ? 'الرحلة ملغية' : 'Flight cancelled')."</div>";
        } elseif ($status == 'delayed' || $status == 'متأخرة') {
            echo "<div class='flight-status delayed'>⏳ ".($langcod=='ar' ? 'الرحلة متأخرة' : 'Flight delayed')."</div>";
        } else {
            echo "<div class='flight-status ontime'>✅ ".($langcod=='ar' ? 'الرحلة متاحة للحجز' : 'Available for booking')."</div>";
        }
        ?>
    </div>

    <form method="POST">

        <div class="form-group">
            <input type="text" name="name" placeholder="<?= $langcod=='ar' ? 'اسمك الكامل' : 'Your Full Name' ?>" required>
        </div>

        <div class="form-group">
            <input type="text" name="phone" placeholder="<?= $langcod=='ar' ? 'رقم الهاتف' : 'Phone Number' ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label><?= $langcod == 'ar' ? 'تاريخ الحجز' : 'Booking Date' ?></label>
                <input type="text" name="travel_date" class="date-picker" placeholder="<?= $langcod == 'ar' ? 'اختر التاريخ' : 'Select Date' ?>" required>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? 'وقت السفر' : 'Travel Time' ?></label>
                <input type="text" name="travel_time" class="time-picker" placeholder="<?= $langcod == 'ar' ? 'اختر وقت السفر' : 'Select Travel Time' ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <select name="trip_type" required>
                    <option value=""><?= $langcod=='ar' ? 'نوع الرحلة' : 'Trip Type' ?></option>
                    <option value="ذهاب">ذهاب</option>
                    <option value="ذهاب وعودة">ذهاب وعودة</option>
                </select>
            </div>

            <div class="form-group">
                <select name="class_type" required>
                    <option value=""><?= $langcod=='ar' ? 'درجة السفر' : 'Class' ?></option>
                    <option value="اقتصادية">اقتصادية</option>
                    <option value="سياحية">سياحية</option>
                    <option value="أولى">أولى</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <select name="seat" required>
                    <option value=""><?= $langcod=='ar' ? 'اختر المقعد' : 'Select Seat' ?></option>
                    <option value="A1">A1</option>
                    <option value="A2">A2</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                </select>
            </div>

            <div class="form-group">
                <select name="bags" required>
                    <option value=""><?= $langcod=='ar' ? 'عدد الحقائب' : 'Bags' ?></option>
                    <option value="0"><?= $langcod=='ar' ? 'بدون حقائب' : 'No Bags' ?></option>
                    <option value="1"><?= $langcod=='ar' ? 'حقيبة واحدة' : '1 Bag' ?></option>
                    <option value="2"><?= $langcod=='ar' ? 'حقيبتان' : '2 Bags' ?></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <select name="payment_method" required>
                <option value=""><?= $langcod=='ar' ? 'طريقة الدفع' : 'Payment Method' ?></option>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="PayPal">PayPal</option>
                <option value="Apple Pay">Apple Pay</option>
            </select>
        </div>

        <div class="booking-summary">
            <h3><?= $langcod=='ar' ? 'ملخص الحجز وثمن التذكرة' : 'Booking Summary' ?></h3>
            <div class="summary-line">
                <span><?= $row['from_city'] ?> ← <?= $row['to_city'] ?></span>
                <strong><?= $row['price'] ?>$</strong>
            </div>
            <small><?= $row['airline'] ?></small>
        </div>

        <?php if ($row['seats'] > 0 && strtolower($row['status']) != 'cancelled') { ?>
            <button type="submit" class="submit-btn">
                <?= $langcod=='ar' ? 'تأكيد وحجز الرحلة الآن' : 'Confirm Booking Now' ?>
            </button>
        <?php } else { ?>
            <button type="button" class="submit-btn disabled" disabled>
                <?= $langcod=='ar' ? 'غير متاح للحجز' : 'Not Available' ?>
            </button>
        <?php } ?>

    </form>

    <div class="back-buttons">
        <a href="../index.php" class="back-btn home-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
        <a href="javascript:history.back()" class="back-btn prev-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

<script src="https://jsdelivr.net"></script>
<script>
flatpickr(".date-picker", {
    dateFormat: "Y-m-d",
    locale: "<?= $langcod == 'ar' ? 'ar' : 'default' ?>"
});

flatpickr(".time-picker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    locale: "<?= $langcod == 'ar' ? 'ar' : 'default' ?>"
});
</script>
</body>
</html>
