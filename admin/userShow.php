<?php
ob_start();
include('../class/userClass.php');
$user = new User();

$data = $user->show_user();
$show_user = $data['result'];
$totalpage = $data['totalpage'];
$page = $data['page'];

include("include/sidebar.php");
include("include/header.php");
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

        /* pages */
        .pages {
            display: flex;
            margin-top: 15px;
            justify-content: center;
        }

        .pages div {
            width: 30px;
            height: 30px;
            border: 1px solid green;
            color: black;
            align-content: center;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .active a {
            color: red;
        }

        .main-content {
            margin: 15px;
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
                    <th>Số người theo dõi</th>
                    <th>Số người đang theo dõi</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php
                // $show_user = $user->show_user();
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
                            <td><?php echo $result['fullName'] ?></td>
                            <td><?php echo $result['email'] ?></td>
                            <td style="width:110px;"><?php echo $count_follow_user ?></td>
                            <td><?php echo $count_user_follow ?></td>
                            <td class="image">
                                <?php
                                if (!empty($result['userimage'])) {
                                    echo '<img src="upload/images/imageuser/' . $result['userimage'] . '" alt="">';
                                } else {
                                    echo '<img src="../asset/img/user-default.png" alt="">';
                                }
                                ?>
                            </td>
                            <td class="action">
                                <a href="userEdit.php?user_id=<?php echo $result['user_id'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa người dùng này?')"
                                    href="userDel.php?user_id=<?php echo $result['user_id'] ?>">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="pages">
            <?php
            if ($page >= 3) {
                echo '<div class="prev"><a href="userShow.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="userShow.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="userShow.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>

    </div>
    <script>
        document.getElementById('searchUser').addEventListener('input', function () {
            searchUser(1);
        });

        function searchUser(page) {
            let query = document.getElementById('searchUser').value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'userSearch.php?query=' + query + '&page=' + page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('userTableBody').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</body>

</html>

<?php
include("include/footer.php");
?>