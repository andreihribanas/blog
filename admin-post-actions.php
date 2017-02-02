<?php

require_once('./includes/header.php');
        
    
    if (isset($_GET['action']) && isset($_GET['id'])){
        $id = (int)$_GET['id'];
    

        // Toggle post active status
        if ($_GET['action'] === 'change_status'){
            $post -> togglePostStatus($id);
        }


        //DELETE USER
        if ($_GET['action'] === 'delete'){
            $post -> deletePost($_GET['id']);
        }
        
        
    }



require_once('./includes/footer.php');
?>


