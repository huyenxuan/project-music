<?php
include("./class/frontendClass.php");
include("./config/format.php");

$frontend = new FrontEnd();
$format = new Format();

$songs = [];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];
    $result = $frontend->show_song_same_category($song_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isFavorite = $frontend->check_song_in_favorite($user_id, $row['song_id']);
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path'],
                'is_favorited' => $isFavorite
            ];
        }
    }
}
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $result = $frontend->show_song_of_user($user_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isFavorite = $frontend->check_song_in_favorite($user_id, $row['song_id']);
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path'],
                'is_favorited' => $isFavorite
            ];
        }
    }
}

if (isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
    $result = $frontend->show_song_in_album($album_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isFavorite = $frontend->check_song_in_favorite($user_id, $row['song_id']);
            $favorite = $isFavorite ? true : false;
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path'],
                'is_favorited' => $favorite
            ];
        }
    }
}

if (isset($_GET['playlist_id'])) {
    $playlist_id = $_GET['playlist_id'];
    $result = $frontend->show_song_in_playlist($playlist_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $isFavorite = $frontend->check_song_in_favorite($user_id, $row['song_id']);
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path'],
                'is_favorited' => $isFavorite
            ];
        }
    }
}

// Trả về phản hồi JSON
header('Content-Type: application/json');
echo json_encode($songs);
?>