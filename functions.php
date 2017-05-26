<?php
date_default_timezone_set('Europe/Moscow');
// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";
// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');
// временная метка для настоящего времени
$now = time();
$lot_time_remaining = date('H:i' ,$tomorrow - $now - 3600 * 3);

function convert_time_unix($in_time) {
    return date_format(date_create_from_format('Y-m-d H:i:s', $in_time), U);
}

function convert_time($time_lot) {
    $date = convert_time_unix($time_lot);
    $difference = time() - $date;
    if ($difference < 60*60*24) { // меньше суток
        if ($difference < 3600) return round($difference / 60).' минут назад'; // меньше  часа - минуты
        if ($difference > 3600) return round($difference / 3600).' часов назад'; // больше часа - часы
        if ($difference == 3600) return 'Час назад';
    } else { // больше суток
        return date('j.m.y '.'в'.' H:i', $date);
    }
}

function connect_code($address, $data) {
    if  (file_exists($address)) {
        require_once $address;
    } else { 
        return '';
    }
}

function protect_code($in_data) {
    return htmlspecialchars(strip_tags(trim($in_data)));
}

function bet_save($cost, $user_id, $lot_id) {
    $database = new Database;
    $sql = "INSERT INTO bets SET id = NULL, 
    bet_amount = ?, user_id = ?, item_id = ?, date_betmade = NOW();";
    $newbet = $database->insertData($sql, [$cost, $user_id, $lot_id]);
    return $newbet;
}

function item_save($name, $description, $image, $rate, $finishdate, $step, $author, $category) {
    $database = new Database;
    $sql = "INSERT INTO items SET id = NULL, date_add = NOW(), item_name = ?, 
    description = ?, image_path = ?, price_start = ?, date_end = ?, 
    bet_step = ?, favorites_count = NULL, user_author_id = ?, 
    user_winner_id = NULL, category_id = ?;";
    $newitem = $database->insertData($sql, [$name, $description, $image, $rate, $finishdate, $step, $author, $category]);
    return $newitem;
}

require_once('mysql_helper.php');

function email_used($email) {
    $email = protect_code($email);
    if (!empty($email)) {
        $database = new Database;
        $sql = "SELECT email FROM users WHERE email = ?;";
        $arguments = [$email];
        $result = $database->selectData($sql, $arguments);
        return $result;
    }
}

function get_next_id($table) {
    $database = new Database;
    $table = protect_code($table);
    $sql = "SELECT MAX(id) FROM $table;"; // похоже, не всегда +1 от максимального id == auto_increment, но пусть так
    $result = $database->selectData($sql, ''); // имя таблицы в виде подготовленного значения, к сожалению, передать не удаётся
    return intval($result[0][0]) + 1;
}
?>