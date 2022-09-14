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
        <input type="text" name="user">
        <input type="password" name="password">
        <input type="submit">
    </form>

    <?php
        // var_dump($_GET);
        // echo "<br/>";
        if(isset ($_POST['user'])){
            $user = $_POST['user'];
            $password = $_POST['password'];
            if($user == 'ad' && $password == 'ad'){
            echo "Hello, ". $user;
            }
            else{
                echo "HAHA";
            }
        }
    ?>
</body>
</html>