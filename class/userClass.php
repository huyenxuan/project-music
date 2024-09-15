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
    public function check_user($email)
    {
        $query = "SELECT * FROM tbl_user
                WHERE email = '$email'";
        $result = $this->db->select($query);
        if ($result)
            return true;
        else
            return false;
    }
    // check login
    // func login
    public function login_user($email, $password)
    {
        // Escape inputs to prevent SQL injection
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        $query = "SELECT * FROM tbl_user 
                WHERE email = '$email' 
                AND password = '$password'";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['fullName'] = $row['fullName'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['userimage'] = $row['userimage'];
            header('Location: index.php');
            exit();
        } else {
            return false;
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
        if (!$this->check_user($email)) {
            $slug = $this->create_slug($fullName);
            $query = "INSERT INTO tbl_user (
            fullName,
            email,
            password,
            description,
            userimage,
            role,
            slug) 
        VALUES (
            '$fullName',
            '$email',
            '$password',
            '$description',
            '$userimage',
            '$role',
            '$slug')";
            $result = $this->db->insert($query);
            return $result;
        } else {
            echo '<h2>Email hoặc Số điện thoại đã tồn tại!</h2>';
        }
    }
    // func register
    public function register($fullName, $email, $password)
    {
        $fullName = mysqli_real_escape_string($this->db->conn, $fullName);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        if (!$this->check_user($email)) {
            $slug = $this->create_slug($fullName);
            $query = "INSERT INTO tbl_user (
                    fullName,
                    email,
                    password,
                    slug) 
                VALUES (
                    '$fullName',
                    '$email',
                    '$password',
                    '$slug')";
            $result = $this->db->insert($query);
            return $result;
        } else {
            echo '<h2>Email hoặc Số điện thoại đã tồn tại!</h2>';
        }
    }
    // func update
    public function update_user($fullName, $email, $password, $description, $role, $userimage, $user_id)
    {
        $slug = $this->create_slug($fullName);
        $query = "UPDATE tbl_user
                SET fullName = '$fullName', 
                    email = '$email', 
                    password = '$password', 
                    description = '$description',
                    role = '$role',
                    userimage = '$userimage',
                    slug = '$slug'
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
    public function search_user($key, $page, $limit)
    {
        $from = ($page - 1) * $limit;

        $query = "SELECT *
              FROM tbl_user
              WHERE fullName LIKE '%$key%'
              OR role LIKE '%$key%'
              ORDER BY user_id DESC
              LIMIT $from, $limit";

        $result = $this->db->select($query);

        $total_query = "SELECT COUNT(*) as total
                    FROM tbl_user
                    WHERE fullName LIKE '%$key%'
                    OR role LIKE '%$key%'";

        $total_result = $this->db->select($total_query);
        $total_record = $total_result->fetch_assoc()['total'];
        $total_page = ceil($total_record / $limit);

        return ['result' => $result, 'totalpage' => $total_page, 'page' => $page];
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
    // slug
    public function create_slug($string)
    {
        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    // lấy thông tin qua id
    public function get_user_by_id($user_id)
    {
        $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func lưu trữ 
    public function logAdminAction($adminId, $actions, $details)
    {
        $adminId = mysqli_real_escape_string($this->db->conn, $adminId);
        $actions = mysqli_real_escape_string($this->db->conn, $actions);
        $details = mysqli_real_escape_string($this->db->conn, $details);

        $query = "INSERT INTO tbl_admin_logs (admin_id, actions, details) 
                VALUES ('$adminId', '$actions', '$details')";
        $result = $this->db->insert($query);
        return $result;
    }
}
?>