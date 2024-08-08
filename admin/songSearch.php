<?php
include("../class/songClass.php");
$song = new Song();
$query = $_GET['query'];
$search_song = $song->search_song($query);

if ($search_song) {
    $i = 0;
    while ($row = $search_song->fetch_assoc()) {
        $i++;
        $song_id = $row['song_id'];
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['song_name'] . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td><audio controls>
                    <source src='upload/song/" . $row['file_path'] . "'>
                   </audio></td>";
        echo "<td><img src='upload/images/imagesong/" . $row['song_image'] . "'</td>";
        echo "<td>
                <a href='songEdit.php?slugSong=" . $row['slug_song'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa bài hát này?')\" href='songDel.php?slugSong=" . $row['slug_song'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Không tìm thấy kết quả</td></tr>";
}
