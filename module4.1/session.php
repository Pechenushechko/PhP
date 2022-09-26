<?php

session_start();

if(isset($_SESSION['uid']) && $_SESSION['uid'] > 0){
    var_dump($_SESSION);
}
else{
    echo 'Login please';

    header("Location: ./");
    exit;
}

