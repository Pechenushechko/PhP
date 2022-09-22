<?php

//echo "Hello I am text from: index" ."</br>";

//$file_content = file_get_contents('./file.txt');

// file_put_contents($file_path, $content);

// echo $file_content;

//copy('./file.txt', './uploads/file_' .time() .'.txt');
// if(!is_dir($dir.'images')) mkdir($dir.'images');
// // chown($dir.'images', 'gtrf');
// // chmod($dir.'images', 0600);
// echo fileowner($dir.'images') .'</br>';
// //copy('./file.txt', './uploads/images/file_' .time() .'.txt');

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
    $uf_name = $_FILES['user_image']['name'];
    $new_name = random_string(12);
    $type = $_FILES['user_image']['type'];
    $tmp_name = $_FILES['user_image']['tmp_name'];
    $file_extension =  get_file_extension($uf_name);

    $allowed_types = ['image/jpeg', 'image/png'];

    if(in_array($type, $allowed_types)){
    move_uploaded_file($tmp_name, './uploads/'.$new_name .'.' .$file_extension);
    }
    else{
        echo "U can only upload images.jpg";
        exit;
    }
    header('Location: ./');
    exit;
    }

    include_once('./templates/file_upload.php');
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