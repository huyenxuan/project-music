<?php
session_start();
if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}
if (isset($_SESSION['fullName'])) {
    unset($_SESSION['fullName']);
}
if (isset($_SESSION['userimage'])) {
    unset($_SESSION['userimage']);
}
header('Location: login.php');
