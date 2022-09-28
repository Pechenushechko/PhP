<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .photos__list{display: flex; flex-direction: row;}
        .single__photo{display: flex; flex-direction: column; align-items: center; padding: 10px; }
        .single__photo .img{border-radius: 20px; height: 200px; width: 150px; background-position: center; background-repeat: no-repeat; background-size: contain;}
        .single__photo .title{}
    </style>



</head>
<body>
    <h1> Hello there <?= $_SESSION['uid'] ?></h1>
    
    <div>
        <a href="./?sector=upload">upload</a>
    </div>

    <div>
        <a href="./?logout">logout</a>
    </div>

    <div>
        <a href="./?sector=users_list">Users</a>
    </div>
 
    <div class='photos__list'>
        <?php while( $photo = mysqli_fetch_assoc($photos_sql)){ ?>
            <?php $photo_src = './_uploads/'.$user_id.'/'.$photo['file_name']; ?>
        <a href="./?sector=photo_edit&slug=<?= $photo['slug'] ?>">
            <div class='single__photo'>
                <img src='<?= $photo_src ?>'/>
                <div class="title"><?= $photo['title'] ?></div>
            </div>
        </a>
        <?php } ?>
    </div>


        
    </div>
</body>
</html>