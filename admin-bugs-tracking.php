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
                  <br>   <h1 class="align-center panel-title"> <strong> BUGS TRACKING </strong> </h1><br>
                </div>
                        
                <br>
                
                <div class="row-fluid">
                <table class="table table-bordered table-striped align-center">
                    <thead class="thead-inverse align-center">
                        <tr>
                            <th> Username </th>
                            <th> Title </th>
                            <th> Description </th>
                            <th> Date recorded</th>
                            <th> Date solved</th>
                            <th> Status </th>
                            <th> Action </th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        <?php
                        
                            $stmt = $con->query('SELECT * FROM bugs_tracking ORDER BY bugID DESC');
    
                            while($row = $stmt->fetch()){
                                echo '
                                    <tr>
                                        <td> '.$row['requester'].'  </td>
                                        <td> '.$row['bug_name'].'  </td>
                                        <td> '.$row['bug_description'].'  </td>
                                        <td> '.date('d/m/Y', strtotime($row['bug_record_date'])).'  </td>
                                        <td> '.date('d/m/Y', strtotime($row['bug_solved_date'])).'  </td>
                                        <td> '.ucfirst($row['bug_status']).'  </td>
                                        <td> ';
                                        
                                            if ($row['bug_status'] !== 'solved') {
                                                echo '<a href="admin-bugs-actions.php?action=solve&bug_id='.$row['bugID'].'"><i class="fa fa-check" aria-hidden="true"></i> Solve </a> ';
                                            } else {
                                                 echo '<a href="admin-bugs-actions.php?action=unsolve&bug_id='.$row['bugID'].'"><i class="fa fa-square" aria-hidden="true"></i> Unsolve </a> ';
                                            }
                                        
                                            
                                echo '  </td>
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