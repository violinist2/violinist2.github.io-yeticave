<?php
session_start();
require_once 'classes/Authorization.php';
$auth = new Authorization;
$auth->finishAuthorization();
header("Location: /");
?>