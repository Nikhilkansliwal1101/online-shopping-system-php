<?php
session_start();
unset($_SESSION['adminid']);
unset($_SESSION['adminmail']);
header('Location: login.php');
?>