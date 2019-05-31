<?php

$username = &urldecode($_GET['username']);
$userPassword =  urldecode($_GET['password']);

if($username == null) {
    echo "userName is null";
    return;
} else if ($username == "") {
    echo "userName is null";
    return;
}

$username = trim($username);
$username = stripslashes($username);
$username = htmlspecialchars($username);

$mysql = new mysqli('localhost', 'id7735324_kursovakn321', 'kursova20012001q');
$result = $mysqli->query("INSERT INTO `Groups` (`Users`) VALUES ('$username', '$userPassword')");

?>
