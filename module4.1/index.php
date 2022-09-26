<?php

session_start();

$locale = 'KZ';
if(isset($_COOKIE['locale'])) $locale = $_COOKIE['locale'];

if(isset($_GET['locale'])) {
    setcookie('locale', $_GET['locale']);
    header('Location: ./');
    exit;
}

$STRINGS = [
    'KZ' => [
        'login' => 'Киру',
        'email' => 'епошта',
        'password' => 'купия соз',
        'remember_me' => 'епоштамды сактар кой'
    ],
    'RU' => [
        'login' => 'Вход',
        'email' => 'Э-почта',
        'password' => 'Пароль',
        'remember_me' => 'Запомнить меня'
    ]
];



if(isset($_SESSION['uid']) &&  $_SESSION['uid'] > 0){

    if(isset($_GET['logout'])){
        session_destroy();

        header('Location: ./');
        exit();
    }

    if(isset($_GET['sector']) && $_GET['sector'] == 'open_file') {
    $file = $_GET['file'];
    $file_content = file_get_contents($file);

    if(isset($_POST['save_file'])){

        $file_new_content = $_POST['file_content'];
        file_put_contents($file, $file_new_content);

        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();

    }
    include_once('./templates/file_open.php');

}
else{

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

    function get_file_extension($file_name){
        $file_name_components = explode('.', $file_name);
        return array_pop($file_name_components);
    }

    if(isset($_POST['upload'])){

     $upload_images_count = count($_FILES['user_image']['name']);

    for($i = 0; $i < $upload_images_count; $i++ ){
        $uf_name = $_FILES['user_image']['name'][$i];
        $new_name = random_string(12);
        $type = $_FILES['user_image']['type'][$i];
        $tmp_name = $_FILES['user_image']['tmp_name'][$i];
        $file_extension =  get_file_extension($uf_name);

        $allowed_types = ['image/jpeg', 'image/png'];
        $black_list = ['application/octet-stream', 'text/x-python'];

    if(in_array($type, $allowed_types)){
    move_uploaded_file($tmp_name, './uploads/'.$new_name .'.' .$file_extension);
    }
    if(in_array($type, $black_list)){

    }
    }

    
    header('Location: ./');
    exit;
    }

    include_once('./templates/file_upload.php');
}
}
else{

    if(isset($_POST['login'])){
        $email =  filter_var(strip_tags($_POST['email']), FILTER_VALIDATE_EMAIL);
        $password = strip_tags($_POST['password']);
        

        if(isset($_POST['remember_me'])){
            setcookie('last_email', $email);
        }

        if($email == 'asd@mail.com' && $password == 'asd123'){
            $_SESSION['uid'] = 1;
        }
        header('Location: ./');
        exit();
    }

    $last_email = '';
    if(isset($_COOKIE['last_email'])) $last_email = $_COOKIE['last_email'];

    include_once('./templates/login.php');
}



// $dir = './uploads/';

// if (is_dir($dir)) {
//     if ($dh = opendir($dir)) {
//         while (($file = readdir($dh)) !== false) {
//             echo "файл: $file : тип: " . filetype($dir . $file) . ' size: ' . filesize($dir . $file) ."</br>";
//         }
//         closedir($dh);
//     }
// }

?>