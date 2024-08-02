<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: login.php');
}
?>
<?php
include("include/header.php");
?>

<!-- footer -->
<footer>
    <div class="ft-ctn">
        Bản quyền thuộc về HHMusic

    </div>
</footer>

<!-- javascript -->
<script src="./js/main.js"></script>
</body>

</html>