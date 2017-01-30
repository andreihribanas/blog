<?php

require_once('./includes/config.php');


    if ( !$_SESSION['is_logged'] ){      
        $_SESSION['message'] = '<div class="alert alert-danger row-fluid"> <strong> You need to login to see this page. </strong> </div>';
        header('Location: index.php');
        exit; 
    }


    // UPDATE USER DETAILS
    if (isset($_POST['submit'])){
        
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $avatar_link = $_POST['avatar_link'];
        
        if ($name == ''){
            $_SESSION['message'] .= '<br> Please enter the first name.';
        }
        
        if ($surname == ''){
            $_SESSION['message'] .= '<br> Please enter the surname.';
        }
        
        if ($email == ''){
            $_SESSION['message'] .= '<br> Please enter your email address.';
        }
        
        
        if ($_SESSION['message'] == ''){
            
            try {
                $stmt = $con->prepare('UPDATE users SET name = :name, surname = :surname, email = :email, avatar_link = :avatar_link WHERE username = :username');    
                $stmt->execute(array(
                    ':name' => $name,
                    ':surname' => $surname,
                    ':email' => $email,
                    ':avatar_link' => $avatar_link,
                    ':username' => $_SESSION['username']
                ));

              //  header('Location: user-profile-view.php');
                $_SESSION['message'] = '<div class="alert alert-success"> <strong> The user details were succesfully updated. </strong> </div>';
             //   exit;

            } catch (PDOException $e) {
               echo $e->getMessage();
            }
        } else {
            header('Location: user-profile-view.php');
            $_SESSION['message'] = '<div class="alert alert-danger"> <strong> There are some errors in your submission: <br></strong> '.$_SESSION['message'].' </div>';
            exit;
        }
    }

    // CHANGE USER PASSWORD
    if (isset($_POST['change_password'])){
        
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];
        
        if ($current_password == ''){
            $_SESSION['message'] .= '<br> Please enter the current password.';
        }        
        
        if ($new_password == ''){
            $_SESSION['message'] .= '<br> Please enter the new password.';
        }        
        
        if ($confirm_new_password == ''){
            $_SESSION['message'] .= '<br> Please confirm the new password.';
        }
        
        if( !empty($new_password) && !empty($confirm_new_password) && $new_password !== $confirm_new_password){
            $_SESSION['message'] .= '<br> The new password entered is not matching.';
        }
        
        // Check for error messages before update
        if ($_SESSION['message'] == ''){
            
            // Hash password
            $password_hashed = $user->create_hash($current_password);
            
            // Update password details
            try {
                        
                $stmt = $con->prepare('UPDATE users SET password = :password WHERE username= :username ');
                $stmt->execute(array(
                    ':password' => $password_hashed,
                    ':username' => $_SESSION['username']
                ));
                
                    
                $_SESSION['message'] = '<div class="alert alert-success"> <strong> The password details was updated. </strong> </div>';
                header('Location: user-profile-view.php');
                exit;
                
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
    
           
        } else {
            header('Location: user-profile-view.php');
            $_SESSION['message'] = '<div class="alert alert-danger"> <strong> There are some errors in your submission: <br></strong> '.$_SESSION['message'].' </div>';
            exit;
        }
        
        echo 'change password action';
    }

?>


<?php require_once('./includes/header.php'); ?>


        <!--- LOAD MENU --> 
        <div class="container">
             <div class="row">
                <div class="col-md-12"> 
                    <a href="index.php" class="menu-item"> Home </a> <hr>
                </div> <br>
            </div>
        </div>

    
        <div class="container">
            
            
            <div class="col-md-10">
                
                    <div class="row message">
                        <?php showMessage(); ?>
                    </div>
                
            <?php 
                if(isset($_SESSION['username']) && !empty($_SESSION['username']) ){
                    $stmt = $con->prepare('SELECT * FROM users WHERE username= :username');
                    $stmt->execute(array(':username' => $_SESSION['username']));

                    while($row = $stmt->fetch()) {
                        echo '
                           <div class="row">
                                <div class="col-md-9">
                                    <h1 class="align-center"> User profile </h1><br>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <div class="form-group row-fluid avatar-container">
                                        <img src="'.$row['avatar_link'].'" alt="There is no image selected" class="avatar-image">
                                    </div>

                                    <div class="form-group row">
                                        <label for="user-role"> User role: </label> <input type="text" class="form-control" name="user-role" value="'.$row['role'].'"  disabled>
                                    </div>

                                    <div class="form-group row">
                                        <label for="join-date"> Join date: </label> <input type="text" class="form-control" name="join-date"  value="'.$row['join_date'].'" disabled>
                                    </div>

                                    <div class="form-group row">
                                        <label for="postsNo">Posts: </label> <input type="text" class="form-control" name="postsNo" disabled>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="reputation">Reputation level: </label> <input type="text" class="form-control" name="reputation" disabled>
                                    </div>
                                </div>

                                <div class="col-md-1 form-group"> </div>

                                <!------------ CHANGE PASSWORD SECTION  ------------------->
                                <form action="" method="POST">
                                    <div class="col-md-8 form-group">
                                        <div class="form-group row-fluid">
                                            <label for="name"> Name: </label> <input type="text" class="form-control" name="name" value="'.$row['name'].'">
                                        </div>

                                        <div class="form-group row-fluid">
                                            <label for="surname"> Surname: </label> <input type="text" class="form-control" name="surname" value="'.$row['surname'].'">
                                        </div>  

                                        <div class="form-group row-fluid">
                                            <label for="email"> Email: </label> <input type="text" class="form-control" name="email" value="'.$row['email'].'">
                                        </div>     

                                        <div class="form-group row-fluid">
                                            <label for="username"> Username: </label> <input type="text" class="form-control" name="username" value="'.$row['username'].'" disabled>
                                        </div>

                                        <div class="form-group row-fluid">
                                            <label for="avatar_link" class="form-label"> Avatar link: </label> <input type="text" name="avatar_link" value="'.$row['avatar_link'].'" class="form-control">
                                        </div>     

                                        <div class="form-group row-fluid">

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12 align-center">
                                                <br> <input type="submit" name="submit" value="Save changes" class="btn btn-primary">
                                            </div>
                                        </div>

                                        <!------------ CHANGE PASSWORD SECTION  ------------------->
                                        <div class="form-group row-fluid">
                                            <label for="current_password"> Current password: </label> <input type="password" class="form-control" name="current_password" value="">
                                        </div>

                                        <div class="form-group row-fluid">
                                            <label for="confirm_password"> Current password: </label> <input type="password" class="form-control" name="new_password" value="">
                                        </div>

                                        <div class="form-group row-fluid">
                                            <label for="confirm_new_password"> Current password: </label> <input type="password" class="form-control" name="confirm_new_password" value="">
                                        </div>

                                        <div class="form-group row-fluid">
                                            <div class="col-md-12 align-center">    
                                                <input type="submit" class="btn btn-primary align center" name="change_password" value="Change password">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        ';
                    }
                }
                ?> <!-- end statement -->

                <div class="row">
                    <br>

                    <div class="container">
                        <div class="row-fluid">
                            <p> Personal messages </p>
                        </div>
                    </div>
                </div>
                
            </div>
      

        </div>




<?php require_once('./includes/footer.php'); ?>