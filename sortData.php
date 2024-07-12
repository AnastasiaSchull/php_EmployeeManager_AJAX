<?php
require_once 'createdb.php';

$conn = getDbConnection();

$sortField = $_GET['sort'] ?? 'ID'; // получаем поле для сортировки, по умолчанию ID
$sortOrder = $_GET['order'] ?? 'asc';// порядок сортировки, по умолчанию asc
// проверка значений переменных на допустимость
$validFields = ['ID', 'Name', 'Surname', 'Country', 'City', 'Salary'];
$validOrders = ['asc', 'desc'];


if (!in_array($sortField, $validFields)) {
    $sortField = 'ID';
}
if (!in_array($sortOrder, $validOrders)) {
    $sortOrder = 'asc';
}


// формируем запрос с сортировкой
$query = "SELECT * FROM Employees ORDER BY $sortField $sortOrder";
$result = $conn->query($query);

$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

//заголовок ответа и отправляем данные в формате json
header('Content-Type: application/json');
echo json_encode($employees);

$conn->close();
?>
