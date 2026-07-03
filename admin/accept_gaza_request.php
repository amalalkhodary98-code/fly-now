<?php
include "../config.php";

$id = intval($_GET['id']);

mysqli_query($conn,
"UPDATE gaza_requests SET request_status='approved' WHERE id=$id");
?>

<script>

let lang = "<?= $langcod ?>";

let message = "";

if(lang == "ar"){
    message = "تم قبول الطلب";
}
else{
    message = "Your request has been approved successfully";
}

alert(message);

window.history.back();

</script>