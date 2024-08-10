<?php
include("../class/playlistClass.php");
$playlist = new PlayList();
$query = $_GET['query'];
$search_playlist = $playlist->search_playlist($query);

if ($search_playlist) {
    $i = 0;
    while ($row = $search_playlist->fetch_assoc()) {
        $i++;
        $playlist_id = $row['playlist_id'];
        $count_song_playlist = $playlist->count_song_playlist($playlist_id);
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['playlist_name'] . "</td>";
        echo "<td>" . $count_song_playlist . "</td>";
        echo "<td>
                <a href='playlistEdit.php?slugPlaylist=" . $row['slug_playlist'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa playlist này?')\" href='playlistDel.php?slugPlaylist=" . $row['slug_playlist'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Không tìm thấy kết quả</td></tr>";
}
