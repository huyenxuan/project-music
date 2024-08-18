<?php
ob_start();
include('../class/playlistClass.php');
$playlist = new PlayList();

$data = $playlist->show_playlist();
$show_playlist = $data['result'];
$totalpage = $data['totalpage'];
$page = $data['page'];

include("include/sidebar.php");
include("include/header.php");
?>

<head>
    <title>Danh sách người dùng</title>
    <link rel="stylesheet" href="./css/category.css">
    <style>
        .main-content {
            margin: 15px;
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
                <input type="text" id="searchPlaylist" placeholder="Nhập tên playlist">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title" style="color:black">Danh sách playlist</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên playlist</th>
                    <th>Tác giả</th>
                    <th>Số lượng bài hát</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="playlistTableBody">
                <?php
                if ($show_playlist) {
                    $i = 0;
                    while ($result = $show_playlist->fetch_assoc()) {
                        $i++;
                        $playlist_id = $result['playlist_id'];
                        $count_song_playlist = $playlist->count_song_playlist($playlist_id);
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['playlist_name'] ?></td>
                            <td><?php echo $result['fullName'] ?></td>
                            <td><?php echo $count_song_playlist ?></td>
                            <td class="action">
                                <a href="playlistEdit.php?playlist_id=<?php echo $result['playlist_id'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa playlist này?')"
                                    href="playlistDel.php?playlist_id=<?php echo $result['playlist_id'] ?>">Xóa</a>
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
                echo '<div class="prev"><a href="playlistShow.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="playlistShow.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="playlistShow.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>

    </div>
    <script>
        document.getElementById('searchPlaylist').addEventListener('input', function () {
            searchPlaylist(1);
        });

        function searchPlaylist(page) {
            let query = document.getElementById('searchPlaylist').value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'playlistSearch.php?query=' + query + '&page=' + page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('playlistTableBody').innerHTML = xhr.responseText;
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