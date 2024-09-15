<?php
session_start();
include('./class/frontendClass.php');
$frontend = new FrontEnd();

if (isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        if ($frontend->check_song_in_favorite($user_id, $song_id)) {
            if ($frontend->remove_from_favorite($user_id, $song_id)) {
                echo 'removed';
            } else {
                echo 'error';
            }
        } else {
            if ($frontend->add_to_favorite($user_id, $song_id)) {
                echo 'added';
            } else {
                echo 'error';
            }
        }
    } else {
        echo 'Bạn cần đăng nhập để thực hiện thao tác này!';
    }
}
