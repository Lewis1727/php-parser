<?php 
$appConfig = require __DIR__ . '/../config/config.php';

$routeAction = $_SERVER["REQUEST_URI"];
if (isset($_GET['action'])) {
    $routeAction = $_GET['action'];
}

switch ($routeAction) {

    case 'list':
        default:
            $controllerName = 'FilmController';
            $action = 'indexAction';
            break;

    case 'newfilm':
        $controllerName = 'FilmController';
        $action = 'newfilmAction';
        break;

    case 'newfilmsubmitted':
        $controllerName = 'FilmController';
        $action = 'newfilmsubmittedAction';
        break;

    case 'findfilm':
        $controllerName = 'FilmController';
        $action = 'findfilmAction';
        break;

    case 'delete':
        $controllerName = 'FilmController';
        $action = 'deleteAction';
        break;



}

require '../main/Controller/MainController.php';
require '../main/Controller/' . $controllerName . '.php';
require '../main/Model/DbConnectionManager.php';
require '../main/Model/FilmManager.php';
require '../main/View/FilmView.php';

$db = new DbConnectionManager($appConfig);
$dbConnection = null;
if ($db) {
    $dbConnection = $db->getConnection();
}
$filmManager = new FilmManager($dbConnection);

$controller = new $controllerName($filmManager);
$controller->{$action}($_REQUEST);




// TEXT PARSER //
// $conn = mysqli_connect("", "", "", "");

// $fp = fopen('movies.txt', 'r');

// while (($line = fgets($fp, 4096)) !== false ) {

//     if(strpos($line, 'Title') !== false){
//         $title = str_replace("Title: ","",$line);
//     }

//     if(strpos($line, 'Release') !== false){
//         $year = str_replace("Release Year: ","",$line);
//     }

//     if(strpos($line, 'Format') !== false){
//         $format = str_replace("Format: ","",$line);
//     }

//     if(strpos($line, 'Stars') !== false){
//         $actors = str_replace("Stars: ","",$line);
//         $query = "INSERT INTO `films` (`name`, `year`, `format`, `actors`) VALUES ('$title', '$year', '$format', '$actors')";
//         mysqli_query($conn, $query);
//     }
// }




// DOCX  PARSER //

// $conn = mysqli_connect("", "", "", "");
// $result = file_get_contents('http://webby.localhost/files/zip/word/document.xml');
// $xml = simplexml_load_string($result,null, 0, 'w', true);
//         $body = $xml->body;
//         $q=0;
//         foreach($body[0] as $key => $value){
//             echo "<p>";
//             if($key == "p"){
//                 foreach ($value->r as $kkey => $vvalue) {
//                     if (strpos((string)$vvalue->t, 'Title') !== false) {
//                         $title=((string)$vvalue->t);
//                         $title = str_replace("Title: ","",$title);
//                         echo $title;
//                     }
//                     if (strpos((string)$vvalue->t, 'Release') !== false) {
//                         // echo (string)$vvalue->t;
//                         $year=((string)$vvalue->t);
//                         $year = str_replace("Release Year: ","",$year);
//                     }
//                     if (strpos((string)$vvalue->t, 'Format') !== false) {
//                         $format=((string)$vvalue->t);
//                         $format = str_replace("Format: ","",$format);
//                     }
//                     if (strpos((string)$vvalue->t, 'Stars') !== false) {
//                         $actors=((string)$vvalue->t);
//                         $actors = str_replace("Stars: ","",$actors);
//                         $query = "INSERT INTO `films` (`name`, `year`, `format`, `actors`) VALUES ('$title', '$year', '$format', '$actors')";
//                         mysqli_query($conn, $query); 
//                     }
//                 }
//             }
//             echo "</p>";
//         }