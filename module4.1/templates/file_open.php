<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div>
        <form method='post'>
            <textarea name='file_content' style='height: 350px; width: 350px'><?= $file_content ?></textarea>
            <br/>
            <input type="submit" name="save_file" />        
        </form>
    </div>

</body>
</html>