<?php

require_once('./includes/config.php');


  //  $post->deletePost($_GET['id']);
 //    header('Location: admin-post-view.php');

$stmt = '';
$destination = '';


   switch($_GET['what']) { // user post or comment
       case 'user':
           $stmt = 'DELETE FROM users WHERE userID =' .$_GET['id'];
           
           switch($_GET['who']) { // user admin
               case 'user':
                    $destination = 'user-view.php';
                    break;

               case 'admin':
                   $destination = 'admin-user-view-php';
                    break;
               } 
           
           break;
           
       case 'post':
           $stmt = 'DELETE FROM posts WHERE postID =' .$_GET['id'];
           
           switch($_GET['who']) { // user admin
               case 'user':
                    $destination = 'post-view.php';
                    break;

               case 'admin':
                   $destination = 'admin-post-view-php';
                    break;
           }
           
           break;
           
       case 'comment':
           $stmt = 'DELETE FROM users WHERE userID =' .$_GET['id'];
           
           switch($_GET['who']) { // user admin
               case 'user':
                    $destination = 'post-view.php';
                    break;

               case 'admin':
                   $destination = 'admin-comment-view-php';
                    break;
           }
   }    



    echo '<br> do what: ' . $stmt;
    echo '<br> go where: ' header("Location: ")  . $destination;


?>


