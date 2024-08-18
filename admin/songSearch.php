<?php
include("../class/songClass.php");

$song = new Song();
$query = $_GET['query'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 6;

$search_song = $song->search_song($query, $page, $limit);

if ($search_song['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_song['result']->fetch_assoc()) {
        $i++;
        $song_id = $row['song_id'];
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['song_name'] . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td><audio controls>
                    <source src='upload/song/" . $row['file_path'] . "'>
                   </audio></td>";
        echo "<td><img src='upload/images/imagesong/" . $row['song_image'] . "'></td>";
        echo "<td>
                <a href='songEdit.php?song_id=" . $row['song_id'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa bài hát này?')\" href='songDel.php?song_id=" . $row['song_id'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }

    if ($search_song['totalpage'] > 1) {
        echo '<div class="pages">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchSong(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_song['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchSong(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_song['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchSong(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='6'>Không tìm thấy kết quả</td></tr>";
}
