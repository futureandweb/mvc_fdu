<?php
require_once 'app/config/config.php';
require_once 'app/model/UserModel.php';
require_once 'app/controller/AuthController.php';
require_once 'app/DatabaseSetup.php'; // Inclure la classe DatabaseSetup

session_start();
$routes = require_once 'app/config/routes.php';

try {
 
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $databaseSetup = new DatabaseSetup($db);
    $databaseSetup->createDatabaseAndTable();

    $userModel = new UserModel($db);
    $authController = new AuthController($userModel);

 // Récupérer la page demandée à partir de l'URL
 $page = isset($_GET['page']) ? $_GET['page'] : 'home';
 var_dump($page);
 // Vérifier si la page demandée existe dans les routes
 if (array_key_exists($page, $routes)) {
     $action = $routes[$page];
     list($controllerName, $methodName) = explode('@', $action);

     // Construire le nom de la classe du contrôleur
     $controllerClass = $controllerName ;
     var_dump($controllerClass);
     // Vérifier si la classe du contrôleur existe
     if (class_exists($controllerClass)) {
         $controller = new $controllerClass($userModel);

         // Vérifier si la méthode du contrôleur existe
         if (method_exists($controller, $methodName)) {
             // Appeler la méthode du contrôleur
             $controller->$methodName();
         } else {
             echo "Méthode du contrôleur non trouvée.";
         }
     } else {
         echo "Classe du contrôleur non trouvée.";
     }
 } else {
     echo "Route non trouvée.";
 }
} catch (PDOException $e) {
 echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
