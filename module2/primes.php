<?php


function view($a){
    if(!is_numeric($a)) return "Леееее";
    if($a < 0) return "Леееее";
    $res = '';
        for ($i = 2;$i <= $a; $i++) {
            if($i % 2 == 0) continue;
            if(prime($i)){
                $res .=' '.$i;
            }
                
                }
            return $res;
        }
function prime($n) : bool {
    for ($i = 2; $i < $n; $i++){
        if($n % $i == 0) return false;
    }
    return true;
}

    if(isset($_POST['le'])){
    $a = $_POST['first'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="POST">
    <input type="number" name="first">
    <input type="submit" name="le">
    </form>
    <?php
        if(isset($_POST['le'])){
            echo view($a);
        }
    ?>
</body>
</html>