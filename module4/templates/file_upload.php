<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="user_image">
        <input type="submit" name="upload">
    </form>
    <?php
        $dir = './uploads/';

        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file != '.' && $file != '..' ){
                        switch(get_file_extension($dir.$file)){
                            case "jpg":
                                echo "<img src='".$dir.$file."' style='height: 120px'/>";
                                break;
                            case "png":
                                echo "<img src='".$dir.$file."' style='height: 120px'/>";
                                break;
                            case "txt":
                                echo "<a href='./?sector=open_file&file=".$dir.$file."'>";
                                echo "<img src='https://img.icons8.com/ios-glyphs/344/txt.png' style='height: 60px' />";
                                echo "</a>";
                                break;
                        }
                        
                    }
                }
                closedir($dh);
            }
        }
    ?>
</body>
</html>