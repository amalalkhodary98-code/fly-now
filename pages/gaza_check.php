<?php
session_start();
include "../config.php";
include "../lang.php";

if(isset($_SESSION['user_id'])){

    header("Location: gaza_help.php?lang=".$langcod);

} else {

    header("Location: login.php?gaza=1&lang=".$langcod);

}

exit();
?>