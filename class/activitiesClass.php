<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class Activities
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function showActivities()
    {
        $limit = 20;

        $queryALl = 'SELECT * FROM tbl_admin_logs
                    WHERE tbl_admin_logs.created_at >= NOW() - INTERVAL 5 DAY';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $from = ($page - 1) * $limit;

        $query = "SELECT *
                FROM tbl_admin_logs 
                JOIN tbl_user ON tbl_admin_logs.admin_id = tbl_user.user_id
                WHERE tbl_admin_logs.created_at >= NOW() - INTERVAL 5 DAY
                ORDER BY id DESC
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // func search
    public function search_admin_logs($key, $page, $limit)
    {
        $from = ($page - 1) * $limit;

        $query = "SELECT *
                FROM tbl_admin_logs
                JOIN tbl_user ON tbl_admin_logs.admin_id = tbl_user.user_id
                WHERE tbl_admin_logs.created_at >= NOW() - INTERVAL 5 DAY
                AND (tbl_user.fullName LIKE '%$key%'
                    OR tbl_admin_logs.actions LIKE '%$key%'
                    OR tbl_admin_logs.details LIKE '%$key%'
                    OR tbl_admin_logs.created_at LIKE '%$key%')
                ORDER BY id DESC
                LIMIT $from, $limit";

        $result = $this->db->select($query);

        $total_query = "SELECT COUNT(*) as total
                    FROM tbl_admin_logs
                    JOIN tbl_user ON tbl_admin_logs.admin_id = tbl_user.user_id
                    WHERE tbl_admin_logs.created_at >= NOW() - INTERVAL 5 DAY
                    AND (tbl_user.fullName LIKE '%$key%'
                        OR tbl_admin_logs.actions LIKE '%$key%'
                        OR tbl_admin_logs.details LIKE '%$key%'
                        OR tbl_admin_logs.created_at LIKE '%$key%')";
        $total_result = $this->db->select($total_query);
        $total_record = $total_result->fetch_assoc()['total'];
        $total_page = ceil($total_record / $limit);

        return ['result' => $result, 'totalpage' => $total_page, 'page' => $page];
    }
}
?>