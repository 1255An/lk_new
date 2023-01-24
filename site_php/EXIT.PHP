<?php

if(!defined('allow_access_to_this_script')){die();}

unset($_SESSION['login_user']);
unset($_SESSION['page']);

header('Location:ADMIN.PHP?'.time());


?>