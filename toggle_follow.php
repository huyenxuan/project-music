<?php
session_start();
include('./class/frontendClass.php');
$frontend = new FrontEnd();

if (isset($_POST['user_id']) && isset($_SESSION['user_id'])) {
    $following_id = $_SESSION['user_id'];
    $followed_id = $_POST['user_id'];

    $check_follow = $frontend->check_follow($followed_id, $following_id);

    if ($check_follow) {
        if ($frontend->delete_follow($followed_id, $following_id)) {
            echo 'unfollowed';
        } else {
            echo 'error';
        }
    } else {
        if ($frontend->insert_follow($followed_id, $following_id)) {
            echo 'followed';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'error';
}
?>