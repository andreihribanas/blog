<?php

require_once('./includes/header.php'); 


    if ( !$_SESSION['is_logged'] || $_SESSION['role'] != 'admin' ){      
         $_SESSION['message'] = '<div class="alert alert-danger row-fluid"> <strong> Yo do not have the credentials to access this page. </strong> </div>';
        header('Location: index.php');
    }
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php load_admin_menu(); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                
                <div class="row">
                  <br>   <h1 class="align-center panel-title"> <strong> ACTIVITY HISTORY </strong> </h1><br>
                </div>
                        
                <br>
              
                <div class="row-fluid">
                <table class="table table-bordered table-striped align-center">
                    <thead class="thead-inverse align-center">
                        <tr>
                            <th> Username </th>
                            <th> Action </th>
                            <th> Date </th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        <?php
                        
                            $stmt = $con->query('SELECT * FROM activity_history ORDER BY id DESC');
    
                            while($row = $stmt->fetch()){
                                echo '
                                    <tr>
                                        <td> '.$row['username'].'  </td>
                                        <td> '.$row['action'].'  </td>
                                        <td> '.date('d/m/Y', strtotime($row['date'])).'  </td>
                                    </tr>    
                                ';
                            }

                        ?>
            
                    </tbody>
                </table></div>
            </div>
        </div>
    </div>




<?php require_once('./includes/footer.php'); ?>