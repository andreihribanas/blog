<?php require_once('./includes/header.php'); ?>


<?php

    $errorMessage = '';
    $successMessage = '';

    // $errorMessage = '<p class="alert alert-success"> <strong> You have been registered succesfully. </strong> </p>';

    if (isset($_POST['submit'])){
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($username == ''){
            $errorMessage .= '<br> Please enter a username.';
        }
               
        if ($email == ''){
            $errorMessage .= '<br> Please enter your email address.';
        }
               
        if ($password == ''){
            $errorMessage .= '<br> Please enter a password.';
        }
                       
        if ($confirm_password == ''){
            $errorMessage .= '<br> Please enter a matching password.';
        }
        
        if ($username == ''){
            $errorMessage .= '<br> Please confirm your password.';
        }
        
        if ($password != $confirm_password) {
            $errorMessage .= '<br> The password is not matching.';
        }
        
        if ($errorMessage == '') {
            // add user
          //  $password_hash = $user->create_hash($password);
            $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
            
            try {

                //insert into database
                $stmt = $con->prepare('INSERT INTO users (username, password, email, active) VALUES (:username, :password, :email, :active)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $password_hash,
                    ':email' => $email,
                    ':active' => 1
                ));

                //redirect to login page
                if (isset($_GET['type']) && $_GET['type'] == 'admin') {
                    header('Location: admin-user-view.php');
                } else {
                     header('Location: login.php');
                }
                $_SESSION['message'] = '<div class="alert alert-success"> <strong> The user was succesfully added. </strong> </div>';
                
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

            
        } else {
            // warn user
            $errorMessage = '<p class="alert alert-danger"> <strong> There are some issues with your registration:  </strong> ' .$errorMessage. '  </p>';
        }
        
    }

?>

    <div class="container">
         <h1 class="align-center"> <strong> REGISTER FORM </strong> </h1><br>
        
        <form name="login"  method="POST">
            
             <div class="row">
                <div class="col-md-12 col-lg-12"> <?php echo $errorMessage; ?> </div>
      
            </div>    
            
            <div class="row form-group">
                <label for="username" class="col-md-2 col-form-label"> Enter username: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="text" name = "username" class="form-control col-10" placeholder="Please enter your username">  
                </div>
            </div>    
       
            <div class="row form-group">
                <label for="username" class="col-md-2 col-form-label"> Enter email: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="text" name = "email" class="form-control col-10" placeholder="Please enter your email address">  
                </div>
            </div>    

            <div class="row form-group">
                 <label for="password" class="col-md-2 col-form-label"> Enter password: </label>
                <div class="col-md-8 col-lg-8"> 
                    <input type="password" name="password" class="form-control" placeholder="Please enter your password">  
                </div>
            </div>

            <div class="row form-group">
                <label for="password" class="col-md-2 col-form-label"> Confirm password: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="password" name="confirm_password" class="form-control" placeholder="Please enter your password">  
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-8 col-lg-8">
                    <button type="submit" name="submit" clasas="form-control"> Submit </button>
                </div>
            </div>
            
       
        </form>
    </div>


<?php require_once('./includes/footer.php'); ?>