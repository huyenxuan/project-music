<?php
include("../class/activitiesClass.php");
$activities = new Activities();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 20; // Set the limit per page

$search_admin_logs = $activities->search_admin_logs($query, $page, $limit);

if ($search_admin_logs['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_admin_logs['result']->fetch_assoc()) {
        $i++;
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['fullName'] . "</td>";
        echo "<td>" . $row['actions'] . "</td>";
        echo "<td>" . $row['details'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }

    // Display pagination
    if ($search_admin_logs['totalpage'] > 1) {
        echo '<div class="pages page2">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchLogs(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_admin_logs['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchLogs(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_admin_logs['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchLogs(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='5'>Không tìm thấy kết quả</td></tr>";
}
