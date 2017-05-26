<?php

class Authorization {

    public function doAuthorize($email, $password) {
        $database = new Database;
        $sql = "SELECT id, username, password, avatar_path FROM users WHERE email = ? LIMIT 0,1;";
        $found_user = $database->selectData($sql, [$email]);
        if (!empty($found_user) and password_verify($password, $found_user[0][2])) { // пользователь найден, введенный пароль найденного пользователя совпадает с хэшем из базы
            $_SESSION['user'] = [  // в сессии будем хранить по-минимуму
                'auth_user_id' => $found_user[0][0],
                'auth_username' => $found_user[0][1],
                'auth_avatar_path' => $found_user[0][3]           
                ];
            return true;
        }
    }

    public function isAuthorized() {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public function finishAuthorization() {
        if ($this->isAuthorized()) {
            unset($_SESSION['user']);
        }
    }

    public function getUserdata() {
        if ($this->isAuthorized()) {
           foreach ($_SESSION['user'] as $key => $value) {
                $userdata[protect_code($key)] = protect_code($value);     
           }
           if ($userdata['auth_avatar_path']=='') $userdata['auth_avatar_path'] = 'img/default.jpg';
           return $userdata;
        }
    }    
}
?>