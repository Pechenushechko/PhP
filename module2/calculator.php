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

    if(isset($_POST['submit'])){
    $number1 = $_POST['number1'];
    $number2 = $_POST['number2'];
    $operation = $_POST['operation'];
    
    switch($operation){ 
        case 'plus': 
            $result = $number1 + $number2; 
            break;
        case 'minus': 
            $result = $number1 - $number2;  
            break;
        case 'multiply': 
            $result = $number1 * $number2;
            break;
        case 'divide': 
            $result = $number1 / $number2; 
            break;    
        }
        
    }
        
    // function calculate($n1, $n2, $op){

    // }
    

    ?>

    <form method="POST">
    
    <input type="text" name="number1"  placeholder="Первое число"> 
    <input type="text" name="number2"  placeholder="Второе число"> 
    <select  name="operation"> 
    <option value='plus'>+ </option>
    <option value='minus'>- </option>
    <option value="multiply">* </option>
    <option value="divide">/ </option>
    </select>     

    <input  type="submit" name="submit" value="Получить ответ"> 
    </form>

    <?php
    echo "Ответ: $result";
    ?>
    
</body>
</html>