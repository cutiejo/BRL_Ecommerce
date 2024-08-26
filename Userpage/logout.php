<?php
session_start();
session_unset();
session_destroy();
header("Location: ../Userpage/index.php");
exit();
?>
