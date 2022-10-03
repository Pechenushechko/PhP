<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        h1{padding-left: 10px}

        form{ flex-direction: 'column'; align-items: 'center'}
        form div{ padding: 10px}
        input[type=email]{padding: 5px 10px; border: none; border-bottom: 1px solid black;}
        input[type=email]:invalid{background-color: red;}
        input[type=password]{padding: 5px 10px;border: none; border-bottom: 1px solid black; }
        input[type=submit]{padding: 5px 10px}
        select{padding: 5px 10px}
    </style>

</head>
<body>
    <h1><?= $STRINGS[$locale]['login'] ?></h1>
    <?php 
        if(isset($_SESSION['errors']['auth'])){
            echo "<div style='padding: 15px;'>" .$_SESSION['errors']['auth'] ."</div>";

            unset($_SESSION['errors']['auth']);
        }
    ?>
    <form method="POST">
        <div><input type="email" name="email" required placeholder="<?= $STRINGS[$locale]['email'] ?>" value="<?= $last_email ?>"></div>
        <div>
            <input type="checkbox" name="remember_me" ><?= $STRINGS[$locale]['remember_me'] ?>
        </div>
        <div><input type="password" name="password" required placeholder="<?= $STRINGS[$locale]['password'] ?>"></div>
        <div><input type="submit" name="login"></div>
    </form>
    <div style="padding: 15px;">
        <a href="./?sector=register">Registration</a>
    </div>
    <?php 
    if($locale == "KZ"){echo"<a href='./?locale=RU'>RU</a>" ;} 
    if($locale == "RU"){echo"<a href='./?locale=KZ'>KZ</a>" ;}
    ?>
</body>
</html>