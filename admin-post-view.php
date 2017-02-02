<?php

require_once('./includes/header.php'); 

function id(){
    echo $_GET['id'];
}
    

?>
<!--
    <div class="container">
        
        <div class="col-md-6 admin-dash"> USERS </div>
        <div class="col-md-6 admin-dash"> POSTS </div>
        <div class="col-md-6 admin-dash"> COMMENTS </div>
        <div class="col-md-6 admin-dash"> LOGOUT </div>

    </div>
-->



    <div class="container-fluid">
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
                            <th> Author </th>
                            <th> Active </th>
                            <th> Views# </th>
                            <th> Replies# </th>
                            <th> Visible </th>
                            <th> Class </th>
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
                                        <td> '.$row['post_author'].'  </td>
                                        <td> '.$row['post_active'].'  </td>
                                        <td> '.$row['post_views'].'  </td>
                                        <td> '.$row['post_replies'].'  </td>
                                        <td> '.$row['post_visible_to'].'  </td>
                                        <td> '.$row['post_class'].'  </td>
                                        <td> 
                                            <a href="viewpost.php?id='.$row['postID'].'"> View post | </a>
                                            <a href="admin-post-edit.php?id='.$row['postID'].'"> Edit | </a> ';
                                            
                                            if ($row['post_active'] === 0) {
                                                echo ' <a href="admin-post-actions.php?action=change_status&id='.$row['postID'].'" onclick=\'return confirm("Are you sure you want to disable the post?")\' > Enable | </a> ';
                                            } else {
                                                echo ' <a href="admin-post-actions.php?action=change_status&id='.$row['postID'].'" onclick=\'return confirm("Are you sure you want to disable the post?")\'> Disable | </a> ';
                                            }
                                
                                        echo '
                                            <a href="admin-post-actions.php?action=delete&id='.$row['postID'].'" onclick=\'return confirm("Are you sure you want to delete the post?")\'> Delete | </a>
                                           
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