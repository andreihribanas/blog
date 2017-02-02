<?php require_once('./includes/header.php'); require_once('./libraries/is_email.php');


    if (isset($_POST['submit'])){
        
        try {
            $stmt = $con -> prepare('INSERT INTO bugs_tracking (bug_name, bug_description, bug_status, bug_date, requester) 
                VALUES (:bug_name, :bug_description, :bug_status, :bug_date, :requester) ');
            $stmt -> execute(array(
                ':bug_name' => $_POST['bug_name'],
                ':bug_description' => $_POST['bug_description'],
                ':bug_status' => 'Pending',
                ':bug_date' => current_date_format(),
                ':requester' => $_SESSION['username']
            ));
        
            $_SESSION['message'] = '<div class="alert alert-success"> <strong> Thank you for your feedback. An admin will check your report soon. </strong> </div>';
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
        
        
        
    }
  
    

?>
  <div class="container">
        <div class="row">
                <div class="col-md-12"> 
                    <?php load_menu(); ?>
                    <hr>
                </div>
        </div>
    </div>

    <div class="container">
         <br><h1 class="align-center panel-title"> <strong> BUGS REPORTING FORM </strong> </h1><br><br>
        
        
        <div class="row message">
            <?php showMessage(); ?>
        </div>

        <br>
        
        
        <form method="POST">
            <div class="form-group">
                <div class="row-fluid">
                    <label class="form-label"><strong> Bug name </strong></label>
                </div>
                
                <div class="row-fluid">
                    <input type="text" name="bug_name" class="form-control" value=""> 
                </div>  
            </div>

            <br>
            
            <div class="form-group>">
                <div class="row-fluid">
                    <label class="form-label"><strong> Description </strong></label>
                </div>           
                
                <div class="row-fluid">
                    <textarea name="bug_description" cols="60" rows="10" class="form-control">  </textarea>
                </div>
            </div>
           
            <br>
            
            <br>
            
            <div class="form-group>">        
                <div class="row-fluid align-center">
                    <input type="submit" name="submit" value="Record bug" class="btn btn-primary btn-lg">
                </div>
            </div>

            
        </form>
    </div>



<?php require_once('./includes/footer.php'); ?>