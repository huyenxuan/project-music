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
    // show các bài có lượt yêu thích nhiều nhất
    public function show_most_favorite_songs()
    {
        $query = "SELECT s.song_id, s.song_name, COUNT(f.user_id) AS favorite_count
                FROM tbl_favorite f
                JOIN tbl_song s ON f.song_id = s.song_id
                GROUP BY f.song_id
                ORDER BY favorite_count DESC
                LIMIT 20";
    }
    // show idol
    public function show_idols_most_followers()
    {
        $query = "SELECT us.user_id, us.fullName, COUNT(fl.follower) AS follower_count
                FROM tbl_follow fl
                JOIN tbl_user us ON fl.following = us.user_id
                GROUP BY us.user_id, us.fullName
                ORDER BY follower_count DESC
                LIMIT 20";
        $result = $this->db->select($query);
        return $result;
    }
    // show song có lượt nghe nhiều
    public function show_song_many_listenCount()
    {
        $query = "SELECT *
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                ORDER BY listen_count DESC
                LIMIT 20";
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
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Máy chủ SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'huyen107203@gmail.com'; // Địa chỉ email của bạn
                $mail->Password = 'cbmngdwcdisvsdjs'; // Mật khẩu email của bạn
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('huyen107203@gmail.com', 'Admin HHmusic');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reset password';
                $mail->Body = 'Mã đặt lại mật khẩu của bạn là: ' . $reset_code;

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
                WHERE song_name = '$keyword'";
        $result = $this->db->select($query);
        return $result;
    }
    // func search user
    public function search_user($keyword)
    {
        $query = "SELECT * tbl_user
                WHERE fullName = '$keyword'";
        $result = $this->db->select($query);
        return $result;
    }
    // func search album
    public function search_album($keyword)
    {
        $query = "SELECT * tbl_album
                WHERE album_name = '$keyword'";
        $result = $this->db->select($query);
        return $result;
    }
    // func search playlist
    public function search_playlist($keyword)
    {
        $query = "SELECT * tbl_playlist
                WHERE playlist_name = '$keyword'";
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
    public function show_maylike($user_id)
    {
        $queryFavorite = "SELECT song_id 
                        FROM tbl_favorite 
                        WHERE user_id = '$user_id'";
        $resultFavorite = $this->db->select($queryFavorite);
        if ($resultFavorite) {
            $liked_songs = array();
            while ($row = $resultFavorite->fetch_assoc()) {
                $liked_songs[] = $row['song_id'];
            }

            $queryMayLike = "SELECT * FROM tbl_song WHERE genre IN (
                        SELECT genre FROM tbl_song WHERE song_id IN (" . implode(',', $liked_songs) . "))";
            $resultMayLike = $this->db->select($queryMayLike);
            return $resultMayLike;
        } else {
            return;
        }
    }
    // func show songs same category
    public function show_song_same_category($song_id)
    {
        // $query = "SELECT s.*, us.fullName AS authorSong
        //       FROM tbl_song s
        //       JOIN tbl_category ct ON s.category_id = ct.category_id
        //       JOIN tbl_user us ON s.user_id = us.user_id
        //       WHERE s.category_id = (SELECT category_id FROM tbl_song WHERE song_id = '$song_id')
        //       AND s.song_id != '$song_id'
        //       LIMIT 20";
        $query = "SELECT *, us.fullName AS authorSong
                FROM tbl_song s
                JOIN tbl_user us ON s.user_id = us.user_id
                WHERE s.song_id = '$song_id'";
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
    // func show song by user_id
    public function show_song_of_user($user_id)
    {
        $query = "SELECT *, COUNT(s.song_id) AS song_count
                FROM tbl_song s
                LEFT JOIN tbl_user us ON s.song_id = us.user_id
                WHERE us.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func show playlist by user_id
    public function show_playlist_of_user($user_id)
    {
        $query = "SELECT *
                FROM tbl_playlist pl
                LEFT JOIN tbl_user us ON pl.user_id = us.user_id
                WHERE us.user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
}
?>