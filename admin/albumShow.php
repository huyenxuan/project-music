<?php
ob_start();
include('../class/albumClass.php');
$album = new Album();

$data = $album->show_album();
$show_album = $data['result'];
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
    <title>Danh sách album</title>
    <link rel="stylesheet" href="./css/album.css">
    <style>
        table img {
            padding: 0 !important;
        }

        tbody tr .image {
            border-radius: nones;
            width: 150px;
            height: 120px;
        }

        tbody tr .image img {
            width: 100px;
            margin: 0;
            object-fit: cover;
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
                <input type="text" id="searchAlbum" placeholder="Nhập tên album">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title">Danh sách album</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên album</th>
                    <th>Tác giả</th>
                    <th>Số lượng bài hát</th>
                    <th>Ảnh Album</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="albumTableBody">
                <?php
                if ($show_album) {
                    $i = 0;
                    while ($result = $show_album->fetch_assoc()) {
                        $i++;
                        $album_id = $result['album_id'];
                        $count_song_album = $album->count_song_album($album_id);
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['album_name'] ?></td>
                            <td><?php echo $result['fullName'] ?></td>
                            <td><?php echo $count_song_album ?></td>
                            <td class="image">
                                <img src="upload/images/imagesong/<?php echo $result['album_image'] ?>" alt="">
                            </td>
                            <td class="action">
                                <a href="albumEdit.php?album_slug=<?php echo $result['album_slug'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa album này?')"
                                    href="albumDel.php?album_slug=<?php echo $result['album_slug'] ?>">Xóa</a>
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
                echo '<div class="prev"><a href="albumShow.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="albumShow.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="albumShow.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>

    </div>
    <script>
        document.getElementById('searchAlbum').addEventListener('input', function () {
            searchAlbum(1);
        });

        function searchAlbum(page) {
            let query = document.getElementById('searchAlbum').value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'albumSearch.php?query=' + query + '&page=' + page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('albumTableBody').innerHTML = xhr.responseText;
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