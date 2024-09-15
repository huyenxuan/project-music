<?php
session_start();
include('./class/frontendClass.php');
include('./config/format.php');
$frontend = new FrontEnd();
$format = new Format;

$user_id = $_GET['user_id'];
$get_user = $frontend->get_user($user_id);
if ($get_user) {
    $result = $get_user->fetch_assoc();
} else {
    echo 'Người dùng không tồn tại';
    exit();
}
$get_following = $frontend->get_following($user_id);
$get_follower = $frontend->get_follower($user_id);

$erroPass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if (!empty($_FILES['userimage']['name'])) {
        $old_image = $result['userimage'];
        $userimage = $_FILES['userimage']['name'];
        $uploadDir = "upload/images/imageuser/";
        $uploadFile = $uploadDir . basename($userimage);

        if (move_uploaded_file($_FILES['userimage']['tmp_name'], $uploadFile)) {
            echo 'Upload thành công';
            if (file_exists($uploadDir . $old_image)) {
                unlink($uploadDir . $old_image);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        $userimage = $result['userimage'];
    }

    // check pass
    if ($confirmpassword !== $password) {
        $erroPass = 'Xác nhận mật khẩu không chính xác';
        exit();
    } else {
        $frontend->update_user($fullName, $password, $userimage, $user_id);
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Cá Nhân</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/user.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="shortcut icon" href="./asset/img/logo.png">
</head>
<style>
    .follower-box-flex {
        padding: 0 20px;
        justify-content: unset;
    }
</style>

<body style="overflow: hidden;">
    <div class="mainBody">
        <div class="title"></div>
        <div class="mainbox profile">
            <div class="profile-background-container">
                <div class="profile-background">
                    <img src="./asset/img/profile_background.png" alt="">
                </div>
                <div class="profile-inform">
                    <div class="profile-name"><?php echo $result['fullName'] ?></div>
                    <p><?php $format->number($result['followers_count']) ?> người theo dõi</p>
                </div>
                <div class="backhome-btn">
                    <button onclick="backHome()"><i class="fa-solid fa-house"></i> Về trang chủ</button>
                </div>
            </div>
            <div class="profile-avatar">
                <?php
                if (!empty($result['userimage'])) {
                    echo '<img src="./admin/upload/images/imageuser/' . $result['userimage'] . '" alt="User Image">';
                } else {
                    echo '<img src="./asset/img/user-default.png" alt="User Image">';
                }
                ?>
            </div>
            <div class="profile-content">
                <div class="lib-side-bar" style="padding-top: 65px;">
                    <button class="lib-tab-btn active" onclick="libTab(event, 'lib-tab-1')">Đang Theo Dõi</button>
                    <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-2')">Được Theo Dõi</button>
                    <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-3')">Quản Lý Tài Khoản</button>
                    <!-- <button class="lib-tab-btn" onclick="libTab(event, 'lib-tab-4')">Quản lý Playlist</button> -->
                </div>
                <!-- đang theo dõi -->
                <div class="lib-tab-content" style="display: block;" id="lib-tab-1">
                    <div class="follower-box-flex">
                        <?php
                        if ($get_following) {
                            while ($resultFollowing = $get_following->fetch_assoc()) {
                                ?>
                                <a href="otheruser.php?user_id=<?php echo $resultFollowing['follower_id'] ?>"
                                    class="follower-container">
                                    <div class="follower-image">
                                        <?php
                                        if (!empty($resultFollowing['userimage'])) {
                                            echo '<img src="./admin/upload/images/imageuser/' . $resultFollowing['userimage'] . '"
                                            alt="User Image">';
                                        } else {
                                            echo '<img src="./asset/img/user-default.png" alt="User Image">';
                                        }
                                        ?>
                                    </div>
                                    <div class="follower-name-container">
                                        <div class="follower-name"><?php echo $resultFollowing['following_name'] ?></div>
                                        <div class="follower-id">ID: <?php echo $resultFollowing['following_id'] ?></div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- người theo dõi -->
                <div class="lib-tab-content" id="lib-tab-2">
                    <div class="follower-box-flex">
                        <?php
                        if ($get_follower) {
                            while ($resultFollower = $get_follower->fetch_assoc()) {
                                ?>
                                <a href="otheruser.php?user_id=<?php echo $resultFollower['follower_id'] ?>"
                                    class="follower-container">
                                    <div class="follower-image">
                                        <?php
                                        if (!empty($resultFollower['userimage'])) {
                                            echo '<img src="./admin/upload/images/imageuser/' . $resultFollower['userimage'] . '"
                                            alt="User Image">';
                                        } else {
                                            echo '<img src="./asset/img/user-default.png" alt="User Image">';
                                        }
                                        ?>
                                    </div>
                                    <div class="follower-name-container">
                                        <div class="follower-name"><?php echo $resultFollower['follower_name'] ?></div>
                                        <div class="follower-id">ID: <?php echo $resultFollower['follower_id'] ?></div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="lib-tab-content" id="lib-tab-3">
                    <div class="user-manage">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div>
                                <p>Đổi tên tài khoản</p>
                                <input required name="fullName" type="text" placeholder="Nhập tên tài khoản mới..."
                                    value="<?php echo $result['fullName'] ?>">
                            </div>
                            <div>
                                <p>Đổi mật khẩu</p>
                                <input required name="password" type="password" placeholder="Nhập mật khẩu mới...">
                            </div>
                            <div>
                                <p>Nhập lại mật khẩu</p>
                                <input required name="confirmpassword" type="password"
                                    placeholder="Nhập lại mật khẩu...">
                                <?php if ($erroPass !== "") {
                                    echo "<p style='color: red; font-size: 17px; margin-left: 10px'>" . $erroPass . "</p>";
                                } ?>
                            </div>
                            <div>
                                <p>Cập nhật ảnh đại diện</p>
                                <input name="userimage" type="file" accept=".jpg,.jpeg,.png">
                            </div>
                            <div class="submit-btn">
                                <button>Xác nhận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- custom right-click menu -->
        <div id="custom-menu" class="custom-menu">
            <ul>
                <li onclick="menuAction('Action 1')"><i class="fa-solid fa-arrow-left-long"></i>&nbsp;&nbsp; Quay lại
                </li>
                <li onclick="menuAction('Action 2')"><i class="fa-solid fa-arrow-right"></i>&nbsp;&nbsp; Tiếp theo</li>
                <li onclick="menuAction('Action 3')"><i class="fa-solid fa-rotate-right"></i>&nbsp;&nbsp; Tải lại trang
                </li>
                <li onclick="menuAction('Action 4')"><i class="fa-regular fa-circle-dot"></i>&nbsp;&nbsp; Khám phá</li>
                <li onclick="menuAction('Action 5')"><i class="fa-regular fa-circle-user"></i>&nbsp;&nbsp; Nhạc cá nhân
                </li>
            </ul>
        </div>

    </div>
    <script src="./js/tabcontent.js"></script>
</body>

</html>