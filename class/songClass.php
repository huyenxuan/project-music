<?php
include(__DIR__ . '/../lib/database.php');
?>
<?php
class Song
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // slug
    public function create_slug($song_name, $author)
    {
        $combined_string = $song_name . ' ' . $author;

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

        $slug = preg_replace($search, $replace, $combined_string);
        $slug = preg_replace('/(-)+/', '-', $slug);
        $slug = strtolower($slug);

        return $slug;
    }

    // lấy thông tin qua slug
    public function get_category_by_slug($slug)
    {
        $query = "SELECT * FROM tbl_category WHERE slug = '$slug'";
        $result = $this->db->select($query);
        return $result;
    }
    // insert
    public function insert_song($song_name, $user_id, $category_id, $privacy, $song_image, $file_path)
    {
        $slug = $this->create_slug($song_name, $user_id);
        $query = "INSERT INTO tbl_song (
                    song_name,
                    user_id,
                    category_id,
                    privacy,
                    song_image,
                    file_path,
                    slug_song)
                VALUE (
                    '$song_name',
                    '$user_id',
                    '$category_id',
                    '$privacy',
                    '$song_image',
                    '$file_path',
                    '$slug'
                )";
        $result = $this->db->insert($query);
        return $result;
    }
    // func update song
    public function update_song($song_name, $user_id, $category_id, $privacy, $song_image, $file_path, $song_id)
    {
        $slug = $this->create_slug($song_name, $user_id);
        $query = "UPDATE tbl_song
                SET song_name = '$song_name',
                    user_id = '$user_id',
                    category_id = '$category_id',
                    privacy = '$privacy',
                    song_image = '$song_image',
                    file_path = '$file_path',
                    slug_song = '$slug'
                WHERE song_id = '$song_id'";
        $result = $this->db->update($query);

        return $result;
    }
    // func delete song
    public function delete_song($slug_song)
    {
        $query = "DELETE FROM tbl_song WHERE slug_song = '$slug_song'";
        $result = $this->db->delete($query);
        return $result;
    }
    // search song
    public function search_song($song_name)
    {
        $query = "SELECT * 
                FROM tbl_song s
                LEFT JOIN tbl_user us on us.user_id = s.user_id
                WHERE song_name LIKE '%$song_name%'";
        $result = $this->db->select($query);
        return $result;
    }
    // func show song
    public function show_song()
    {
        $limit = 6;

        $queryALl = 'SELECT * FROM tbl_song';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = ($page - 1) * $limit;
        $query = "SELECT * 
                FROM tbl_song s
                LEFT JOIN tbl_user us on us.user_id = s.user_id
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // func show category
    public function show_category()
    {
        $query = "SELECT * FROM tbl_category";
        $result = $this->db->select($query);
        return $result;
    }
    // lấy thông tin qua slug
    public function get_song_by_slug($slug)
    {
        $query = "SELECT * FROM tbl_song WHERE slug_song = '$slug'";
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