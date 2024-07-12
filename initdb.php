<?php
require_once 'createdb.php';
$db = getDbConnection();
function initializeData($conn) {
    $employees = [
        ["John", "Doe", "USA", "New York", 1000],
        ["Jane", "Smith", "USA", "Los Angeles", 1300],
        ["Alice", "Johnson", "Germany", "Berlin", 850],
        ["Mykhailo", "Sidorenko", "Ukraine", "Lviv", 600],
        ["Patricia", "Jones", "UK", "Liverpool", 900],
        ["Anna", "Brown", "UK", "London", 1400],
        ["Linda", "Miller", "USA", "New York", 1100],
        ["David", "Wilson", "Germany", "Munich", 1500],
        ["Elizabeth", "Moore", "UK", "London", 1200],
        ["Charles", "Taylor", "USA", "California", 1250],
        ["Chris", "Davis", "Canada", "Toronto", 1300],
        ["Denise", "Clark", "USA", "New York", 1350],
        ["Tom", "Lewis", "UK", "Manchester", 950],
        ["Natalie", "White", "USA", "New York", 1150],
        ["Barry", "Harris", "Australia", "Sydney", 1600],
        ["Olivia", "Thompson", "USA", "San Francisco", 1800],
        ["Max", "Martinez", "Spain", "Madrid", 1100],
        ["Sophie", "Anderson", "France", "Paris", 1700],
        ["Dmitro", "Ivantnko", "Ukraine", "Odessa", 1300],
        ["Sergiy", "Petrenko", "Ukraine", "Kiev", 1200],
        ["Irina", "Herbst", "Germany", "Munich", 800],
        ["David", "Smith", "UK", "London", 1900],
        ["Hannah", "Murphy","China", "Pekin", 950],
        ["Lucas", "Garcia", "Mexico", "Mexico City", 850],
        ["Emma", "Martinez", "USA", "California", 950],
        ["Ethan", "Lee", "China", "Shanghai", 2200],
        ["Mason", "Lopez", "Brazil", "Sao Paulo", 900],
        ["Logan", "Gonzalez", "Argentina", "Buenos Aires", 800],
        ["Aiden", "Wilson", "Australia", "Sydney", 1200],
        ["Jacques", "Laport", "France", "Paris", 700]
    ];

    $stmt = $conn->prepare("INSERT INTO Employees (Name, Surname, Country, City, Salary) VALUES (?, ?, ?, ?, ?)");

    $name = $surname = $country = $city = $salary = '';
    $stmt->bind_param("ssssi", $name, $surname, $country, $city, $salary);

    foreach ($employees as $emp) {
        [$name, $surname, $country, $city, $salary] = $emp;//деструктуризация массива
        $stmt->execute();
    }

    $stmt->close();
}
?>