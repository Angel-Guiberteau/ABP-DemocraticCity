<?php
$pas = 'aaa';
    $p = password_hash($pas, PASSWORD_DEFAULT);
    echo '<h1>Contraseña</h1>';
    print_r($p);
?>