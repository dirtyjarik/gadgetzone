<?php
require "db.php"; // Подключение к базе

// Получаем категорию из запроса
$category = isset($_GET['category']) ? $_GET['category'] : 'smartphones'; // По умолчанию смартфоны

// Определяем допустимые таблицы (категории)
$valid_categories = [
    "smartphones", "computers", "peripherals", "gadgets_accessories",
    "televisions", "cameras", "kitchen_appliances", "home_appliances"
];

if (!in_array($category, $valid_categories)) {
    echo json_encode(["error" => "Invalid category"]);
    exit;
}

$table = $category; // Название таблицы

// Получаем фильтры из запроса
$filters = $_GET;
unset($filters['category']); // Убираем категорию из фильтров

$where = [];
$params = [];

// Обрабатываем фильтры
foreach ($filters as $key => $values) {
    if (!is_array($values)) {
        $values = [$values]; // Делаем массив, если передано одно значение
    }

    $placeholders = implode(',', array_fill(0, count($values), '?'));
    $where[] = "$key IN ($placeholders)";
    $params = array_merge($params, $values);
}


// Формируем SQL-запрос
$sql = "SELECT * FROM $table";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(["error" => "Query preparation failed"]);
    exit;
}

// Привязываем параметры к запросу
$types = str_repeat('s', count($params)); // Все параметры как строки
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>