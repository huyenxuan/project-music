<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/bannerClass.php");
$banner = new Banner();
$show_banner = $banner->show_banner();
?>

<head>
    <title>Danh sách Banner</title>
    <link rel="stylesheet" href="./css/category.css">
    <style>
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

        table img {
            border-radius: unset;
        }
    </style>
</head>

<body>
    <!-- main-content -->
    <div class="main-content">
        <h2 class="title" style="color:black">Danh sách banner</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên banner</th>
                    <th>Ảnh banner</th>
                    <th>Đường dẫn</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="">
                <?php
                if ($show_banner) {
                    $i = 0;
                    while ($result = $show_banner->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['banner_name'] ?></td>
                            <td>
                                <img src="upload/banner/<?php echo $result['banner_image'] ?>" alt="">
                            </td>
                            <td><a href="<?php echo $result['pathway'] ?>" target='_bank'>Tại đây</a></td>
                            <td class="action">
                                <a href="bannerEdit.php?banner_id=<?php echo $result['banner_id'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa banner này?')"
                                    href="bannerDel.php?banner_id=<?php echo $result['banner_id'] ?>">Xóa</a>
                            </td>

                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
include("include/footer.php");
?>