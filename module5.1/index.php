<?php

session_start();

include_once('./_php/db_con.php');
include_once('./_assets/strings.php');

$locale = "RU";

if(isset($_SESSION['uid']) && $_SESSION['uid'] > 0){

    $user_id =& $_SESSION['uid'];

    if(isset($_GET['logout'])){
        session_destroy();

        header('Location: ./');
        exit();
    }

    if(isset($_GET['sector']) && $_GET['sector'] == 'user_photo') {
        $user_email = $_GET['email'];
        $selected_user_sql = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '".$user_email."' LIMIT 1");
        $selected_user = mysqli_fetch_assoc($selected_user_sql); 

        $photos_sql = mysqli_query($con, "SELECT * FROM `photos` WHERE `user_id` = '".$selected_user['id']."' AND `status` = 1");

        include_once('./templates/user_photo.php');
    }

    elseif(isset($_GET['sector']) && $_GET['sector'] == 'users_list'){
        $users_sql = mysqli_query($con, "SELECT * FROM `users` ");

        include_once('./templates/users_list.php');

    }
    
    elseif(isset($_GET['sector']) && $_GET['sector'] == 'photo_edit'){
        $photo_slug = $_GET['slug'];
        $photos_sql = mysqli_query($con, "SELECT * FROM `photos` WHERE `slug` = '".$photo_slug."'");

        if(mysqli_num_rows($photos_sql) == 1){
            
            if(isset($_POST['update_photo'])){
                $title       = $_POST['title'];
                $description = $_POST['description'];
                $status      = $_POST['status'];

                mysqli_query($con, "UPDATE `photos` 
                                    SET `title`='".$title."', 
                                        `description`='".$description."', 
                                        `status`='".$status."' 
                                    WHERE `slug`='".$photo_slug."'");

                header('Location: ./');
                exit();
            }


            $photo = mysqli_fetch_assoc($photos_sql);
             include_once('./templates/photo_edit.php');
        }
        else{
            echo "error 404";
        }
    }

    elseif(isset($_GET['sector']) && $_GET['sector'] = 'upload'){
        include_once('./templates/file_upload.php');
    }
    else{
       
        $photos_sql = mysqli_query($con, "SELECT * FROM `photos` WHERE `user_id` = '".$user_id."'");
        include_once('./templates/cabinet.php');
    }

    function random_string( $length, $offset = 'all' ) : string
    {
        $symbols = array("=","+","_","-","%","$","@");
        $string = '';

        switch($offset){
            case 'lo':
                $charachters = array_merge(range("a","z"), range("A", "Z"));
                break;
            case 'ln':
                $charachters = array_merge(range("a","z"), range("A", "Z"), range(0,9));
                break;
            default:
                $charachters = array_merge(range("a","z"), range("A", "Z"), range(0,9), $symbols);
                break;
            }
        for($i = 0; $i < $length; $i++){
            shuffle($charachters);
             $string .= $charachters[$i];
        }

        return $string;
    }

    function get_file_extension ($file_name) {
        $file_name_components = explode('.', $file_name);
        return array_pop($file_name_components);
    }

    if(isset($_POST['upload'])){

        $upload_images_count = count($_FILES['user_image']['name']);
   
       for($i = 0; $i < $upload_images_count; $i++ ){
           $uf_name = strip_tags($_FILES['user_image']['name'][$i]);
           $new_name = random_string(12);
           $type = $_FILES['user_image']['type'][$i];
           $tmp_name = $_FILES['user_image']['tmp_name'][$i];
           $file_extension =  get_file_extension($uf_name);
            $slug = random_string(8, 'ln');

           
           $allowed_types = ['image/jpeg', 'image/png'];
           $black_list = ['application/octet-stream', 'text/x-python'];

           $user_dir = './_uploads/'.$user_id.'/';
           $file_name = $new_name .'.' .$file_extension;
            if(!is_dir($user_dir)){ mkdir($user_dir); }

   
       if(in_array($type, $allowed_types)){
            if(move_uploaded_file($tmp_name, $user_dir . $file_name)){
                mysqli_query($con, "INSERT INTO `photos` (`slug`,`user_id`,`file_name`,`title`) VALUES ('".$slug."','".$user_id."', '".$file_name."', '".$uf_name."')");
            }
       }
       if(in_array($type, $black_list)){
   
       }
       }
   
       
       header('Location: ./');
       exit;
       }
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
                    if( mysqli_query($con, "INSERT INTO `users` (`email`,`password`) VALUES ('".$email."', '".$password."')")){
                        $new_user_id = mysqli_insert_id($con);

                        $_SESSION['uid'] = $new_user_id;
                    }
                   
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

            $user = mysqli_fetch_assoc($user_sql);

            $_SESSION['uid'] = $user['id'];
        }
        else{
            $_SESSION['errors']['auth'] = "User not found";
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