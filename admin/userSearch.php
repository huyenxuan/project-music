<?php
include("../class/userClass.php");
$user = new User();
$query = $_GET['query'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 6;

$search_user = $user->search_user($query, $page, $limit);

if ($search_user['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_user['result']->fetch_assoc()) {
        $i++;
        $user_id = $row['user_id'];
        $count_follow_user = $user->count_follow_user($user_id);
        $count_user_follow = $user->count_user_follow($user_id);
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $count_follow_user . "</td>";
        echo "<td>" . $count_user_follow . "</td>";
        echo "<td><img src='upload/images/imageuser/" . $row['userimage'] . "'></td>";
        echo "<td>
                <a href='userEdit.php?slug=" . $row['slug'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa người dùng này?')\" href='userDel.php?slug=" . $row['slug'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }

    // Display pagination
    if ($search_user['totalpage'] > 1) {
        echo '<div class="pages">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchUser(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_user['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchUser(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_user['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchUser(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='7'>Không tìm thấy kết quả</td></tr>";
}
