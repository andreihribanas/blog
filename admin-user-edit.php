<?php require_once('./includes/header.php'); ?>


<?php

$errorMessage = '';

    if (isset($_POST['submit'])){
        
        $userID = $_POST['userID'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($username == ''){
            $errorMessage .= '<br> Please enter the username.';
        }
        
        if ($password == ''){
            $errorMessage .= '<br> Please enter the username.';
        }
        
        if ($password != $confirm_password) {
            $errorMessage .= '<br> The passwords are not matching.';  
        }
        
        
        if ($errorMessage == ''){
            

            try {
                $stmt = $con->prepare('UPDATE users SET username = :username, email = :email WHERE userID = :userID');    
                $stmt->execute(array(
                    ':username' => $username,
                    ':email' => $email,
                    ':userID' => $userID
                ));

                header('Location: user-profile-view.php');
                $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post details were succesfully updated. </strong> </div>';
                exit;

            } catch (PDOException $e) {
                $e->getMessage();
            }
        }
        
    }

?>

    <div class="container">
         <h1 class="align-center"> <strong>  </strong> </h1><br>
        
        <form name="login"  method="POST">
            <input type="hidden" name="userID" value=" <?= $_GET['id'] ?> >"
            
            <?php
            
                $stmt = $con->query('SELECT username, email, password FROM users WHERE userID ='.$_GET['id']);
                
                while ($row = $stmt->fetch()) {
                    echo '
                     <div class="row">
                        <div class="col-md-12 col-lg-12"> <?php '. $errorMessage .' </div>
                        
                    </div>    

                    <div class="row form-group">
                        <label for="username" class="col-md-2 col-form-label"> Enter username: </label>
                        <div class="col-md-8 col-lg-8">
                            <input type="text" name = "username" class="form-control col-10" placeholder="Please enter your username" value="'. $row['username'] .' ">  
                        </div>
                    </div>    

                    <div class="row form-group">
                        <label for="username" class="col-md-2 col-form-label"> Enter email: </label>
                        <div class="col-md-8 col-lg-8">
                            <input type="text" name = "email" class="form-control col-10" placeholder="Please enter your email address" value="'. $row['email'] .'">
                        </div>
                    </div>    

                    <div class="row form-group">
                         <label for="password" class="col-md-2 col-form-label"> Enter password: </label>
                        <div class="col-md-8 col-lg-8"> 
                            <input type="password" name="password" class="form-control" placeholder="Please enter your password" value=" '. $row['password'] .' ">
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
                    </div> ';
                } 
            ?>

        </form>
    </div>


<?php require_once('./includes/footer.php'); ?>