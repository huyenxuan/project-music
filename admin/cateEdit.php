<?php
ob_start();
include("../class/cateClass.php");
$category = new Category();

$category_slug = $_GET['slug'];
$get_category = $category->get_category_by_slug($category_slug);
if ($get_category) {
    $result = $get_category->fetch_assoc();
} else {
    echo 'Không tồn tại thể loại nhạc này';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $update_category = $category->update_category($category_name, $result['category_id']);
    header('location: cateShow.php');
    exit();
}
?>

<?php
include("include/sidebar.php");
include("include/header.php");
?>
<title>Thêm thể loại</title>
<link rel="stylesheet" href="./css/category.css">

<style>
    .main-content {
        margin: 15px;
    }
</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Sửa tên thể loại</h2>
        <form action="" method="POST">
            <input type="text" placeholder="Nhập tển thể loại nhạc" name="category_name" value="<?php echo $result['category_name'] ?>"><br>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>