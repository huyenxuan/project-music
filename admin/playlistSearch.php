<?php
include("../class/playlistClass.php");
$playlist = new PlayList();
$query = $_GET['query'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 20;

$search_playlist = $playlist->search_playlist($query, $page, $limit);

if ($search_playlist['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_playlist['result']->fetch_assoc()) {
        $i++;
        $playlist_id = $row['playlist_id'];
        $count_song_playlist = $playlist->count_song_playlist($playlist_id);
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['playlist_name'] . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td>" . $count_song_playlist . "</td>";
        echo "<td>
                <a href='playlistEdit.php?playlist_id=" . $row['playlist_id'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa playlist này?')\" href='playlistDel.php?playlist_id=" . $row['playlist_id'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }

    // Display pagination
    if ($search_playlist['totalpage'] > 1) {
        echo '<div class="pages">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchPlaylist(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_playlist['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchPlaylist(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_playlist['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchPlaylist(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='4'>Không tìm thấy kết quả</td></tr>";
}
