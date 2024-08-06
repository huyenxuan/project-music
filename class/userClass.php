<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class User
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
        $limit = 6;

        $queryALl = 'SELECT * FROM tbl_user';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = ($page - 1) * $limit;
        $query = "SELECT * FROM tbl_user 
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // func insert
    public function insert_user($fullName, $email, $password, $description, $role, $userimage)
    {
        $query = "INSERT INTO tbl_user (
            fullName,
            email,
            password,
            description,
            userimage,
            role) 
        VALUES (
            '$fullName',
            '$email',
            '$password',
            '$description',
            '$userimage',
            '$role')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func register
    public function register($fullName, $email, $phoneNumber, $password)
    {
        if (!$this->check_user($email, $phoneNumber)) {
            $query = "INSERT INTO tbl_user (
                    fullName,
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
            echo '<h2>Email hoặc Số điện thoại đã tồn tại!</h2>';
        }
    }

    // func update
    public function update_user($fullName, $email, $password, $description, $role, $userimage, $user_id)
    {
        $query = "UPDATE tbl_user
                SET fullName = '$fullName', 
                    email = '$email', 
                    password = '$password', 
                    description = '$description',
                    role = '$role',
                    userimage = '$userimage'
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
    // func search
    public function search_user($fullName)
    {
        $query = "SELECT * FROM tbl_user 
                WHERE fullName LIKE '%$fullName%'
                OR role LIKE '%$fullName%'";
        $result = $this->db->select($query);
        return $result;
    }
    // func đếm số người theo dõi người dùng
    public function count_follow_user($user_id)
    {
        $query = "SELECT COUNT(fl.follower_id) AS followers_count
                FROM tbl_user us
                LEFT JOIN tbl_follow fl ON us.user_id = fl.following_id
                WHERE us.user_id = '$user_id'";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['followers_count'];
        } else {
            return 0;
        }
    }
    // func đếm số người người dùng theo dõi
    public function count_user_follow($user_id)
    {
        $query = "SELECT COUNT(fl.following_id) AS following_count
                FROM tbl_user us
                LEFT JOIN tbl_follow fl ON us.user_id = fl.follower_id
                WHERE us.user_id = '$user_id'
                GROUP BY us.user_id";
        $result = $this->db->select($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['following_count'];
        } else {
            return 0;
        }
    }
    // func get user 
    public function get_user($user_id)
    {
        $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
}
?>