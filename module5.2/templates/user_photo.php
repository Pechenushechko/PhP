<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Photos of <?= $user_email ?></h1>
    <div>
        <a href='./?sector=users_list'>Users List</a>
    </div>

    <div class='photos__list'>
        <?php while( $photo = mysqli_fetch_assoc($photos_sql)){ ?>
            <?php $photo_src = './_uploads/'.$photo['user_id'].'/'.$photo['file_name']; ?>
            <a href="./?sector=user_photo_view&slug=<?= $photo['slug'] ?>">
            <div class='single__photo <?= ($photo['status'] == 0 ? 'hidden' : null) ?>'>
                <div class='img' style='background-image: url(<?= $photo_src ?>)' ></div>
                <div class="title"><?= $photo['title'] ?></div>
            </div>    
            </a>    
        <?php } ?>
    </div>


    <div>
        <a href='./?logout'>Logout</a>
    </div>

</body>
</html>