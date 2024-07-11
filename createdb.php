<?php
function getDbConnection() {
$user = "root";
$pass = "";
$dbName = "employees";
$host = "localhost";

//cоздаем соединение
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
   // echo "DB created successfully\n";
} else {
    //echo "Error creating database: " . $conn->error . "\n";
}

// выбираем базу данных
$conn->select_db($dbName);

// SQL для создания таблицы
$sql = "CREATE TABLE IF NOT EXISTS Employees (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Surname VARCHAR(255),
    Country VARCHAR(255),
    City VARCHAR(255),
    Salary INT
)default charset='utf8mb4'";

if ($conn->query($sql) === TRUE) {
    //echo "Table created successfully\n";
} else {
    //echo "Error creating table: " . $conn->error . "\n";
}
    return $conn;
}

