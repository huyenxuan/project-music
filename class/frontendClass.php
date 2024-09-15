<?php
include(__DIR__ . "/../lib/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './asset/PHPMailer/src/Exception.php';
require './asset/PHPMailer/src/PHPMailer.php';
require './asset/PHPMailer/src/SMTP.php';
?>
<?php
class FrontEnd
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    // check favorite
    public function check_song_in_favorite($user_id, $song_id)
    {
        $query = "SELECT * FROM tbl_favorite
                WHERE user_id = '$user_id'
                    AND song_id = '$song_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // remove favorite
    public function remove_from_favorite($user_id, $song_id)
    {
        $query = "DELETE FROM tbl_favorite
                WHERE user_id = '$user_id'
                    AND song_id = '$song_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // add favorite
    public function add_to_favorite($user_id, $song_id)
    {
        $query = "INSERT INTO tbl_favorite (user_id, song_id) 
                VALUES ('$user_id', '$song_id')";
        $result = $this->db->insert($query);
        return $result;
    }
    // show favorite
    public function show_favorite($user_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_favorite fvr
                JOIN tbl_song s ON fvr.song_id = s.song_id
                JOIN tbl_user us ON fvr.user_id = us.user_id
                WHERE fvr.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // check follow
    public function check_follow($followed_id, $following_id)
    {
        $query = "SELECT * FROM tbl_follow 
                WHERE follower_id = '$followed_id' 
                    AND following_id = '$following_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // insert follow
    public function insert_follow($followed_id, $following_id)
    {
        $query = "INSERT INTO tbl_follow (follower_id, following_id)
                VALUES ('$followed_id', '$following_id')";
        $result = $this->db->insert($query);
        return $result;
    }
    // delete follow
    public function delete_follow($followed_id, $following_id)
    {
        $query = "DELETE FROM tbl_follow 
                WHERE follower_id = '$followed_id' 
                    AND following_id = '$following_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func check email
    public function check_email($email)
    {
        $query = "SELECT * FROM tbl_user WHERE email = '$email'";
        $result = $this->db->select($query);
        return $result;
    }
    // func send code forget pass
    public function sendPasswordResetCode($email)
    {
        $query = "SELECT * FROM tbl_user WHERE email = '$email'";
        $result = $this->db->select($query);
        if ($result) {
            $reset_code = rand(100000, 999999);
            $_SESSION['reset_code'] = $reset_code;
            $_SESSION['reset_email'] = $email;

            $mail = new PHPMailer(true);

            try {
                //Cài đặt server
                $mail->isSMTP(); //kiểm tra có phải 
                $mail->Host = 'smtp.gmail.com'; // Máy chủ SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'huyen107203@gmail.com'; // Địa chỉ email của bản thân
                $mail->Password = 'xilawimubabhwgqg'; // Mật khẩu ứng dụng của bản thân
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Cài đặt hiển thị người nhận
                $mail->setFrom('huyen107203@gmail.com', 'Admin HHmusic');
                $mail->addAddress($email);

                // Nội dung
                $mail->isHTML(true);
                $mail->Subject = 'Reset password';
                $mail->Body = 'Mã đặt lại mật khẩu của bạn là: ' . $reset_code;

                // gửi mail
                $mail->send();
                return true;
            } catch (Exception $e) {
                echo $mail->ErrorInfo;
            }
        } else {
            return false;
        }
    }
    // func upd password
    public function update_password($email, $password)
    {
        $query = "UPDATE tbl_user
                SET password = '$password'
                WHERE email = '$email'";
        $result = $this->db->update($query);
        return $result;
    }
    // func search song
    public function search_song($keyword)
    {
        $query = "SELECT * tbl_song
                WHERE song_name = '$keyword' 
                    AND privacy = 'public'";
        $result = $this->db->select($query);
        return $result;
    }
    // show banner
    public function show_banner()
    {
        $query = "SELECT * FROM tbl_banner
                WHERE display = 'show'";
        $result = $this->db->select($query);
        return $result;
    }
    // func show songs with highest listen
    public function show_song_hot()
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.privacy = 'public'
                ORDER BY s.listen_count DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show album width hightest listen 
    public function show_album_hot()
    {
        $query = "SELECT *, us.fullName AS authorAlbum
                FROM tbl_album ab
                JOIN tbl_user us ON ab.user_id = us.user_id
                WHERE ab.privacy = 'public'
                ORDER BY ab.listen_count DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show playlist width hightest listen 
    public function show_playlist_hot()
    {
        $query = "SELECT *, us.fullName AS authorPlaylist
                FROM tbl_playlist pl
                JOIN tbl_user us ON pl.user_id = us.user_id
                WHERE pl.privacy = 'public'
                ORDER BY pl.listen_count DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show 4 image playlist
    public function show_image_playlist($playlist_id)
    {
        $query = "SELECT s.song_image AS songImage 
                FROM tbl_playlist pl
                JOIN tbl_playlist_song pls ON pl.playlist_id = pls.playlist_id
                JOIN tbl_song s ON pls.song_id = s.song_id
                WHERE pl.playlist_id = '$playlist_id'
                LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }
    // func show new
    public function show_song_new()
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.privacy = 'public'
                ORDER BY s.song_id DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show new album
    public function show_album_new()
    {
        $query = "SELECT *, us.fullName AS authorAlbum
                FROM tbl_album ab
                JOIN tbl_user us ON ab.user_id = us.user_id
                WHERE ab.privacy = 'public'
                ORDER BY ab.album_id DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show new playlist 
    public function show_playlist_new()
    {
        $query = "SELECT *, us.fullName AS authorPlaylist
                FROM tbl_playlist pl
                JOIN tbl_user us ON pl.user_id = us.user_id
                WHERE pl.privacy = 'public'
                ORDER BY pl.playlist_id DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func maylike
    public function show_random_songs()
    {
        $query = "SELECT *, us.fullName AS authorSong 
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.privacy = 'public'
                ORDER BY RAND() LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // get song by id
    public function get_song_by_id($song_id)
    {
        $query = "SELECT * FROM tbl_song s
                JOIN tbl_category ct ON s.category_id = ct.category_id
                WHERE song_id='$song_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func update song
    public function update_song($song_name, $user_id, $category_id, $lyrics, $privacy, $song_image, $file_path, $song_id)
    {
        $slug = $this->create_slug($song_name, $user_id);
        $query = "UPDATE tbl_song
                SET song_name = '$song_name',
                    user_id = '$user_id',
                    category_id = '$category_id',
                    lyrics = '$lyrics',
                    privacy = '$privacy',
                    song_image = '$song_image',
                    file_path = '$file_path',
                    slug_song = '$slug'
                WHERE song_id = '$song_id'";
        $result = $this->db->update($query);

        return $result;
    }
    // func show songs same category
    public function show_song_same_category($song_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.privacy = 'public'
                    AND s.category_id = (
                        SELECT category_id 
                        FROM tbl_song 
                        WHERE song_id = '$song_id')
                ORDER BY CASE 
                WHEN song_id = '$song_id' THEN 0
                ELSE 1 END
                LIMIT 30";
        $result = $this->db->select($query);
        return $result;
    }
    // show song in album 
    public function show_song_in_album($album_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_album ab
                JOIN tbl_album_song abs ON ab.album_id = abs.album_id
                JOIN tbl_song s ON abs.song_id = s.song_id
                JOIN tbl_user us on s.user_id = us.user_id
                WHERE ab.album_id = '$album_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // show song in playlist
    public function show_song_in_playlist($playlist_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_playlist pl
                JOIN tbl_playlist_song pls ON pl.playlist_id = pls.playlist_id
                JOIN tbl_song s ON pls.song_id = s.song_id
                JOIN tbl_user us on s.user_id = us.user_id
                WHERE pl.playlist_id = '$playlist_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func show other user 
    public function show_user()
    {
        $query = "SELECT us.*, COUNT(fl.follower_id) AS followers_count
                FROM tbl_user us
                LEFT JOIN tbl_follow fl ON us.user_id = fl.follower_id
                GROUP BY us.user_id
                ORDER BY followers_count DESC
                LIMIT 12";
        $result = $this->db->select($query);
        return $result;
    }
    // func show follower
    public function show_follower($user_id)
    {
        $query = "SELECT *, COUNT(fl.follower_id) AS followers_count
                FROM tbl_follow fl
                LEFT JOIN tbl_user us ON fl.following_id = us.user_id
                WHERE us.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // show_usuksong
    public function show_usukSong()
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                JOIN tbl_category ct ON s.category_id = ct.category_id
                WHERE s.privacy = 'public' 
                    AND ct.category_name LIKE '%Âu - Mỹ%'";
        $result = $this->db->select($query);
        return $result;
    }
    // show_vnsong
    public function show_vnSong()
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                JOIN tbl_category ct ON s.category_id = ct.category_id
                WHERE s.privacy = 'public' 
                    AND ct.category_name NOT LIKE '%Âu - Mỹ%'";
        $result = $this->db->select($query);
        return $result;
    }
    // get user
    public function get_user($user_id)
    {
        $query = "SELECT us.*, COUNT(fl.follower_id) AS followers_count
                FROM tbl_user us
                LEFT JOIN tbl_follow fl ON us.user_id = fl.follower_id
                WHERE us.user_id = '$user_id'
                GROUP BY us.user_id";
        $result = $this->db->select($query);
        return $result;
    }
    // get following
    public function get_following($user_id)
    {
        $query = "SELECT *, us.fullName AS following_name
              FROM tbl_follow fl
              JOIN tbl_user us ON fl.following_id = us.user_id
              WHERE fl.follower_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // get follower
    public function get_follower($user_id)
    {
        $query = "SELECT *, us.fullName AS follower_name
              FROM tbl_follow fl
              JOIN tbl_user us ON fl.follower_id = us.user_id
              WHERE fl.following_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // upd user 
    public function update_user($fullName, $password, $userimage, $user_id)
    {
        $query = "UPDATE tbl_user
                SET fullName = '$fullName',
                    password = '$password',
                    userimage = '$userimage'
                WHERE user_id = '$user_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // show song of user
    public function show_song_of_user($user_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.user_id = '$user_id' 
                    AND s.privacy = 'public'";
        $result = $this->db->select($query);
        return $result;
    }
    // show all song of user
    public function show_song_allsong_user($user_id)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // show album of user
    public function show_album_of_user($user_id)
    {
        $query = "SELECT *, us.fullName AS authorAlbum
                FROM tbl_album ab
                JOIN tbl_user us ON ab.user_id = us.user_id
                WHERE ab.user_id = '$user_id' 
                    AND ab.privacy = 'public'";
        $result = $this->db->select($query);
        return $result;
    }
    // show playlist of user
    public function show_playlist_of_user($user_id)
    {
        $query = "SELECT *, us.fullName AS authorPlaylist
                FROM tbl_playlist pl
                JOIN tbl_user us ON pl.user_id = us.user_id
                WHERE pl.user_id = '$user_id' 
                    AND pl.privacy = 'public'";
        $result = $this->db->select($query);
        return $result;
    }
    // insert song
    public function insert_song($song_name, $user_id, $category_id, $lyrics, $privacy, $song_image, $file_path)
    {
        $slug = $this->create_slug($song_name, $user_id);
        $query = "INSERT INTO tbl_song (song_name, user_id, category_id, lyrics, privacy, song_image, file_path, slug_song)
                VALUE (
                    '$song_name',
                    '$user_id',
                    '$category_id',
                    '$lyrics',
                    '$privacy',
                    '$song_image',
                    '$file_path',
                    '$slug'
                )";
        $result = $this->db->insert($query);
        return $result;
    }
    public function delete_song($song_id)
    {
        $query = "DELETE FROM tbl_song
                WHERE song_id = '$song_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // insert album
    public function insert_album($album_name, $user_id, $album_image, $description, $privacy)
    {
        $slug = $this->create_slug($album_name, $user_id);
        $query = "INSERT INTO tbl_album (user_id, album_name, album_image, description, privacy, album_slug)
                VALUES ('$user_id', '$album_name', '$album_image', '$description', '$privacy', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func get album by id
    public function get_album_by_id($album_id)
    {
        $query = "SELECT * FROM tbl_album ab
                WHERE album_id = '$album_id'";
        $result = $this->db->select($query);
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
    // func del song in album
    public function delete_albumSongId($album_id, $albumSongId)
    {
        $query = "DELETE FROM tbl_album_song
                WHERE album_song_id = '$albumSongId'
                    AND album_id = '$album_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func delete album
    public function delete_album($album_id)
    {
        $query = "DELETE FROM tbl_album
                WHERE album_id = '$album_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func get song
    public function get_album_songs($album_id)
    {
        $query = " SELECT * FROM tbl_song s
                INNER JOIN tbl_album_song abs ON s.song_id = abs.song_id
                INNER JOIN tbl_album ab ON abs.album_id = ab.album_id
                WHERE ab.album_id = '$album_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func add song to album
    public function add_song_to_album($album_id, $song_id)
    {
        $query = "INSERT INTO tbl_album_song (album_id, song_id)
                VALUES ('$album_id', '$song_id')";
        $result = $this->db->insert($query);
        return $result;
    }
    // insert playlist
    public function insert_playList($playlist_name, $user_id)
    {
        $slug = $this->create_slug($playlist_name, $user_id);
        $query = "INSERT INTO tbl_playlist (playlist_name, user_id, slug_playlist) 
                VALUES ('$playlist_name','$user_id', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }
    // update playlist
    public function update_playlist($playlist_name, $user_id, $privacy, $playlist_id)
    {
        $slug = $this->create_slug($playlist_name, $user_id);
        $query = "UPDATE tbl_playlist 
                SET playlist_name = '$playlist_name', slug_playlist = '$slug', privacy = '$privacy'
                WHERE playlist_id = '$playlist_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // get playlist by playlist_id
    public function get_playlist_by_id($playlist_id)
    {
        $query = "SELECT * FROM tbl_playlist WHERE playlist_id = '$playlist_id'";
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
    // func xóa bài hát khỏi playlist
    public function delete_playlistSongId($playlist_id, $playlistSongId)
    {
        $query = "DELETE FROM tbl_playlist_song 
                WHERE playlist_song_id = '$playlistSongId'
                    AND playlist_id = '$playlist_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func delete playlist
    public function delete_playlist($playlist_id)
    {
        $query = "DELETE FROM tbl_playlist WHERE playlist_id = '$playlist_id'";
        $result = $this->db->delete($query);
        return $result;
    }
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

    // show category
    public function show_category()
    {
        $query = "SELECT * FROM tbl_category";
        $result = $this->db->select($query);
        return $result;
    }
    // show song by keysearch
    public function show_song_by_search($keysearch)
    {
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_category ct ON s.category_id = ct.category_id
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.privacy = 'public' AND (s.song_name LIKE '%$keysearch%'
                    OR ct.category_name LIKE '%$keysearch%'
                    OR us.fullName LIKE '%$keysearch%')";
        $result = $this->db->select($query);
        return $result;
    }
    // show album by keysearch
    public function show_album_by_search($keysearch)
    {
        $query = "SELECT *, us.fullName AS authorAlbum
                FROM tbl_album ab
                JOIN tbl_user us ON ab.user_id = us.user_id
                WHERE ab.album_name LIKE '%$keysearch%'
                    OR us.fullName LIKE '%$keysearch%'";
        $result = $this->db->select($query);
        return $result;
    }
    // show playlist by keysearch
    public function show_playlist_by_search($keysearch)
    {
        $query = "SELECT *, us.fullName AS authorPlaylist
                FROM tbl_playlist pl
                JOIN tbl_user us ON pl.user_id = us.user_id
                WHERE pl.playlist_name LIKE '%$keysearch%'
                    OR us.fullName LIKE '%$keysearch%'";
        $result = $this->db->select($query);
        return $result;
    }
    // show user by keysearch
    public function show_user_by_search($keysearch)
    {
        $query = "SELECT us.*, COUNT(fl.follower_id) AS followers_count
                FROM tbl_user us
                LEFT JOIN tbl_follow fl ON us.user_id = fl.follower_id
                WHERE us.fullName LIKE '%$keysearch%'
                GROUP BY us.user_id
                ORDER BY followers_count DESC";
        $result = $this->db->select($query);
        return $result;
    }
    // listen count
    public function update_listenCount($song_id)
    {
        $query = "UPDATE tbl_song 
                SET listen_count = listen_count + 1
                WHERE song_id = '$song_id'";
        $result = $this->db->update($query);
        return $result;
    }
}
?>