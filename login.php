<?php require_once('./includes/header.php'); 

$_SESSION['message'] = '';


    if(isset($_POST['submit'])){
        
        $username = $_POST['username'];
        $password = $_POST['password'];
                
        if (empty($username) || strlen($username) < 3) {
            $_SESSION['message'] .= '<br> Please username must be at least 3 characters long.';
        }
        
        if (empty($password) || strlen($password) < 6 || strlen($password) > 10) {
            $_SESSION['message'] .= '<br> The password length must have at least 6 and maximum 10 characters.';
        }
        
        if ( !ctype_alnum($username)){
            $_SESSION['message'] .= '<br> Please insert only alphanumeric characters for your username.';
        }
        
        if (!ctype_alnum($username)) {
            $_SESSION['message'] .= '<br> The username must contain only alphanumeric characters.';
        }
        
        if (empty($_SESSION['message'])) {
 
            try {
                $stmt = $con->prepare('SELECT username, password, role, active FROM users WHERE username= :username');
                $stmt->execute(array(':username' => $username));
                $row = $stmt->fetch();

                // Check number of results found
                $rows_number = $con->prepare('select count(*) FROM users WHERE username= :username');
                $rows_number->execute(array(':username' => $username));

                
                // Check if the credentials match
                if ( $row['username'] === $username && password_verify($password, $row['password']) ) {
                    
                        if ($row['active'] === 1) {
                            
                            $_SESSION['username'] = $username;
                            $_SESSION['is_logged'] = true;
                            $_SESSION['role'] = $row['role'];

                            $_SESSION['message'] = '<p class="alert alert-info"> <strong> You have been logged in.  </strong> ' .$_SESSION['message']. '  </p>';
                            header('Location: index.php');
                            exit;
                        } else {
                            $_SESSION['message'] = '<p class="alert alert-danger"> <strong> Your account was suspended. Please contact the administrator for further details.  </strong> ' .$_SESSION['message']. '  </p>';
                            header('Location: index.php');
                            exit;
                        }
                    
                } else {
                    $_SESSION['message'] = '<p class="alert alert-danger"> <strong> Wrong username or password. Please try again  </strong> ' .$_SESSION['message']. '  </p>';   
                }
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            } 
            
        } else {
            // warn user
            $_SESSION['message'] = '<p class="alert alert-danger"> <strong> There are some issues with your registration:  </strong> ' .$_SESSION['message']. '  </p>';
        }
        
        
    }



?>







        <div class="container">
            <form action="" method="POST">
                
                <h1 class="align-center"><strong> LOGIN PAGE </strong></h1>
                
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8"> <?php showMessage(); ?> </div>
                </div>  
                
                <div class="form-group row">
                    <div class="col-md-8 offset-md-2">
                        <label class="form-label" for="username"><strong> Enter username: </strong></label>
                        <input type="text" name = "username" class="form-control" placeholder="Please enter your username">  
                    </div>
                </div>    

                <div class="row form-group">
                    <div class="col-md-8 offset-md-2">
                        <label class="form-label" for="password"><strong> Enter password: </strong></label>
                        <input type="password" name="password" class="form-control" placeholder="Please enter your password">  
                    </div>
                </div>

                <div class="row form-group align-center">
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" name="submit" class="btn btn-primary"> Submit </button>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-12 align-center">
                        <a href="register.php" class="text-center"> <strong> Don't have an account? Do not waste any more time and click here! </strong> </a>
                    </div>
                </div>
                
                <div class="row form-group">    
                    <div class="col-md-12 align-center">
                        <a href="#.php" class="text-center"> <strong> Forgot username or password? </strong> </a>
                    </div>
                </div>
            </form>
        </div>





<?php require_once('./includes/footer.php'); ?>