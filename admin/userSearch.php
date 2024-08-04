<?php
include("../class/userClass.php");
$user = new user();
$query = $_GET['query'];
$search_user = $user->search_user($query);

if ($search_user) {
    $i = 0;
    while ($row = $search_user->fetch_assoc()) {
        $i++;
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phoneNumber'] . "</td>";
        echo "<td><img src='../asset/img/logo.png' alt=''></td>";
        echo "<td>
                <a href='userEdit.php?user_id=" . $row['user_id'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa người dùng này?')\" href='userDel.php?user_id=" . $row['user_id'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>Không tìm thấy kết quả</td></tr>";
}
