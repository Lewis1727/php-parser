<?php
$target_dir = "files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if (file_exists($target_file)) unlink($target_file);
// {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

if($imageFileType != "docx" && $imageFileType != "doc") {
  echo "Sorry, only DOCX, DOC files are allowed.";
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { 
    
    $zip = new ZipArchive;
    if ($zip->open($target_file ) === TRUE) {
      $zip->extractTo('files/zip/');
      $zip->close();
    }


    $conn = mysqli_connect("localhost", "daniel", "!Monopolist1344", "webbylab");

    

    $result = file_get_contents('http://webby.localhost/files/zip/word/document.xml');
    
        $xml = simplexml_load_string($result,null, 0, 'w', true);
        
        // print_r($xml);
    
        $body = $xml->body;
        $q=0;
        foreach($body[0] as $key => $value){
            echo "<p>";
            if($key == "p"){
                foreach ($value->r as $kkey => $vvalue) {
                    if (strpos((string)$vvalue->t, 'Title') !== false) {
                        // echo (string)$vvalue->t;
                        $title=((string)$vvalue->t);
                        $title = str_replace("Title: ","",$title);
                        echo $title;
                    }
                    if (strpos((string)$vvalue->t, 'Release') !== false) {
                        // echo (string)$vvalue->t;
                        $year=((string)$vvalue->t);
                        $year = str_replace("Release Year: ","",$year);
                    }
                    if (strpos((string)$vvalue->t, 'Format') !== false) {
                        // echo (string)$vvalue->t;
                        $format=((string)$vvalue->t);
                        $format = str_replace("Format: ","",$format);
                    }
                    if (strpos((string)$vvalue->t, 'Stars') !== false) {
                        // echo (string)$vvalue->t;
                        $actors=((string)$vvalue->t);
                        $actors = str_replace("Stars: ","",$actors);
    
                        $query = "INSERT INTO `films` (`name`, `year`, `format`, `actors`) VALUES ('$title', '$year', '$format', '$actors')";
                        // echo "<br>";
                        // var_dump($query);
                        // echo "<br>";
                        mysqli_query($conn, $query);
                        // printf("error: %s\n", mysqli_error($conn));
    
                    }
                }
            }
            echo "</p>";
        }

   

    header("location: index.php");
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>