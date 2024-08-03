<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class user
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    // func check email, sđt
    public function check_user($email, $phoneNumber)
    {
        $query = "SELECT * FROM tbl_user
                WHERE email = '$email' 
                OR phoneNumber = '$phoneNumber'";
        $result = $this->db->select($query);
        if ($result)
            return true;
        else
            return false;
    }
    // func login
    public function login($email, $password)
    {
        // Escape inputs to prevent SQL injection
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        $query = "SELECT * FROM tbl_user 
                WHERE email = '$email' 
                AND password = '$password'";
        $result = $this->db->select($query);

        if ($result != false) {
            $row = $result->fetch_assoc();
            if ($row['role'] == 'admin') {
                $_SESSION['email'] = $email;
                header('Location: index.php');
                exit();
            } else {
                echo '<h1 style="color:red; text-align: center">Bạn không có quyền truy cập!</h1>';
            }
        } else {
            echo '<h1 style="color:red; text-align: center">Tài khoản hoặc mật khẩu không chính xác</h1>';
        }
    }
    // func show user
    public function show_user()
    {
        $query = "SELECT * FROM tbl_user";
        $result = $this->db->select($query);
        return $result;
    }
    // func insert
    public function insert_user($fullName, $email, $phoneNumber, $password, $description, $role)
    {
        $query = "INSERT INTO tbl_user (
            username,
            email,
            phoneNumber,
            password,
            description,
            role) 
        VALUES (
            '$fullName',
            '$email',
            '$phoneNumber',
            '$password',
            '$description',
            '$role')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func register
    public function register($fullName, $email, $phoneNumber, $password)
    {
        if (!$this->check_user($email, $phoneNumber)) {
            $query = "INSERT INTO tbl_user (
                    username,
                    email,
                    phoneNumber,
                    password) 
                VALUES (
                    '$fullName',
                    '$email',
                    '$phoneNumber',
                    '$password')";
            $result = $this->db->insert($query);

            $_SESSION['email'] = $email;
            $_SESSION['fullName'] = $fullName;

            header('Location: index.php');
            return $result;
        } else {
            echo '<h1 style="color:red; text-align: center">Email hoặc Số điện thoại đã tồn tại!</h1>';
        }
    }

    // func update
    public function update_user($fullName, $email, $phoneNumber, $password, $role, $user_id)
    {
        $query = "UPDATE tbl_user
                SET fullName = '$fullName', 
                    email = '$email', 
                    phoneNumber = '$phoneNumber',
                    password = '$password', 
                    role = '$role',
                WHERE user_id = '$user_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // func delete
    public function delete_user($user_id)
    {
        $query = "DELETE FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->delete($query);
        header('location: userShow.php');
        return $result;
    }
}
?>