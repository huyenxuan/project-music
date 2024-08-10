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
        $slug = $this->create_slug($playlist_name);
        $query = "INSERT INTO tbl_playlist (playlist_name, user_id, slug_playlist) 
                VALUES ('$playlist_name','$user_id', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }

    // func update
    public function update_playlist($playlist_name, $playlist_id)
    {
        $slug = $this->create_slug($playlist_name);
        $query = "UPDATE tbl_playlist 
                SET playlist_name = '$playlist_name', slug_playlist = '$slug' 
                WHERE playlist_id = '$playlist_id'";
        $result = $this->db->update($query);
        return $result;
    }

    // func xóa
    public function delete_playlist($slug_playlist)
    {
        $query = "DELETE FROM tbl_playlist WHERE slug_playlist = '$slug_playlist'";
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
        $query = "SELECT * FROM tbl_playlist 
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
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
                ORDER BY song_name DESC";
        $result = $this->db->select($query);
        return $result;
    }

    // func lấy bài hát ở playlist_song
    public function get_playlist_songs($slug_playlist)
    {
        $query = " SELECT * FROM tbl_song s
                INNER JOIN tbl_playlist_song ps ON s.song_id = ps.song_id
                INNER JOIN tbl_playlist p ON ps.playlist_id = p.playlist_id
                WHERE p.slug_playlist = '$slug_playlist'";
        $result = $this->db->select($query);
        return $result;
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

    // lấy thông tin qua slug
    public function get_playlist_by_slug($slug_playlist)
    {
        $query = "SELECT * FROM tbl_playlist WHERE slug_playlist = '$slug_playlist'";
        $result = $this->db->select($query);
        return $result;
    }

    // func search
    public function search_playlist($playlist_name)
    {
        $query = "SELECT * FROM tbl_playlist 
                WHERE playlist_name LIKE '%$playlist_name%'";
        $result = $this->db->select($query);
        return $result;
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
    public function delete_playlistSongId($playlistSongId)
    {
        $query = "DELETE FROM tbl_playlist_song WHERE playlist_song_id = '$playlistSongId'";
        $result = $this->db->delete($query);
        return $result;
    }
}
?>