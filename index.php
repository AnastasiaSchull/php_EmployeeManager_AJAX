<?php

require_once 'createdb.php'; // файл с функцией подключения к базе данных
require_once 'initdb.php'; //файл с функцией инициализации данных, если нужно

$conn = getDbConnection();

$checkQuery = "SELECT COUNT(*) as cnt FROM Employees";
$checkResult = $conn->query($checkQuery);
$row = $checkResult->fetch_assoc();
if ($row['cnt'] == 0) {
    initializeData($conn); // заполняем таблицу, если она пуста
}
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>';

//получим все записи
$query = "SELECT * FROM Employees";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Country</th><th>City</th><th>Salary</th></tr>";
    // вывод данных каждой строки
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["Name"] . "</td><td>" . $row["Surname"] . "</td><td>" . $row["Country"] . "</td><td>" . $row["City"] . "</td><td>" . $row["Salary"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();

