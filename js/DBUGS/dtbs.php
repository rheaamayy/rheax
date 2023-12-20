<?php
$host='localhost';
$dbname='webts';
$db_user='root';
$db_pass='';

$conn=mysqli_connect($host, $db_user, $db_pass, $dbname);

if(!$conn){
    die();
}
else{
    echo "Connection established." .  "<br>";
}

?>