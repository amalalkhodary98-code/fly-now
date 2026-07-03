<?php
session_start();
include "../lang.php";

session_destroy();

header("Location: ../index.php?lang=".$langcod);
exit();
?>