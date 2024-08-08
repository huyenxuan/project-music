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
        $slug = $this->create_slug($category_name);
        $query = "INSERT INTO tbl_category (category_name, slug) 
                VALUES ('$category_name', '$slug')";
        $result = $this->db->insert($query);
        return $result;
    }
    // func update
    public function update_category($category_name, $category_id)
    {
        $slug = $this->create_slug($category_name);
        $query = "UPDATE tbl_category 
                SET category_name = '$category_name', slug = '$slug' 
                WHERE category_id = '$category_id'";
        $result = $this->db->update($query);
        return $result;
    }
    // func xóa
    public function delete_category($slug)
    {
        $query = "DELETE FROM tbl_category WHERE slug = '$slug'";
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
    public function get_category_by_slug($slug)
    {
        $query = "SELECT * FROM tbl_category WHERE slug = '$slug'";
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