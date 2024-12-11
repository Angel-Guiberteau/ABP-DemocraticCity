<?php
$pas = 'admin';
    $p = password_hash($pas, PASSWORD_DEFAULT);
    echo '<h1>Contraseña</h1>';
    echo $pas;
    print_r($p);
?>