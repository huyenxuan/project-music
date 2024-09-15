<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class LoginAdmin
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function login($email, $password)
    {
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        $query = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['role'] === 'admin') {
                $_SESSION['email'] = $email;
                $_SESSION["fullName"] = $row["fullName"];
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["userimage"] = $row["userimage"];
                $_SESSION["role"] = $row["role"];
                header('Location: index.php');
                exit();
            } else {
                echo '<h2 style="color:red">Bạn không có quyền truy cập</h2>';
            }
        }
    }
}
