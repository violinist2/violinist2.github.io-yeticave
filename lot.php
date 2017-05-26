<?php 
session_start();
ob_start();
require_once 'functions.php';
require_once 'classes/Database.php';
require_once 'classes/Authorization.php';
$database = new Database;
$auth = new Authorization;

$id = intval(protect_code($_GET['id']));

$sql = "SELECT items.item_name, items.description, items.image_path, categories.category_name, 
items.price_start, items.user_author_id, items.bet_step, items.date_end FROM items JOIN categories 
ON items.category_id = categories.id WHERE items.id = ?;";
$item_data = $database->selectData($sql, [$id]);

if ($item_data==false) {
   header("Location: /", true, 404);
   exit(); 
}
$item_data = $item_data[0];

$userdata = $auth->getUserdata();
connect_code('templates/header.php', $userdata); 

$sql = "SELECT users.username, bets.bet_amount, bets.date_betmade 
FROM bets JOIN users ON bets.user_id = users.id 
WHERE bets.item_id = ? ORDER BY bets.bet_amount DESC;";
$bets = $database->selectData($sql, [$id]); 

if (empty($bets)) { // ставок нет, 
    $cost[0] = protect_code($item_data[4]); // текущая цена - стартовая
    $cost[1] = $cost[0]; // можно купить по текущей цене (сделать ставку, равную текущей)
} else {
    $cost[0] = protect_code($bets[0][1]); // текущая цена = максимальная из ставок
    $cost[1] = $cost[0] + protect_code($item_data[6]); // минимальная новая ставка = максимальная из поставленных + шаг ставки
}

if ($_POST['form-sent']) {
    $_POST['cost'] = protect_code($_POST['cost']);
    // проверяем, все ли параметры введены и соответствуют: авторизация, ставка, целое ли число ставка, больше ли минимальной ставки
    if (!empty($userdata['auth_user_id']) && !empty($_POST['cost']) && (intval($_POST['cost'])>0) && intval($_POST['cost'])>=intval($cost[1])) {
        // не кончился ли лот тем временем - тоже надо проверить бы? в идеале?
        $newbet = bet_save($_POST['cost'], $userdata['auth_user_id'], $id);
        // здесь будет проверка на сохранение??
        header("Location: /lot.php?id=".$id);
        exit();
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=protect_code($item_data[0]); ?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php
$sql = "SELECT id, category_name FROM categories ORDER BY id ASC;";
$categories = $database->selectData($sql, '');

connect_code('templates/main_lot.php', [$categories, $bets, $userdata, $item_data, $cost, $id]);
connect_code('templates/footer.php', $categories);
?>
</body>
</html>