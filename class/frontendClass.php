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

    // func show banner 
    public function show_banner()
    {
        $query = "SELECT * FROM tbl_banner";
        $result = $this->db->select($query);
        return $result;
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
                $mail->Subject = 'Mã quên mật khẩu';
                $mail->Body = 'Mã của bạn là: ' . $reset_code;

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
}
?>