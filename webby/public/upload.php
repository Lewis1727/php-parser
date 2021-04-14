<?php
$target_dir = "files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$textFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not ok.";
      $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
  
if($textFileType != "txt") {
    echo "Sorry, only .txt files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { 

        $conn = mysqli_connect("localhost", "daniel", "!Monopolist1344", "webbylab");

        $fp = fopen('files/'.basename($_FILES["fileToUpload"]["name"]), 'r');

        while (($line = fgets($fp, 4096)) !== false ) {

            if(strpos($line, 'Title') !== false){
                $title = str_replace("Title: ","",$line);
            }

            if(strpos($line, 'Release') !== false){
                $year = str_replace("Release Year: ","",$line);
            }

            if(strpos($line, 'Format') !== false){
                $format = str_replace("Format: ","",$line);
            }

            if(strpos($line, 'Stars') !== false){
                $actors = str_replace("Stars: ","",$line);
                $query = "INSERT INTO `films` (`name`, `year`, `format`, `actors`) VALUES ('$title', '$year', '$format', '$actors')";
                mysqli_query($conn, $query);
            }
        }

        header("location: index.php");
        
    } else {
            echo "Sorry, there was an error uploading your file.";
    }
}