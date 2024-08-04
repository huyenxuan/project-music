<?php
ob_start();
include('../class/userClass.php');
$user = new user();

include("include/header.php");
include("include/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
    <link rel="stylesheet" href="./css/user.css">
    <style>
        tr td:nth-child(5),
        tr td:nth-child(6) {
            width: 110px;
        }

        tbody tr .image {
            width: 100px;
            height: 70px;
        }
    </style>
</head>

<body>
    <!-- main-content -->
    <div class="main-content">
        <div class="search">
            <div class="search-ctn">
                <input type="text" id="searchUser" placeholder="Nhập tên người dùng">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title">Danh sách người dùng</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Số người theo dõi</th>
                    <th>Số người đang theo dõi</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php
                $show_user = $user->show_user();
                if ($show_user) {
                    $i = 0;
                    while ($result = $show_user->fetch_assoc()) {
                        $i++;
                        $user_id = $result['user_id'];
                        $count_follow_user = $user->count_follow_user($user_id);
                        $count_user_follow = $user->count_user_follow($user_id);
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['username'] ?></td>
                            <td><?php echo $result['email'] ?></td>
                            <td><?php echo $result['phoneNumber'] ?></td>
                            <td><?php echo $count_follow_user ?></td>
                            <td><?php echo $count_user_follow ?></td>
                            <td class="image">
                                <img src="../asset/img/logo.png" alt="">
                            </td>
                            <td class="action">
                                <a href="userEdit.php?user_id=<?php echo $result['user_id'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa người dùng này?')" href="userDel.php?user_id=<?php echo $result['user_id'] ?>">Xóa</a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="pages">

        </div>
    </div>
    <script>
        document.getElementById('searchUser').addEventListener('input', function() {
            let query = this.value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'userSearch.php?query=' + query, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('userTableBody').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>

<?php
include("include/footer.php");
?>