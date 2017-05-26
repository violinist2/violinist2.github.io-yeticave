<?php
// session_start(); // будем считать, что на страницу регистрации может попасть только неавторизованный?
ob_start();
require_once 'functions.php';
require_once 'classes/Database.php';
$database = new Database;

$form_errors = [];
if ($_POST['form-sent']) {
    $_POST['email'] = protect_code($_POST['email']);
    $_POST['password'] = protect_code($_POST['password']);
    $_POST['name'] = protect_code($_POST['name']);
    $_POST['message'] = protect_code($_POST['message']);
    $_POST['form-sent'] = protect_code($_POST['form-sent']);
    if (empty($_POST['email']) or (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)==false)) { // если почта не указана или указана некорректно
        $form_errors['email'] = 'Введите корректный адрес электронной почты.';
    } else {
        if (!empty(email_used($_POST['email']))) $form_errors['email'] = 'Этот адрес уже использован при регистрации на сайте.';
    }
    if (empty($_POST['password'])) $form_errors['password'] = 'Придумайте и укажите пароль.';
    if (empty($_POST['name'])) $form_errors['name'] = 'Укажите своё имя, оно будет отображаться на сайте.';
    if (empty($_POST['message'])) $form_errors['message'] = 'Нужно указать ваши контактные данные для покупателей.';
    if (empty($form_errors)) { // если других ошибок нет - загрузка файла
        // загрузка аватара на сервер ведь должна происходить, если других ошибок формы нет?
        if ($_FILES['avatar']['error']=="0") { // если файл отправлен без ошибок (код ошибки 0)
            $file = $_FILES['avatar'];
            // а вдруг пользователь в название файла инъекцию умудрится записать? или вряд ли?
            if ((mime_content_type($_FILES['avatar']['tmp_name'])=='image/jpeg') || (mime_content_type($_FILES['avatar']['tmp_name'])=='image/png') || (mime_content_type($_FILES['avatar']['tmp_name'])=='image/gif')) {
                // проверка на формат пройдена
                $fileto = "img/users/user".get_next_id('users').".".strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // даем файлу на сервер такое же имя, каким будет id, и прежнее расширение
                move_uploaded_file($file['tmp_name'], $fileto);               
            } else {
                // неподходящий формат!
                $form_errors['file'] = 'Для аватара принимаются изображения формата .JPG, .PNG или .GIF!';
            }
        }
    }
    if (empty($form_errors)) { // если уже НИКАКИХ ошибок нет - регистрация
        if ($file['name']=="") $fileto = ""; // если файла не было, пустая переменная для аватара
        // записываем пользователя в базу
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);// хэш пароля
        $sql = "INSERT INTO users SET id = NULL, date_register = NOW(), email = ?, username = ?, password = ?, avatar_path = ?, contacts = ?;";
        $insert = $database->insertData($sql, [$_POST['email'], $_POST['name'], $password_hash, $fileto, $_POST['message']]);
        if ($insert) { // если добавлено успешно
            session_start();
            $_SESSION['user'] = ['new' => true]; // метка о новом пользователе пишется в сессию
            header("Location: /login.php");
            exit(); // сценарий закончен: регистрация успешна, перешли на логин с приветствием новому пользователю
        } else { // если ошибка базы
            $form_errors['mysql'] = "Ошибка добавления в базу данных! Пожалуйста, обратитесь в службу поддержки.";
        }
    }
}

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?php
connect_code('templates/header.php', ''); // хедер для неавторизованного, ведь авторизованный на регистрацию не должен придти?

$sql = "SELECT * FROM categories ORDER BY id ASC;";
$categories = $database->selectData($sql, '');

$form_olddata = [
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'name' => $_POST['name'],
    'message' => $_POST['message']
]; // и здесь загруженный аватар всё-таки?

connect_code('templates/main_sign-up_form.php', [$categories, $form_errors, $form_olddata]);

connect_code('templates/footer.php', $categories); 
?>
</body>
</html>