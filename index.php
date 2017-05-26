<?php
session_start();
require_once 'functions.php';
require_once 'classes/Database.php';
require_once 'classes/Authorization.php';
$database = new Database;
$auth = new Authorization;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php
$userdata = $auth->getUserdata();
connect_code('templates/header.php', $userdata); 

$sql = "SELECT * FROM categories ORDER BY id ASC;";
$categories = $database->selectData($sql, '');

$sql = "SELECT items.id, items.item_name, items.price_start, items.image_path, categories.category_name
FROM items JOIN categories ON items.category_id = categories.id
WHERE items.date_end > NOW() ORDER BY items.date_end DESC;";
$open_items = $database->selectData($sql, '');
connect_code('templates/main.php', [$categories, $open_items]);
connect_code('templates/footer.php', $categories);
?>
</body>
</html>