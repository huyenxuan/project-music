<?php
ob_start();
include('../class/cateClass.php');
$category = new Category();

$data = $category->show_category();
$show_category = $data['result'];
$totalpage = $data['totalpage'];
$page = $data['page'];

include("include/sidebar.php");
include("include/header.php");
?>

<head>
    <title>Danh sách Thể loại</title>
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
    </style>
</head>

<body>
    <!-- main-content -->
    <div class="main-content">
        <div class="search">
            <div class="search-ctn">
                <input type="text" id="searchcategory" placeholder="Nhập tên thể loại">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title" style="color:black">Danh sách thể loại</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thể loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                <?php
                if ($show_category) {
                    $i = 0;
                    while ($result = $show_category->fetch_assoc()) {
                        $i++;
                ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['category_name'] ?></td>
                            <td class="action">
                                <a href="cateEdit.php?slug=<?php echo $result['slug'] ?>">Sửa</a>
                                <span> | </span>
                                <a onclick="return confirm('Bạn muốn xóa tên thể loại này?')" href="cateDel.php?slug=<?php echo $result['slug'] ?>">Xóa</a>
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
                echo '<div class="prev"><a href="cateShow.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="cateShow.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="cateShow.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>

    </div>
    <script>
        document.getElementById('searchcategory').addEventListener('input', function() {
            let query = this.value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'cateSearch.php?query=' + query, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('categoryTableBody').innerHTML = xhr.responseText;
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