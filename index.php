<?php

require_once 'createdb.php'; // файл с функцией подключения к базе данных
require_once 'initdb.php'; //файл с функцией инициализации данных, если нужно

$conn = getDbConnection();

$checkQuery = "SELECT COUNT(*) as cnt FROM Employees";
$checkResult = $conn->query($checkQuery);//выполнение запроса и получение объекта результата
$row = $checkResult->fetch_assoc();
if ($row['cnt'] == 0) {
    initializeData($conn); // заполняем таблицу, если она пуста
}
// получение уникальных стран
$countryQuery = "SELECT DISTINCT Country FROM Employees";
$countryResult = $conn->query($countryQuery);
$countries = [];
while ($row = $countryResult->fetch_assoc()) {
    $countries[] = $row['Country'];//доступ к значению через ключ
}

// получение уникальных городов
$cityQuery = "SELECT DISTINCT City FROM Employees";
$cityResult = $conn->query($cityQuery);
$cities = [];
while ($row = $cityResult->fetch_assoc()) {
    $cities[] = $row['City'];
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div  class="table-container">
        <table> 
            <thead>
                <tr><th>ID</th><th>Name</th><th>Surname</th><th>Country</th><th>City</th><th>Salary</th></tr>
            </thead>
            <tbody>';
//получим все записи
$query = "SELECT * FROM Employees";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // вывод данных каждой строки
    // etch_assoc() возвращает каждую строку рез-та как ассоц массив
    while ($row = $result->fetch_assoc()) {
    //  или интерполяция
        echo "<tr>
            <td>{$row['ID']}</td>
            <td>{$row['Name']}</td>
            <td>{$row['Surname']}</td>
            <td>{$row['Country']}</td>
            <td>{$row['City']}</td>
            <td>{$row['Salary']}</td>
          </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}
echo '</tbody>
</table>
</div>

    <div class="filters-container">
      <div class="filters-group">
        <h3>Country:</h3>';
foreach ($countries as $country) {
    echo '<label><input type="checkbox" class="filter-country" value="' . $country . '"> ' . $country . '</label>';
}
echo '</div>
        <div class="filters-group">
        <h3>City:</h3>';
foreach ($cities as $city) {
    echo '<label><input type="checkbox" class="filter-city" value="' . $city . '"> ' . $city . '</label>';
//классы filter-city и filter-city , чтобы JS мог их выбрать и добавить к ним обработчики событий
}
echo '</div>
 </div>
 
    <div class="sort-container">
        <p>Sort by name <a href="#" onclick="sortData(\'Name\', \'asc\')">Ascending</a> / <a href="#" onclick="sortData(\'Name\', \'desc\')">Descending</a></p>
        <p>Sort by surname <a href="#" onclick="sortData(\'Surname\', \'asc\')">Ascending</a> / <a href="#" onclick="sortData(\'Surname\', \'desc\')">Descending</a></p>
        <p>Sort by country <a href="#" onclick="sortData(\'Country\', \'asc\')">Ascending</a> / <a href="#" onclick="sortData(\'Country\', \'desc\')">Descending</a></p>
        <p>Sort by city <a href="#" onclick="sortData(\'City\', \'asc\')">Ascending</a> / <a href="#" onclick="sortData(\'City\', \'desc\')">Descending</a></p>
        <p>Sort by salary <a href="#" onclick="sortData(\'Salary\', \'asc\')">Ascending</a> / <a href="#" onclick="sortData(\'Salary\', \'desc\')">Descending</a></p>
    </div>
    </div>
    


<script src="js/sort.js"></script>
<script src="js/filter.js"></script>
</body>
</html>';

$conn->close();
?>

