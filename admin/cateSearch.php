<?php
include("../class/cateClass.php");
$category = new Category();
$query = $_GET['query'];
$search_category = $category->search_category($query);

if ($search_category) {
    $i = 0;
    while ($row = $search_category->fetch_assoc()) {
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
} else {
    echo "<tr><td colspan='3'>Không tìm thấy kết quả</td></tr>";
}
