<?php require_once('./includes/header.php'); require_once('./libraries/is_email.php'); ?>


<?php

   $_SESSION['message'] = '';

    if (isset($_POST['submit'])){
        
        // Sanitize input
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $surname = filter_var($_POST['surname'], FILTER_SANITIZE_STRING);
        $username = $_POST['username'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
    
        // Check for inputs
        if (empty($name)){
            $_SESSION['message'] .= '<br> Please enter a name.';
        }
                  
        if (empty($surname)){
            $_SESSION['message'] .= '<br> Please enter a surname.';
        }
                  
        if ( strlen($name) < 2 || strlen($surname) < 2)  {
            $_SESSION['message'] .= '<br> The name or surname must be at least 2 characters long.';
        }
        
        if (empty($username) || strlen($username) < 3){
            $_SESSION['message'] .= '<br> The username must be at least 3 characters long.';
        }       
        if ( !ctype_alnum($username)){
            $_SESSION['message'] .= '<br> Please insert only alphanumeric characters for your username.';
        }

        if (!is_username_available($username, $con)){
            $_SESSION['message'] .= '<br> The username is already taken.';
        }      
        
        if (empty($email) || strlen($email) < 2 || !is_email($email)){
            $_SESSION['message'] .= '<br> Please enter a valid email address.';
        }
     
        if (!is_email_available($email, $con)) {
            $_SESSION['message'] .= '<br> The email was already is already associated with an account.';
        }
        
        if (empty($password) || strlen($password) < 6 || strlen($password) >10){
            $_SESSION['message'] .= '<br> Please enter a password between 6 and 10 characters.';
        }
                       
        if (empty($confirm_password) || $password !== $confirm_password){
            $_SESSION['message'] .= '<br> Please enter a matching password.';
        }
        
        
        if (empty($_SESSION['message'])) {
        
            // Create the password hash
            $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
            
            try {

                //insert into database
                $stmt = $con->prepare('INSERT INTO users (name, surname, username, password, email, join_date, role, active) VALUES (:name, :surname, :username, :password, :email, :join_date, :role, :active)') ;
                $stmt->execute(array(
                    ':name' => $name,
                    ':surname' => $surname,
                    ':username' => $username,
                    ':password' => $password_hash,
                    ':email' => $email,
                    ':join_date' => date("Y-m-d H:i:s"),
                    ':role' => 'user',
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
            $_SESSION['message'] = '<p class="alert alert-danger"> <strong> There are some issues with your registration:  </strong> ' .$_SESSION['message']. '  </p>';
        }
            
    }
    

?>

    <div class="container">
         <br><h1 class="align-center"> <strong> USER REGISTRATION FORM </strong> </h1><br><br>
        
        <form name="login"  action="" method="POST">
            
             <div class="row">
                <div class="col-md-12 col-lg-12"> <?php showMessage(); ?> </div>
      
            </div>    
            
            <div class="row form-group">
                <label for="username" class="col-md-2 col-form-label"> Enter name: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="text" name = "name"  id="hh" class="form-control form-control-success col-10 " placeholder="Please enter your name">  
                </div>
            </div>    
         
            <div class="row form-group">
                <label for="username" class="col-md-2 col-form-label"> Enter surname: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="text" name = "surname" class="form-control col-10" placeholder="Please enter your surname">  
                </div>
            </div>    
         
            <div class="row form-group">
                <label for="username" class="col-md-2 col-form-label"> Enter username: </label>
                <div class="col-md-8 col-lg-8">
                    <input type="text" name = "username" class="form-control col-10" placeholder="Please enter an username">  
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
                <div class="col-md-8 col-lg-8 align-center">
                    <button type="submit" name="submit" class="btn btn-primary"> Submit </button>
                </div>
            </div>
            
       
        </form>
    </div>



<?php require_once('./includes/footer.php'); ?>