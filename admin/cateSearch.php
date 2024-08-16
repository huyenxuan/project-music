<?php
include("../class/cateClass.php");
$category = new Category();
$query = $_GET['query'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;

$search_category = $category->search_category($query, $page, $limit);

if ($search_category['result']) {
    $i = ($page - 1) * $limit;
    while ($row = $search_category['result']->fetch_assoc()) {
        $i++;
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['category_name'] . "</td>";
        echo "<td>
                <a href='cateEdit.php?slug=" . $row['slug'] . "'>Sửa</a>
                <span> | </span>
                <a onclick=\"return confirm('Bạn muốn xóa tên thể loại này?')\" href='cateDel.php?slug=" . $row['slug'] . "'>Xóa</a>
              </td>";
        echo "</tr>";
    }

    // Display pagination
    if ($search_category['totalpage'] > 1) {
        echo '<div class="pages">';
        if ($page > 1) {
            echo '<div class="prev"><a href="#" onclick="searchCategory(' . ($page - 1) . ')"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }
        for ($i = 1; $i <= $search_category['totalpage']; $i++) {
            echo '<div class="number ' . ($page == $i ? 'active' : '') . '">';
            echo '<a href="#" onclick="searchCategory(' . $i . ')">' . $i . '</a>';
            echo '</div>';
        }
        if ($page < $search_category['totalpage']) {
            echo '<div class="next"><a href="#" onclick="searchCategory(' . ($page + 1) . ')"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }
        echo '</div>';
    }
} else {
    echo "<tr><td colspan='3'>Không tìm thấy kết quả</td></tr>";
}
