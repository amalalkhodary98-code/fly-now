<?php

include "../config.php";

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM gaza_requests
WHERE id=$id");

echo "

<script>

let lang = \"<?= $langcod ?>\";

let message = '';

if(lang == 'ar'){
    message = '🗑 تم حذف الطلب';
}else{
    message = '🗑 Request deleted successfully';
}

alert(message);

window.history.back();

</script>

";

?>