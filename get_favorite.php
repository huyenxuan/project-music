<?php
session_start();
include("./class/frontendClass.php");
include("./config/format.php");

$frontend = new FrontEnd();
$format = new Format();

$songs = [];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id) {
    $show_favorite = $frontend->show_favorite($user_id);
    if ($show_favorite && $show_favorite->num_rows > 0) {
        while ($row = $show_favorite->fetch_assoc()) {
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path'],
            ];
        }
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}
header('Content-Type: application/json');
echo json_encode($songs);
?>