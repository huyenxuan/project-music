<?php
include("./class/frontendClass.php");
include("./config/format.php");

$frontend = new FrontEnd();
$format = new Format();

$songs = [];
if (isset($_GET['song_id'])) {
    $song_id = $_GET['song_id'];
    $result = $frontend->show_song_same_category($song_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path']
            ];
        }
    }
}
if (isset($_GET['album_id'])) {
    $album_id = $_GET['album_id'];
    $result = $frontend->show_song_in_album($album_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path']
            ];
        }
    }
}
if (isset($_GET['playlist_id'])) {
    $playlist_id = $_GET['playlist_id'];
    $result = $frontend->show_song_in_playlist($playlist_id);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $songs[] = [
                'song_id' => $row['song_id'],
                'song_name' => $format->textShorten($row['song_name'], 25),
                'author_name' => $row['authorSong'],
                'song_image' => $row['song_image'],
                'filePath' => $row['file_path']
            ];
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($songs);
?>