<?php

require_once('./includes/header.php'); 

    if ( !$_SESSION['is_logged'] || $_SESSION['role'] != 'admin' ){      
         $_SESSION['message'] = '<div class="alert alert-danger row-fluid"> <strong> Yo do not have the credentials to access this page. </strong> </div>';
        header('Location: index.php');
    }

?>
<!--
  
-->



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php load_admin_menu(); load_admin_dashboard(); ?>
            </div>
        </div>
    </div>


<?php require_once('./includes/footer.php'); ?>