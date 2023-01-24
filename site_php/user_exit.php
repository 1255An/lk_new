<?php
if(!defined('allow_access_to_this_script')) die();

unset($_SESSION['front_user']);
unset($_SESSION['front_password']);
header('Location: /');
die();

?>

