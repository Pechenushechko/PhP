<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    function valve($h, $w, $l, $lit){
        $v = $h * $w * $l;
        return $time = 60 * ($v / $lit); 
    }
    if(isset($_POST['calc'])){
        $h = $_POST['height'];
        $w = $_POST['widght'];
        $l = $_POST['lenght'];
        $lit = $_POST['liter'];
    }
    ?>
    <form method="POST">
        <input type="number" name="height" placeholder="height">
        <input type="number" name="widght" placeholder="widght">
        <input type="number " name="lenght" placeholder="lenght">
        <input type="number" name="liter" placeholder="liter">
        <input type="submit" name= "calc">
    </form>
    <?php
    if(isset($_POST['calc'])){
        echo valve($h, $w, $l, $lit);
    }
    ?>
</body>
</html>