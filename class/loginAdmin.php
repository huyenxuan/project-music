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
        // Escape inputs to prevent SQL injection
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        // Prepare the query
        $query = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";
        $result = $this->db->select($query);

        if ($result != false) {
            $row = $result->fetch_assoc();
            if ($row['role'] === 'admin') {
                $_SESSION['email'] = $email;
                $_SESSION["fullName"] = $row["fullName"];
                $_SESSION["user_id"] = $row['user_id'];
                $_SESSION["userimage"] = $row['userimage'];
                header('Location: index.php');
                exit();
            } else {
                echo '<h1 style="color:red; text-align: center">Bạn không có quyền truy cập!</h1>';
            }
        } else {
            $alert = "Tài khoản hoặc mật khẩu không chính xác";
            return $alert;
        }
    }
}
