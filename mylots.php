<?php
session_start();
require_once 'functions.php';
require_once 'classes/Database.php';
require_once 'classes/Authorization.php';
$database = new Database;
$auth = new Authorization;

if (!$auth->isAuthorized()) {
    header('HTTP/1.1 403 incorrect user');
    exit(); 
}
$userdata = $auth->getUserdata();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Мои ставки</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?php
connect_code('templates/header.php', $userdata);  

$sql = "SELECT id, category_name FROM categories ORDER BY id ASC;";
$categories = $database->selectData($sql, '');

$sql = "SELECT items.id, items.item_name, items.image_path, bets.bet_amount, 
bets.date_betmade, categories.category_name FROM bets JOIN items 
ON bets.item_id = items.id JOIN categories ON items.category_id = categories.id 
WHERE bets.user_id = ? ORDER BY bets.date_betmade DESC;";
$mybets = $database->selectData($sql, [$userdata['auth_user_id']]);
connect_code('templates/main_mylots.php', [$mybets, $categories]);

connect_code('templates/footer.php', $categories);
?>
</body>
</html>