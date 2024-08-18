<?php
include("../class/albumClass.php");
$album = new Album();
$query = $_GET['query'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 6;

$search_album = $album->search_album($query, $page, $limit);

if ($search_album['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_album['result']->fetch_assoc()) {
        $i++;
        $album_id = $row['album_id'];
        $count_song_album = $album->count_song_album($album_id);
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['album_name'] . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td>" . $count_song_album . "</td>";
        echo "<td><img src='upload/images/imagesong/" . $row['album_image'] . "'></td>";
        echo "<td>
                <a href='albumEdit.php?album_id=" . $row['album_id'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa album này?')\" href='albumDel.php?album_id=" . $row['album_id'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }

    // Display pagination
    if ($search_album['totalpage'] > 1) {
        echo '<div class="pages">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchAlbum(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_album['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchAlbum(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_album['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchAlbum(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='6'>Không tìm thấy kết quả</td></tr>";
}
