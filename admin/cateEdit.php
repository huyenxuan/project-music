<?php
ob_start();
include("include/sidebar.php");
include("include/header.php");
include("../class/cateClass.php");
$category = new Category();

$category_id = $_GET['category_id'];
$get_category = $category->get_category_by_id($category_id);
if ($get_category) {
    $result = $get_category->fetch_assoc();
} else {
    echo 'Không tồn tại thể loại nhạc này';
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $update_category = $category->update_category($category_name, $category_id);

    $adminId = $user_id;
    $action = "Thêm thể loại";
    $details = "Thêm thể loại '$category_name'";
    $category->logAdminAction($adminId, $action, $details);

    header('location: cateShow.php');
    exit();
}
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
            <input type="text" placeholder="Nhập tên thể loại nhạc" name="category_name"
                value="<?php echo $result['category_name'] ?>"><br>
            <button>Cập nhật</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>