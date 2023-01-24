<?php
//привет
// Проверка было ли подтверждение регистрации

require_once 'db.php';

// Проверка есть ли хеш
if ($_GET['id, hash']) {
    global $db;
    $id = $_GET['id'];
    $hash = $_GET['hash'];
    $user = selectOne('users', ['id' => $id]);
    $isConfirmed = $user['login_confirmed'];

    if (!$isConfirmed) {
        update('users', $id, ['login_confirmed' == true]);
    }

    // Надо добавить проверки
}
