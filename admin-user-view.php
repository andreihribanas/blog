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
                  <br>   <h1 class="align-center panel-title"> <strong> USERS MANAGEMENT </strong> </h1><br>
                </div>
                        
                <br>
                
                <div class="row message">
                    <?php showMessage(); ?>
                </div>
                
                <br>
                <div class="row-fluid">
                <table class="table table-bordered table-striped align-center">
                    <thead class="thead-inverse align-center">
                        <tr>
                            <th> No# </th>
                            <th> Username </th>
                            <th> Email </th>
                            <th> Join date </th>
                            <th> Role </th>
                            <th> Active </th>
                            <th> Comments </th>
                            <th> Reputation </th>
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
                                        <td> '.date('d/m/Y', strtotime($row['join_date'])).'  </td>
                                        <td> '.$row['role'].'  </td>
                                        <td> '.$row['active'].'  </td>
                                        <td> '.$row['comments_number'].'  </td>
                                        <td> '.$row['rep_level'].'  </td>
                                        <td> '; 
                                
                                            if ($row['active'] === 0) {
                                                  echo '<a href="admin-user-actions.php?action=status&id='.$row['userID'].'" onclick=\'return confirm("Are you sure you want to enable '.$row['username'].'?")\'> Enable | </a> ';
                                            } else {
                                                 echo '<a href="admin-user-actions.php?action=status&id='.$row['userID'].'" onclick=\'return confirm("Are you sure you want to disable '.$row['username'].'?")\'> Disable | </a> ';
                                            }
                                
                                          echo '
                                            <a href="admin-user-actions.php?action=change_role&id='.$row['userID'].'" onclick=\'return confirm("Are you sure you want to change the role for '.$row['username'].' ?")\'> Change role | </a> 
                                            <a href="admin-user-actions.php?action=delete&id='.$row['userID'].'" onclick=\'return confirm("Are you sure you want to delete this user?")\'> Delete </a> 
                                        </td>
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