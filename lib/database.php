<?php
include(__DIR__ . "/../config/config.php");
?>
<?php
class Database
{
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_NAME;
    public $conn;
    public $error;
    public function __construct()
    {
        $this->connectDB();
    }
    private function connectDB()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname
        );
        if ($this->conn->connect_error) {
            $this->error = "Connection fail: " . $this->conn->connect_error;
            return false;
        }
    }
    // select or read data
    public function select($query)
    {
        $result = $this->conn->query($query) or
            die($this->conn->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }
    // insert data
    public function insert($query)
    {
        $insert_row = $this->conn->query($query) or
            die($this->conn->error . __LINE__);
        if ($insert_row) {
            return $insert_row;
        } else {
            return false;
        }
    }
    // update data
    public function update($query)
    {
        $update_row = $this->conn->query($query) or
            die($this->conn->error . __LINE__);
        if ($update_row) {
            return $update_row;
        } else {
            return false;
        }
    }
    // delete data
    public function delete($query)
    {
        $delete_row = $this->conn->query($query) or
            die($this->conn->error . __LINE__);
        if ($delete_row) {
            return $delete_row;
        } else {
            return false;
        }
    }
}
?>