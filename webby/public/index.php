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



// $conn = mysqli_connect("localhost", "daniel", "!Monopolist1344", "webbylab");

// $result = file_get_contents('http://webby.localhost/files/zip/word/document.xml');

//     $xml = simplexml_load_string($result,null, 0, 'w', true);
    
//     // print_r($xml);

//     $body = $xml->body;
//     $q=0;
//     foreach($body[0] as $key => $value){
//         echo "<p>";
//         if($key == "p"){
//             foreach ($value->r as $kkey => $vvalue) {
//                 if (strpos((string)$vvalue->t, 'Title') !== false) {
//                     echo (string)$vvalue->t;
//                     $title=((string)$vvalue->t);
//                 }
//                 if (strpos((string)$vvalue->t, 'Release') !== false) {
//                     echo (string)$vvalue->t;
//                     $year=((string)$vvalue->t);
//                 }
//                 if (strpos((string)$vvalue->t, 'Format') !== false) {
//                     echo (string)$vvalue->t;
//                     $format=((string)$vvalue->t);
//                 }
//                 if (strpos((string)$vvalue->t, 'Stars') !== false) {
//                     echo (string)$vvalue->t;
//                     $actors=((string)$vvalue->t);

//                     $query = "INSERT INTO films (`name`, `year`, `format`, `actors`) 
//                                 VALUES ('$title', '$year', '$format', '$actors')";
//                     $result = mysqli_query($conn, $sql);

//                 }
//             }
//         }
//         echo "</p>";
//     }


