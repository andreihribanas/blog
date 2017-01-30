<?php

require_once('./includes/header.php'); 

/*
    if (!$_SESSION['loggedin'] ){      
        header('Location: login.php');
    }
*/
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
                  <br>   <h1 class="align-center panel-title"> <strong> USERS MANAGEMENT </strong> </h1><br>
                </div>
                        
                <div class="row">
                    <a href="register.php?type=admin" class="menu-item"> Add a new user </a>
                </div>
                <br>
                
                <div class="row message">
                    <?php showMessage(); ?>
                </div>
                
                <br>
                
                <table class="table table-bordered table-striped align-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th> No# </th>
                            <th> Username </th>
                            <th> Email </th>
                            <th> Join date </th>
                            <th> Active </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        <?php
                        
                            $stmt = $con->query('SELECT * FROM users users ORDER BY userID DESC');
    
                            while($row = $stmt->fetch()){
                                echo '
                                    <tr>
                                        <td> '.$row['userID'].' </td>
                                        <td> '.$row['username'].'  </td>
                                        <td> '.$row['email'].'  </td>
                                     
                                        <td> '.$row['join_date'].'  </td>
                                        <td> '.$row['active'].'  </td>
                                        <td> 
                                            <a href="admin-user-disable.php?id='.$row['userID'].'"> Disable | </a>
                                            <a href="admin-user-disable.php?id='.$row['userID'].'"> Change password | </a>
                                            <a href="admin-user-delete.php?type=admin&id='.$row['userID'].'" > Delete </a> 
                                        </td>
                                    </tr>    
                                ';
                            }

                        ?>
            
                    </tbody>
                </table>
            </div>
        </div>
    </div>




<?php require_once('./includes/footer.php'); ?>