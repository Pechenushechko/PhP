<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Users photo</h1>
    <div>
        <img src="./_uploads/<?= $photo['user_id'] .'/'. $photo['file_name'] ?>" style='height: 240px' />
    </div>
    <div>
        <?= $photo['title'] ?>
    </div>
    <div>
        <?= $photo['description'] ?>
    </div>
    <?php if($photo['is_commentable'] == 1) { ?>
    <form method="POST">
        <h2>Оставьте свой комментарий</h2>
        <div>
            <textarea name='body'></textarea>
        </div>
        <div>
            <input type='submit' name="create_comment" />
        </div>
    </form>
    <?php }?>
    <div>
        <h2>Комментарии</h2>
        <?php
            if( mysqli_num_rows($comments_sql) > 0 ){
                while($comment = mysqli_fetch_assoc($comments_sql)){
                    echo "<div>";
                    echo "<div>" .$comment['body'] ."</div>";
                    echo "<div>" .$comment['created_at'] ."</div>";
                    echo "</div>";
                }
            } else {
                echo "<div><i>Комментариев к фото пока нет</i></div>";
            }
        ?>
    </div>

</body>


</body>
</html>