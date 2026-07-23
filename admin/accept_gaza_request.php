<?php
session_start();
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("🚫 يجب تسجيل الدخول كمسؤول");
}

$langcod = $_SESSION['lang'] ?? 'ar';

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = intval($_GET['id']);

    $update = mysqli_query($conn, 
        "UPDATE gaza_requests 
         SET request_status = 'approved' 
         WHERE id = $id"
    );

    if (!$update) {
        die("SQL Error: " . mysqli_error($conn));
    }

    if (mysqli_affected_rows($conn) > 0) {

        $msg = ($langcod == 'ar')
            ? "تم قبول الطلب بنجاح"
            : "Request approved successfully";

        echo "<script>
            alert('$msg');
            window.location.href = document.referrer;
        </script>";
        exit();

    } else {

        $msg = ($langcod == 'ar')
            ? "الطلب مقبول بالفعل أو لم يتم العثور عليه"
            : "Request already approved or not found";

        echo "<script>
            alert('$msg');
            window.location.href = document.referrer;
        </script>";
        exit();
    }
} else {

    $msg = ($langcod == 'ar')
        ? "رقم الطلب غير موجود"
        : "Request ID not found";

    echo "<script>
        alert('$msg');
        window.location.href = document.referrer;
    </script>";
    exit();
}

?>