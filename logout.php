<?php
session_start();
if (!empty($_SESSION)) {
    session_unset();
    session_destroy();
}
header('Location: index.php');
