<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="./">Back</a>
<form method="POST">
        <img src="./_uploads/<?= $photo['user_id'] .'/'. $photo['file_name'] ?>" />
        <input type="text" name="title" value="<?= $photo['title'] ?>" />
        <textarea name='description'><?= $photo['description'] ?></textarea>
        <select name="status">
            <option value="0" <?= ($photo['status'] == 0 ? 'selected' : null ) ?> >Hide</option>
            <option value="1" <?= ($photo['status'] == 1 ? 'selected' : null ) ?> >Show</option>
        </select>
        <select name="is_commentable" >
            <option value="0" <?= ($photo['is_commentable'] == 0 ? 'selected' : null ) ?> >Comment disable</option>
            <option value="1" <?= ($photo['is_commentable'] == 1 ? 'selected' : null ) ?> >Comment available</option>
        </select>
        <input type="submit" name="update_photo"/>
    </form>

</body>
</html>