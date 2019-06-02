<?php



class DatabaseHelper {

    private $servername = "localhost";
    private $username = "user";
    private $password = "pass";
    private $dbname = "DB";

    private $conn = null;

    function __construct() {
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        );
    }


    public function addUser($username, $userpass) {
        $this->conn->query(
            "INSERT INTO Users (`Login`, `Password`) VALUES ('$username', '$userpass')");
    }

    public function addTable($userId, $subjects, $students) {
        $this->conn->query("DROP TABLE IF exists Table$userId;");
        $query = "CREATE TABLE Table$userId "."( NameStudent varchar(45), ".$this->toColumnsQuery($subjects, "INT NULL DEFAULT NULL")." )";
        foreach($students as $student) {
            $this->addStudent($userId, $student);
        }
        $this->conn->query($query);
    }

    public function addStudent($userId, $studentName) {
        $this->conn->query("INSERT INTO Table$userId (NameStudent) VALUES ('$studentName')");
    }

    public function getUserName($userId) {
        return $this->conn->query("SELECT * FROM Users WHERE ID = $userId");
    }

    public function addMark($userId, $student, $subject, $mark) {
        $this->conn->query("UPDATE Table$userId SET $subject = $mark WHERE NameStudent = '$student'");
    }

    private function toColumnsQuery($arr, $prefix) {
        $result = " ";
        for ($i = 0; $i < sizeof($arr)-1; $i++) {
            $result = $result.$arr[$i]." $prefix, ";
        }
        $result = $result.$arr[$i]." $prefix ";
        return $result;
    }
}
?>