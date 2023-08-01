<?php

function load_users_data($user_ids) {
    $db = mysqli_connect("localhost", "root", "gazeta123", "test");
    // ----- базу открываем и закрываем вне цикла, это требует ресурс
    $result = [];
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
//        $db = mysqli_connect("localhost", "root", "gazeta123", "test");
        $sql = mysqli_query($db, "SELECT id, name FROM users WHERE id = $user_id");
        // ----- SELECT * - плохой запрос! нужно селектить только те колонки которые нужны нам
//        while($obj = $sql->fetch_object()){
//            $data[$user_id] = $obj->name;
//        }
        // ----- не надо делать из id ключь в массиве, порядок может меняться, всегда лучше венуть associate для ясности использования в будещем
        $result[] = $sql->fetch_assoc();
//        mysqli_close($db);
    }
    mysqli_close($db);
    return $result;
}

// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data('1,2,3,4');

foreach ($data as $user) {
    echo "<a href=\"/show_user.php?id=$user[id]\">$user[name]</a>" . "\n";
}