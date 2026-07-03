<?php
session_start();

$langcod = $_SESSION['lang'] ?? 'ar';

include "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM bookings WHERE id='$booking_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('".($langcod=='ar' ? 'تم حذف الحجز بنجاح' : 'Booking deleted successfully')."');
            window.location.href='my_bookings.php';
        </script>";
        exit();
    } else {
        echo ($langcod=='ar' ? "خطأ: " : "Error: ") . mysqli_error($conn);
    }
} else {
    echo "<script>
        alert('".($langcod=='ar' ? 'لا يوجد حجز محدد' : 'No booking found')."');
        window.location.href='my_bookings.php';
    </script>";
    exit();
}
?>
