<?php

include "../config.php";

$langcod = $_SESSION['lang'] ?? 'ar';

$id = $_GET['id'];

mysqli_query($conn,
"UPDATE gaza_requests
SET status='مرفوض'
WHERE id=$id");

echo "

<script>

let lang = '$langcod';

let msg = (lang == 'ar')
? '❌ تم رفض الطلب'
: '❌ Request rejected';

alert(msg);

window.history.back();

</script>

";

?>