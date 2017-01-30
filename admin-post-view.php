<?php

require_once('./includes/header.php'); 

/*
    if (!$_SESSION['loggedin'] ){      
        header('Location: login.php');
    }
*/
?>
<!--
    <div class="container">
        
        <div class="col-md-6 admin-dash"> USERS </div>
        <div class="col-md-6 admin-dash"> POSTS </div>
        <div class="col-md-6 admin-dash"> COMMENTS </div>
        <div class="col-md-6 admin-dash"> LOGOUT </div>

    </div>
-->



    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php load_admin_menu(); ?>
            </div>
        
        </div>


        <div class="row">
            
              
            <div class="row">
              <br>   <h1 class="align-center panel-title"> <strong> POSTS MANAGEMENT </strong> </h1><br>
            </div>
            
            
            <div class="col-md-12">
                
                <div class="row">
                    <a href="post-add.php?type=admin" class="menu-item"> Add a post </a>
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
                            <th> Title </th>
                            <th> Description </th>
                            <th> Date </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        <?php
                        
                            $stmt = $con->query('SELECT * FROM posts ORDER BY postID DESC');
    
                            while($row = $stmt->fetch()){
                                echo '
                                    <tr>
                                        <td> '.$row['postID'].' </td>
                                        <td> '.$row['post_title'].'  </td>
                                        <td> '.$row['post_description'].'  </td>
                                        <td> '.$row['post_date'].'  </td>
                                        <td> 
                                            <a href="admin-post-edit.php?id='.$row['postID'].'"> Edit | </a>
                                            <a href="admin-disable-post.php?id='.$row['postID'].'"> Disable | </a>
                                            <a href="admin-post-delete.php?type=admin&id='.$row['postID'].'" > Delete </a> 
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




<?php require_once('./includes/header.php'); ?>