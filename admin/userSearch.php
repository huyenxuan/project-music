<?php
include("../class/userClass.php");
$user = new User();
$query = $_GET['query'];
$search_user = $user->search_user($query);

if ($search_user) {
    $i = 0;
    while ($row = $search_user->fetch_assoc()) {
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
        echo "<td><img src='upload/images/imageuser/" . $row['userimage'] . "'</td>";
        echo "<td>
                <a href='userEdit.php?slug=" . $row['slug'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa người dùng này?')\" href='userDel.php?slug=" . $row['slug'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Không tìm thấy kết quả</td></tr>";
}
