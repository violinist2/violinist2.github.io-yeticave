<?php
session_start();
ob_start;
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

$form_errors = [];
if ($_POST['form-sent']) { // если форма отправлена
  $_POST['lot-name'] = protect_code($_POST['lot-name']);
  $_POST['category'] = protect_code($_POST['category']);
  $_POST['message'] = protect_code($_POST['message']);
  $_POST['lot-rate'] = intval(protect_code($_POST['lot-rate']));
  $_POST['lot-step'] = intval(protect_code($_POST['lot-step']));
  $_POST['lot-date'] = protect_code($_POST['lot-date']);

  if (!is_numeric($_POST['lot-rate'])) $_POST['lot-rate'] = "";
  if (!is_numeric($_POST['lot-step'])) $_POST['lot-step'] = "";

  if (empty($_POST['lot-name'])) $form_errors['lot-name'] = 'Укажите название вашего лота!'; 
  if (empty($_POST['category'])) $form_errors['category'] = 'Обязательно нужно выбрать категорию!';
  if (empty($_POST['message'])) $form_errors['message'] = 'Укажите описание вашего товара!';
  if (empty($_POST['lot-rate'])) $form_errors['lot-rate'] = 'Укажите цену!';
  if (!is_int($_POST['lot-rate']) || $_POST['lot-rate']<0) $form_errors['lot-rate'] = 'Начальная цена должна быть целым числом больше нуля!';
  if (empty($_POST['lot-step'])) $form_errors['lot-step'] = 'Укажите шаг ставки!';
  if (!is_int($_POST['lot-step']) || $_POST['lot-step']<0) $form_errors['lot-step'] = 'Шаг ставки должен быть целым числом больше нуля!';

  // сложная проверка даты завершения торгов
  if (empty($_POST['lot-date'])) { // даты вообще нет
    $form_errors['lot-date'] = 'Укажите дату завершения продаж!';
  } else {
    $date = explode(".", $_POST['lot-date']);
    if (checkdate($date[1], $date[0], $date[2])==false) { // если дата некорректная
      $form_errors['lot-date'] = 'Введите корректную дату в формате ДД.ММ.ГГГГ!';
    } else { // все хорошо
      $tomorrow = time() + 86400;
      $date_end = date_format(date_create_from_format('d.m.Y', $_POST['lot-date']), U);
      // но срок должен быть больше суток от текущей даты
      if ($tomorrow > $date_end) $form_errors['lot-date'] = 'Торги должны завершиться не менее чем через сутки!';
    }
  }


  if ($_FILES['photo']['error']=="0") { // если файл отправлен без ошибок (код ошибки 0)
    $file = $_FILES['photo'];
    // а вдруг пользователь в название файла инъекцию умудрится записать? или вряд ли?
    if ((mime_content_type($_FILES['photo']['tmp_name'])=='image/jpeg') || (mime_content_type($_FILES['photo']['tmp_name'])=='image/png')) {
      // проверка на формат пройдена
      $fileto = "img/users/item".get_next_id('items').".".strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // даем файлу на сервер такое же имя, каким будет id, и прежнее расширение
      move_uploaded_file($file['tmp_name'], $fileto);               
    } else { // неподходящий формат!
      $form_errors['file'] = 'Фото товара принимается в изображениях формата .JPG или .PNG!';
    }
  } else { // если файл забыли
    $form_errors['file'] = 'Добавьте фотографию вашего товара для объявления.';
  }
  // здесь должны быть проверки параметров лота ещё? дата, отстоящая на какое-то время от текущей?
  if (empty($form_errors)) { // если уже НИКАКИХ ошибок нет - отработка добавления лота
    $_POST['lot-date'] = date_format(date_create_from_format('d.m.Y', $_POST['lot-date']), 'Y-m-d H:i:s'); // до того же времени в назначенный день завершения ведь?
    $newitem = item_save($_POST['lot-name'], $_POST['message'], $fileto, $_POST['lot-rate'], $_POST['lot-date'], $_POST['lot-step'], $userdata['auth_user_id'], $_POST['category']);
    header("Location: /lot.php?id=".$newitem);
    exit();
  }    
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Добавление лота</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<?php
connect_code('templates/header.php', $userdata);  

$sql = "SELECT * FROM categories ORDER BY id ASC;";
$categories = $database->selectData($sql, '');

if (empty($_POST['form-sent'])) { // если не была отправлена
  connect_code('templates/main_add_form.php', [$categories, '', '']);
} else { // если была отправлена
  if ($file['name']=="") $fileto = "";
  $form_olddata = [
    'file' => $fileto, // успешно загруженный файл, если был
    'lot-name' => $_POST['lot-name'],
    'category' => $_POST['category'],
    'lot-rate' => $_POST['lot-rate'],
    'message' => $_POST['message'],
    'photo' => $_POST['photo'],
    'lot-step' => $_POST['lot-step'],
    'lot-date' => $_POST['lot-date']
  ];
  connect_code('templates/main_add_form.php', [$categories, $form_errors, $form_olddata]);
}

connect_code('templates/footer.php', $categories); 
?>
</body>
</html>