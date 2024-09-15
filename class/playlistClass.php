<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class PlayList
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    // func insert
    public function insert_playList($playlist_name, $user_id)
    {
        $slug = $this->create_slug($playlist_name, $user_id);
        $query = "INSERT INTO tbl_playlist (playlist_name, user_id, slug_playlist) 
                VALUES ('$playlist_name','$user_id', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }

    // func update
    public function update_playlist($playlist_name, $user_id, $playlist_id)
    {
        $slug = $this->create_slug($playlist_name, $user_id);
        $query = "UPDATE tbl_playlist 
                SET playlist_name = '$playlist_name', slug_playlist = '$slug' 
                WHERE playlist_id = '$playlist_id'";
        $result = $this->db->update($query);
        return $result;
    }

    // func delete
    public function delete_playlist($playlist_id)
    {
        $query = "DELETE FROM tbl_playlist WHERE playlist_id = '$playlist_id'";
        $result = $this->db->delete($query);
        return $result;
    }

    // func show
    public function show_playlist()
    {
        $limit = 10;

        $queryALl = 'SELECT * FROM tbl_playlist';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = ($page - 1) * $limit;
        $query = "SELECT * FROM tbl_playlist pl
                LEFT JOIN tbl_user us ON pl.user_id = us.user_id
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // check song_id && playlist_id
    public function check_song_in_playlist($playlist_id, $song_id)
    {
        $query = "SELECT * FROM tbl_playlist_song 
              WHERE playlist_id = '$playlist_id' 
              AND song_id = '$song_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // func add song to playlist
    function add_song_to_playlist($playlist_id, $song_id)
    {
        $query = "INSERT INTO tbl_playlist_song (playlist_id, song_id) VALUES ('$playlist_id', '$song_id')";
        $result = $this->db->insert($query);
        return $result;
    }

    // get song in playlist
    public function get_songs_in_playlist($playlist_id)
    {
        $query = "SELECT s.song_id, s.song_name 
                  FROM tbl_playlist_song ps
                  JOIN tbl_song s ON ps.song_id = s.song_id
                  WHERE ps.playlist_id = '$playlist_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // func show song
    public function show_song()
    {
        $query = "SELECT * 
                FROM tbl_song 
                WHERE privacy = 'public'
                ORDER BY song_name DESC";
        $result = $this->db->select($query);
        return $result;
    }

    // func lấy bài hát ở playlist_song
    public function get_playlist_songs($playlist_id)
    {
        $query = " SELECT * FROM tbl_song s
                INNER JOIN tbl_playlist_song ps ON s.song_id = ps.song_id
                INNER JOIN tbl_playlist p ON ps.playlist_id = p.playlist_id
                WHERE p.playlist_id = '$playlist_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // slug
    public function create_slug($playlist_name, $author)
    {
        $combined_string = $playlist_name . ' ' . $author;

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

    // lấy thông tin qua id
    public function get_playlist_by_id($playlist_id)
    {
        $query = "SELECT * FROM tbl_playlist WHERE playlist_id = '$playlist_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // func search
    public function search_playlist($playlist_name, $page, $limit)
    {
        $from = ($page - 1) * $limit;

        $query = "SELECT *
              FROM tbl_playlist pl
              JOIN tbl_user us ON pl.user_id = us.user_id
              WHERE playlist_name LIKE '%$playlist_name%'
              ORDER BY playlist_id ASC
              LIMIT $from, $limit";

        $result = $this->db->select($query);

        $total_query = "SELECT COUNT(*) as total
                    FROM tbl_playlist
                    WHERE playlist_name LIKE '%$playlist_name%'";

        $total_result = $this->db->select($total_query);
        $total_record = $total_result->fetch_assoc()['total'];
        $total_page = ceil($total_record / $limit);

        return ['result' => $result, 'totalpage' => $total_page, 'page' => $page];
    }

    // func đếm số bài hát
    function count_song_playlist($playlist_id)
    {
        $query = "SELECT COUNT(*) AS song_count 
                FROM tbl_playlist_song
                WHERE playlist_id = '$playlist_id'";
        $result = $this->db->select($query);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['song_count'];
        } else {
            return 0;
        }
    }
    // func xóa bài hát khỏi playlist
    public function delete_playlistSongId($playlist_id, $playlistSongId)
    {
        $query = "DELETE FROM tbl_playlist_song 
                WHERE playlist_song_id = '$playlistSongId'
                    AND playlist_id = '$playlist_id'";
        $result = $this->db->delete($query);
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
    // func show user
    public function show_user()
    {
        $query = "SELECT * FROM tbl_user";
        $result = $this->db->select($query);
        return $result;
    }
}
?>