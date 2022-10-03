<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Users</h1>
    <a href="./">Back</a>

    <ol>
    <?php while ($single_user = mysqli_fetch_assoc($users_sql)){ ?>
        <li><a href="./?sector=user_photo&email=<?= $single_user['email']?>"><?= $single_user['email'] ?></a></li>

    <?php } ?>
    </ol>
</body>
</html>