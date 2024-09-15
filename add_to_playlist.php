<?php
session_start();
include('./class/playlistClass.php'); // Kết nối cơ sở dữ liệu
$playlist = new PlayList();

if (isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];

    // Kiểm tra nếu người dùng đã đăng nhập
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        if ($playlist->check_song_in_playlist($playlist_id, $song_id)) {
            echo "exists";
        } else {
            if ($playlist->add_song_to_playlist($playlist_id, $song_id)) {
                echo "success";
            } else {
                echo "Error: ";
            }
        }
    } else {
        echo "Bạn cần đăng nhập!";
    }
}
?>