<?php
require_once 'createdb.php';

$conn = getDbConnection();

//получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
$countries = $data['countries'];
$cities = $data['cities'];

$query = "SELECT * FROM Employees WHERE 1=1";
//WHERE 1=1, помогает для динамических SQL-запросов,yсловие, которое всегда истинно
if (count($countries) > 0) {
    // массив с объектами соединения для каждой страны ([ $conn, $conn, $conn ])
    $connArray = array_fill(0, count($countries), $conn);
    //получим массив экранированных значений стран
    $escapedCountries = array_map(function($conn, $country) {
        // экранируем строку $country с использованием соединения $conn(чтоб функция знала, какую кодировку использовать)
        return mysqli_real_escape_string($conn, $country);
    }, $connArray, $countries);
    // объединяем экранированные страны в строку
    $countriesList = implode("','", $escapedCountries);
    // добавляем условие для фильтрации по странам
    $query .= " AND Country IN ('$countriesList')";
}

if (count($cities) > 0) {
    $citiesList = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($cities), $conn), $cities));
    $query .= " AND City IN ('$citiesList')";
}

$result = $conn->query($query);//выполняем запрос

$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}
// устанавливаем заголовок ответа и отправляем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($employees);

$conn->close();
?>
