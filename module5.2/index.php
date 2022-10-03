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
    
    elseif(isset($_GET['sector']) && $_GET['sector'] == 'user_photo_view'){
        $photo_slug = $_GET['slug'];

        $photo_sql = mysqli_query($con, "SELECT * FROM `photos` WHERE `slug` = '".$photo_slug."' LIMIT 1");
        $photo = mysqli_fetch_assoc($photo_sql);

        if(isset($_POST["create_comment"])){
            $body = $_POST['body'];
            $photo_id = $photo['id'];

            mysqli_query($con, "INSERT INTO `comments` (`body`,`photo_id`,`user_id`) VALUES ('".$body."', '".$photo_id."', '".$user_id."')");

            header('Location: ./?sector=user_photo_view&slug='.$photo_slug);
            exit();
        }

        $comments_sql = mysqli_query($con, "SELECT * FROM `comments` WHERE `photo_id` = '".$photo['id']."'");


        include_once('./templates/photo_view.php');
        exit();
    }

    elseif(isset($_GET['sector']) && $_GET['sector'] == 'users_list'){
        $users_sql = mysqli_query($con, "SELECT * FROM `users` ");

        include_once('./templates/users_list.php');

    }
    
    elseif(isset($_GET['sector']) && $_GET['sector'] == 'photo_edit'){
        $photo_slug = $_GET['slug'];
        $photos_sql = mysqli_query($con, "SELECT * FROM `photos` WHERE `slug` = '".$photo_slug."' AND `user_id` = '".$user_id."' LIMIT 1");


        if(mysqli_num_rows($photos_sql) == 1){
            
            if(isset($_POST['update_photo'])){
                $title       = $_POST['title'];
                $description = $_POST['description'];
                $status      = $_POST['status'];
                $is_comment = $_POST['is_commentable'];

                mysqli_query($con, "UPDATE `photos` 
                                    SET `title`='".$title."', 
                                        `description`='".$description."', 
                                        `status`='".$status."' 
                                        `is_commentable`='".$is_comment."' 
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

    function image_resize($image_path, $image_extension, $save_to = null ){
        $file_name = $image_path;
        $file_extension = strtolower($image_extension);

        list($width, $height) = getimagesize($file_name);

        $thumb_height = 250;
        $thumb_widght = 250;
        if($width > $height){
            $thumb_height = $height;
            $thumb_widght = $height;
        }
        elseif($width <= $height){
            $thumb_height = $width;
            $thumb_widght = $width;
        }

        $thumb = imagecreatetruecolor($thumb_widght, $thumb_height);

        if($file_extension == 'jpg' || $file_extension == 'jpeg'){
            $sourse = imagecreatefromjpeg($file_name);
        }
        if($width > $height){
            $start_x = ($width - $height) / 2;
            imagecopyresized($thumb, $sourse, 0 , 0 , $start_x, 0, $thumb_widght, $thumb_height, $height, $height);
        }

        imagejpeg($thumb, $save_to);

        imagedestroy($thumb);
        imagedestroy($sourse);
    }

    if(isset($_POST['upload'])){

        $upload_images_count = count($_FILES['user_image']['name']);
   
       for($i = 0; $i < $upload_images_count; $i++ ){
           $uf_name = strip_tags($_FILES['user_image']['name'][$i]);
           $new_name = random_string(12, "ln");
           $type = $_FILES['user_image']['type'][$i];
           $tmp_name = $_FILES['user_image']['tmp_name'][$i];
           $file_extension =  get_file_extension($uf_name);
            $slug = random_string(8, 'ln');

           
           $allowed_types = ['image/jpeg', 'image/png'];
           $black_list = ['application/octet-stream', 'text/x-python'];

           $user_dir = './_uploads/'.$user_id.'/';
           $file_name = $new_name .'.' .$file_extension;
           $thumb_name = $new_name .'_thumb.' .$file_extension;
            if(!is_dir($user_dir)){ mkdir($user_dir); }

   
       if(in_array($type, $allowed_types)){
            
            if(move_uploaded_file($tmp_name, $user_dir . $file_name)){

                image_resize($user_dir . $file_name, $file_ext, $user_dir . $thumb_name);

                mysqli_query($con, "INSERT INTO `photos` (`slug`,`user_id`,`file_name`,`thumb_url` ,`title`) VALUES 
                ('".$slug."','".$user_id."', '".$file_name."','".$thumb_name."' ,'".$uf_name."')");
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