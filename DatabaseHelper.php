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

    //region ADD

    public function addUser($username, $userpass) {
        $this->conn->query(
            "INSERT INTO Users (`Login`, `Password`) VALUES ('$username', '$userpass')");
    }

    public function addTable($userId, $tableName, $subjects, $students) {
        $this->setTableName($userId, $tableName);
        $this->conn->query("DROP TABLE IF exists Table$userId;");
        $query = "CREATE TABLE Table$userId "."( NameStudent varchar(45), "
            . $this->toColumnsQuery($subjects, "INT NULL DEFAULT NULL")." )";

        foreach($students as $student) {
            $this->addStudent($userId, $student);
        }

        $this->conn->query($query);
    }

    public function addStudent($userId, $studentName) {
        $this->conn->query("INSERT INTO Table$userId (NameStudent) VALUES ('$studentName')");
    }

    public function addMark($userId, $student, $subject, $mark) {
        $this->conn->query("UPDATE Table$userId SET $subject = $mark WHERE NameStudent = '$student'");
    }

    public function setTableName($userId, $tableName) {
        $this->updateUserTable($userId, $tableName);
    }

    //endregion ADD

    //region GET

    public function getUserName($userId) {
        return $this->getUserInfo("SELECT * FROM Users WHERE ID = $userId", "Login");
    }

    public function getUserId($userName) {
        return $this->getUserInfo("SELECT * FROM Users WHERE `Login` = '$userName'", "ID");
    }

    //endregion GET

    //region UPDATE

    public function updateUser($userId, $userName, $userPass) {
        $this->conn->query("UPDATE Users SET `Login` = '$userName', `Password` = '$userPass' WHERE ID = $userId");
    }

    public function updateUserName($userId, $userName) {
        $this->conn->query("UPDATE Users SET `Login` = '$userName' WHERE ID = $userId");
    }

    public function updateUserPass($userId, $userPass) {
        $this->conn->query("UPDATE Users SET `Password` = '$userPass' WHERE ID = $userId");
    }

    public function updateUserTable($userId, $tableName) {
        $this->conn->query("UPDATE Users SET `TableName` = '$tableName' WHERE ID = $userId");
    }

    //endregion UPDATE

    public function query($queryString) {
        $this->conn->query($queryString);
    }

    private function getUserInfo($query, $rowName) {
        if($result = $this->conn->query($query)) {
            while ($row = $result->fetch_assoc()) {
                return $row[$rowName];
            }
        }
        return -1;
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

function validation($vars) {
    foreach ($vars as $var) {
        if($var == null or $var == "")
            return true;
    }
    return false;
}


$helper = new DatabaseHelper();

$helper->addUser("Userf", "password");

?>