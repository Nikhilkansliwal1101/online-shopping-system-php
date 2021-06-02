<?php
session_start();
unset($_SESSION['custid']);
unset($_SESSION['custmail']);
header('Location: index.php');