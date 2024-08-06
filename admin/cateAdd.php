<?php
ob_start();
include("../class/cateClass.php");
$category = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    $insert_category = $category->insert_category($category_name);
    header('location: cateAdd.php?categoryName=' . urldecode($category_name));
    exit();
}
?>

<?php
include("include/header.php");
include("include/sidebar.php");
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thêm thể loại</title>
<link rel="stylesheet" href="./css/category.css">

<style>

</style>

<body>
    <div class="main-content">
        <h2 class="title" style="color:black">Thêm thể loại</h2>
        <form action="" method="POST">
            <input type="text" placeholder="Nhập thể loại nhạc" name="category_name"><br>
            <button>Thêm</button>
        </form>
    </div>
    <?php
    include("include/footer.php");
    ?>