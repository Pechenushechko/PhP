<?php

session_start();

include_once('./_php/db_con.php');
include_once('./_assets/strings.php');

$locale = "RU";

if(isset($_SESSION['uid']) && $_SESSION['uid'] > 0){


}
else{

    if(isset($_GET['sector'])  && $_GET['sector'] == 'register'){

        if(isset($_POST['register'])){
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = md5($_POST['password']);
            $password2 = md5($_POST['password2']);

            if($password != $password2){
                $_SESSION['errors']['registration'] = "Passwords doesnt match";
            }
            else{
                $user_sql = mysqli_query($con, "SELECT `id` FROM `users` WHERE `email` = '".$email."' LIMIT 1");
                if(mysqli_num_rows($user_sql) == 1){
                    $_SESSION['errors']['registration'] = "User already registed";
                }
                else{
                    mysqli_query($con, "INSERT INTO `users` (`email`,`password`) VALUES ('".$email."', '".$password."')");
                }
            }

            

            header('Location:./?sector=register');
            exit;
        }

        include_once('./templates/register.php');
    }
    else{
    if(isset($_POST['login'])){
        $email =  filter_var(strip_tags($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = md5(strip_tags($_POST['password']));
        

        if(isset($_POST['remember_me'])){
            setcookie('last_email', $email);
        }

        $user_sql = mysqli_query($con, "SELECT `id` FROM `users` WHERE `email` = '".$email."' AND `password` = '".$password."' LIMIT 1");

        if(mysqli_num_rows($user_sql) == 1){
            die('User found');
        }
        else{
            die('User not found');
        }
        header('Location: ./');
        exit();
    }

    $last_email = '';
    if(isset($_COOKIE['last_email'])) $last_email = $_COOKIE['last_email'];

    include_once('./templates/login.php'); 
    }
}
?>