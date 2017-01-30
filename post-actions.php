<?php require_once('./includes/header.php'); ?>



<?php
    
    $what = $_GET['what'];  // posts, comments, users
    $who = $_GET['who'];   // admin or user
    $how = $_GET['how'];   // update, delete or disable
    $where = $_GET['id']; // id value

    echo '<br>' . $what;
    echo '<br>' . $who;
    echo '<br>' . $how;
    echo '<br>' . $where;

    switch($what){
        case 'post':
            
            break;
            
        case 'comment':
            
            break;
            
        case 'user':
            
            break;
    }
    
?>





<?php  require_once('./includes/footer.php');?>