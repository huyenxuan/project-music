<?php
ob_start();
include('../class/activitiesClass.php');
$activities = new Activities();

$data = $activities->showActivities();
$show_activities = $data['result'];
$totalpage = $data['totalpage'];
$page = $data['page'];

include("include/sidebar.php");
include("include/header.php");
?>

<head>
    <title>Danh sách Hoạt động admin</title>
    <link rel="stylesheet" href="./css/category.css">
    <style>
        tbody tr {
            height: 25px;
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
                <input type="text" id="searchLogs" placeholder="Tìm kiếm ...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
        <h2 class="title" style="color:black">Danh sách Hoạt động admin</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Admin</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>Thời gian</th>
                </tr>
            </thead>
            <tbody id="adminLogsTableBody">
                <?php
                if ($show_activities) {
                    $i = 0;
                    while ($result = $show_activities->fetch_assoc()) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['fullName'] ?></td>
                            <td><?php echo $result['actions'] ?></td>
                            <td><?php echo $result['details'] ?></td>
                            <td><?php echo $result['created_at'] ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>Không có hoạt động gần đây</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="pages">
            <?php
            if ($page >= 3) {
                echo '<div class="prev"><a href="activities.php?page=' . ($page - 1) . '"><i class="fa-solid fa-chevron-left"></i></a></div>';
                echo '<div class="etc">...</div>';
            }

            for ($i = max(1, $page - 1); $i <= min($totalpage, $page + 1); $i++) {
                echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
                echo '<a href="activities.php?page=' . $i . '">' . $i . '</a>';
                echo '</div>';
            }

            if ($page <= $totalpage - 2) {
                echo '<div class="etc">...</div>';
                echo '<div class="next"><a href="activities.php?page=' . ($page + 1) . '"><i class="fa-solid fa-chevron-right"></i></a></div>';
            }
            ?>
        </div>


    </div>
    <script>
        document.getElementById('searchLogs').addEventListener('input', function () {
            searchLogs(1);
        });

        function searchLogs(page) {
            let query = document.getElementById('searchLogs').value;
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'adminLogsSearch.php?query=' + query + '&page=' + page, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('adminLogsTableBody').innerHTML = xhr.responseText;
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