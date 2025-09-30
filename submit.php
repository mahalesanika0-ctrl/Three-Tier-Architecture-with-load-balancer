<?php

$servername = "rds end point";
$username = "root";        
$password = "rutika123";    
$dbname = "facebook";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $conn->real_escape_string($_POST['name']);
$city = $conn->real_escape_string($_POST['city']);


$sql = "INSERT INTO users (name, city) VALUES ('$name', '$city')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>