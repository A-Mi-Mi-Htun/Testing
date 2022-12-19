<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed") . $conn->connect_error;
}

$link = "CREATE TABLE IF NOT EXISTS User (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    img VARCHAR(255) NULL,
    address TEXT NOT NULL,
    created_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

//if ($conn->query($link) === TRUE) {
//    echo "Table User created successfully";
//} else {
//    echo "Error creating database: " . $conn->error;
//}
//
//$conn->close();