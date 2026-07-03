<?php
include("../lang.php");
include("../config.php");

$id = $_GET['id'];

$sql = "DELETE FROM bookings WHERE id = $id";

mysqli_query($conn, $sql);

$msg = ($langcod == 'ar')
    ? "🗑 تم حذف الحجز"
    : "🗑 Booking deleted";

$_SESSION['msg'] = $msg;

header("Location: my_bookings.php");
exit;
?>