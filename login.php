<?php require_once('./includes/header.php'); ?>




<?php

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($username == '') {
            $_SESSION['message'] .= '<br> Please enter your username.';
        }
        
        if ($password == '') {
            $_SESSION['message'] .= '<br> Please enter your password.';
        }
        
        if ($_SESSION['message'] == '') {
 
            try {
                $stmt = $con->prepare('SELECT username, password FROM users WHERE username= :username');
                $stmt->execute(array(':username' => $username));
                $row = $stmt->fetch();

                // Check number of results found
                $rows_number = $con->prepare('select count(*) FROM users WHERE username= :username');
                $rows_number->execute(array(':username' => $username));

                
                // Check if the credentials match
                if ( count($rows_number->fetchAll()) && $row['username'] === $username && password_verify($password, $row['password']) ) {
                    
                    
                        $_SESSION['username'] = $username;
                        $_SESSION['loggedin'] = true;

                        $_SESSION['is_logged'] = true;

                        $_SESSION['role'] = $row['role'];

                        $_SESSION['message'] = '<p class="alert alert-warning"> <strong> You have been logged in.  </strong> ' .$_SESSION['message']. '  </p>';
                        header('Location: index.php');
                        exit;
                    
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
                
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8"> <?php showMessage(); ?> </div>
                </div>  
                
                <div class="form-group row">
                    <div class="col-md-8 col-lg-8">
                        <label for="username"> Enter username: </label>
                        <input type="text" name = "username" class="form-control" placeholder="Please enter your username">  
                    </div>
                </div>    

                <div class="row form-group">
                    <div class="col-md-8 col-lg-8">
                        <label for="password"> Enter password: </label>
                        <input type="password" name="password" class="form-control" placeholder="Please enter your password">  
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-8 col-lg-8">
                        <button type="submit" name="submit" class="form-control"> Submit </button>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-8 col-lg-8 align-center">
                        <a href="register.php" class="text-center"> <strong> Don't have an account? Do not waste any more time and click here! </strong> </a>
                    </div>
                    
                    <div class="col-md-8 col-lg-8 align-center">
                        <a href="#.php" class="text-center"> <strong> Forgot username or password </strong> </a>
                    </div>
                </div>
            </form>
        </div>





<?php require_once('./includes/footer.php'); ?>