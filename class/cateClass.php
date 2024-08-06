<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class Category
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    // func insert
    public function insert_category($category_name)
    {
        $query = "INSERT INTO tbl_category (category_name)
                VALUES ('$category_name')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func update
    public function update_category($category_name, $category_id)
    {
        $query = "UPDATE tbl_category 
                SET category_name = '$category_name'
                WHERE category_id = '$category_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // func xóa
    public function delete_category($category_id)
    {
        $query = "DELETE FROM tbl_category WHERE category_id = '$category_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    // func show
    public function show_category()
    {
        $limit = 10;

        $queryALl = 'SELECT * FROM tbl_category';
        $resultAll = $this->db->select($queryALl);
        $totalpage = ceil($resultAll->num_rows / $limit);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = ($page - 1) * $limit;
        $query = "SELECT * FROM tbl_category 
                LIMIT $from, $limit";
        $result = $this->db->select($query);
        return ['result' => $result, 'totalpage' => $totalpage, 'page' => $page];
    }
    // func lấy ra thông tin
    public function get_category($category_id)
    {
        $query = "SELECT * FROM tbl_category WHERE category_id = '$category_id'";
        $result = $this->db->select($query);
        return $result;
    }
    // func search
    public function search_category($category_name)
    {
        $query = "SELECT * FROM tbl_category 
                WHERE category_name LIKE '%$category_name%'";
        $result = $this->db->select($query);
        return $result;
    }
}
?>