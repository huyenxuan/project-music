<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class Album
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    // func admin logs
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
    // func creat slug
    public function create_slug($song_name, $authorAB)
    {
        $combined_string = $song_name . ' ' . $authorAB;

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
    // func insert album
    public function insert_album($album_name, $user_id, $album_image, $description, $privacy)
    {
        $slug = $this->create_slug($album_name, $user_id);
        $query = "INSERT INTO tbl_album (user_id, album_name, album_image, description, privacy, album_slug)
                VALUES ('$user_id', '$album_name', '$album_image', '$description', '$privacy', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func update album
    public function update_album($album_name, $user_id, $album_image, $description, $privacy, $album_id)
    {
        $slug = $this->create_slug($album_name, $user_id);
        $query = "UPDATE tbl_album
                SET album_name = '$album_name',
                    album_image = '$album_image',
                    description = '$description',
                    privacy = '$privacy',
                    album_slug = '$slug'
                WHERE album_id = '$album_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // func delete album
    public function delete_album($album_slug)
    {
        $query = "DELETE FROM tbl_album
                WHERE album_slug = '$album_slug'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func show album
    public function show_album()
    {
        $limit = 6;

        $queryALl = 'SELECT * FROM tbl_album';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = ($page - 1) * $limit;
        $query = "SELECT * FROM tbl_album ab 
                LEFT JOIN tbl_user us ON ab.user_id = us.user_id
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // func count song in album
    function count_song_album($album_id)
    {
        $query = "SELECT COUNT(*) AS song_count 
                FROM tbl_album_song
                WHERE album_id = '$album_id'";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['song_count'];
        } else {
            return 0;
        }
    }
    // func get album by slug
    public function get_album_by_slug($album_slug)
    {
        $query = "SELECT * FROM tbl_album ab
                WHERE album_slug = '$album_slug'";
        $result = $this->db->select($query);
        return $result;
    }
    // func insert song in album
    public function add_song_to_album($album_id, $song_id)
    {
        $query = "INSERT INTO tbl_album_song (album_id, song_id)
                VALUES ('$album_id', '$song_id')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func del song in album
    public function delete_albumSongId($albumSongId)
    {
        $query = "DELETE FROM tbl_album_song
                WHERE album_song_id = '$albumSongId'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func show song
    public function show_song_of_userId($user_id)
    {
        $query = "SELECT * FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func get songs in album
    public function get_songs_in_album($album_id)
    {
        $query = "SELECT * FROM tbl_album_song abs
                LEFT JOIN tbl_song s ON abs.song_id = s.song_id
                WHERE abs.album_id = '$album_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func get song
    public function get_album_songs($album_slug)
    {
        $query = " SELECT * FROM tbl_song s
                INNER JOIN tbl_album_song abs ON s.song_id = abs.song_id
                INNER JOIN tbl_album ab ON abs.album_id = ab.album_id
                WHERE ab.album_slug = '$album_slug'";
        $result = $this->db->select($query);
        return $result;
    }
    // show user have song
    public function show_user()
    {
        $query = "SELECT DISTINCT us.fullName, us.user_id
              FROM tbl_user us
              INNER JOIN tbl_song s ON us.user_id = s.user_id";
        $result = $this->db->select($query);
        return $result;
    }

}
?>