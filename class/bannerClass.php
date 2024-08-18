<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class Banner
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
    // func insert
    public function insert_banner($banner_name, $banner_image, $pathway)
    {
        $query = "INSERT INTO tbl_banner (banner_name, banner_image, pathway)
                VALUES ('$banner_name', '$banner_image', '$pathway')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func update
    public function update_banner($banner_name, $banner_image, $pathway, $banner_id)
    {
        $query = "UPDATE tbl_banner
                SET banner_image = '$banner_image',
                    pathway = '$pathway',
                    banner_name = '$banner_name'
                WHERE banner_id = '$banner_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // func del
    public function delete_banner($banner_id)
    {
        $query = "DELETE FROM tbl_banner
                WHERE banner_id = '$banner_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func show
    public function show_banner()
    {
        $query = "SELECT * FROM tbl_banner";
        $result = $this->db->select($query);
        return $result;
    }
    // get banner by id
    public function get_banner_by_id($banner_id)
    {
        $query = "SELECT * FROM tbl_banner
                WHERE banner_id = '$banner_id'";
        $result = $this->db->select($query);
        return $result;
    }
}
?>