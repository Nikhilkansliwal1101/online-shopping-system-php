<?php
session_start();
unset($_SESSION['supplierid']);
unset($_SESSION['suppliermail']);
header('Location: login.php');
?>