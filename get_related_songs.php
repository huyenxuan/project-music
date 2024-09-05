<?php
include("./class/frontendClass.php");
$frontend = new FrontEnd();

$song_id = $_GET['song_id'];
$related_songs = $frontend->show_song_same_category($song_id);

$songs = [];

while ($row = $related_songs->fetch_assoc()) {
    $songs[] = [
        'song_id' => $row['song_id'],
        'song_name' => $row['song_name'],
        'author_name' => $row['authorSong'],
        'song_image' => $row['song_image'],
        'filePath' => $row['file_path']
    ];
}

header('Content-Type: application/json');
echo json_encode($songs);
?>