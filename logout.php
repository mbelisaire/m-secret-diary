<?php

session_start();
unset($_SESSION['email']);
setcookie("customerEmail", "", time() - 60 * 60);
$_COOKIE['customerEmail'] = "";
header("Location: index.php");

 ?>
