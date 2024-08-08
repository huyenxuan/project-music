<?php
ob_start();
include('../class/songClass.php');
$song = new Song();

$data = $song->show_song();
$show_song = $data['result'];
$totalpage = $data['totalpage'];
$page = $data['page'];

include("include/header.php");
include("include/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài hát</title>
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
    </style>
</head>

<body>
    <!-- main-content -->
    <div class="main-content">
        <div class="search">
            <div class="search-ctn">
                <input type="text" id="searchSong" placeholder="Nhập tên bài hát">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title">Danh sách bài hát</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên bài hát</th>
                    <th>Tên tác giả</th>
                    <th>Âm thanh</th>
                    <th>Ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="songTableBody">
                <?php
                if ($show_song) {
                    $i = 0;
                    while ($result = $show_song->fetch_assoc()) {
                        $i++;
                        $song_id = $result['song_id'];
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['song_name'] ?></td>
                            <td><?php echo $result['fullName'] ?></td>
                            <td class="audio">
                                <audio controls>
                                    <source src="upload/song/<?php echo $result['file_path'] ?>">
                                </audio>
                            </td>
                            <td class="image">
                                <img src="upload/images/imagesong/<?php echo $result['song_image'] ?>" alt="">
                            </td>
                            <td class="action">
                                <a href="songEdit.php?slugSong=<?php echo $result['slug_song'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa bài hát này?')" href="songDel.php?slugSong=<?php echo $result['slug_song'] ?>">Xóa</a>
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
                echo '<div class="prev"><a href="songShow.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="songShow.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="songShow.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>

    </div>
    <script>
        document.getElementById('searchSong').addEventListener('input', function() {
            let query = this.value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'songSearch.php?query=' + query, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('songTableBody').innerHTML = xhr.responseText;
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