<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES["img"]["name"]) ){

    $allowTypes = array('jpg','png','jpeg','gif'); 

    $fileName = basename($_FILES["img"]["name"]);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    if(in_array($fileType, $allowTypes)){
        $image = $_FILES['img']['tmp_name'];
        // $imgContent = addslashes(file_get_contents($image));
        $img = imagecreatefromjpeg($image);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);

        $location = "./pic/nature.webp";
        imagewebp($img, $location, 1 );
        imagedestroy($img);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<body>
    <h1>image conversion</h1>
    <!-- <img class="w-25" src="./pic/shanto2.webp" alt=""> -->
    <form action="index.php" method="post" class="p-5" enctype="multipart/form-data">
        <label>Upload Image</label>
        <input name="img" id="img" class="form-control m-2 w-25 " type="file">
        <button type="submit" class="btn btn-warning btn-group btn">Submit</button>
    </form>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>