<?php

ob_start();
session_start();

require_once('./functions.php');

$_SESSION['loggedin'] = false;


// Define database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'And1234h');
define('DB_NAME', 'blog');

// Create database connection
$con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$con->setAttribute(PDO::ATTR_PERSISTENT, true);


// Automatically load classes
function __autoload($class){
    $class = strtolower($class);
    
    $classpath = 'classes/class.' .$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    
    $classpath ='../classes/class.' .$class . '.php';
    if (file_exists($classpath)) {
        require_once $classpath;
    }
    
    
     $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }   
}


// Initialize new user object
$user = new User($con);
$post = new Post($con);
$comment = new Comment($con);



?>

