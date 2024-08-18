<?php
include(__DIR__ . "/../lib/database.php");
?>
<?php
class FrontEnd
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

}
?>