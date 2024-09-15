<?php
session_start();
include './class/frontendClass.php';
$frontend = new FrontEnd();

header('Content-Type: application/json');  // Ensure the content type is JSON

if (isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $is_favorite = $frontend->check_song_in_favorite($user_id, $song_id);

        if ($is_favorite) {
            $frontend->remove_from_favorite($user_id, $song_id);
            echo json_encode(value: ['status' => 'deleted']);
        } else {
            $frontend->add_to_favorite($user_id, $song_id);
            echo json_encode(['status' => 'added']);
        }
    } else {
        echo json_encode(['status' => 'not_logged_in']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No song ID provided']);
}
?>