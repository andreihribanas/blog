<?php

require_once('./includes/config.php');

// Load menu function
function load_menu(){
    
    echo '
        <a href="index.php" class="menu-item">Home</a>
        <a href="post-add.php?type=user" class="menu-item">Create new post</a>
        <a href="user-profile-view.php" class="menu-item" id="btnProfile">Profile</a> 
        <a href="admin-dashboard.php" class="menu-item admin-mode">Admin mode</a>
        
    ';
}

function load_admin_dashboard(){
    
    
    echo '
        <br>
        
        <div class="container">
            <a href="admin-user-view.php"> <div class="col-md-6 admin-dash"> USERS </div> </a>
            <a href="admin-post-view.php"> <div class="col-md-6 admin-dash"> POSTS </div> </a>
            <a href="admin-comment-view.php"> <div class="col-md-6 admin-dash"> COMMENTS </div> </a>
            <a href="logout.php"> <div class="col-md-6 admin-dash"> LOGOUT </div> </a>
        </div>
        
        <br>
    ';
}

function load_admin_menu(){
    echo '
        <a href="index.php" class="menu-item">Blog</a> 
        <a href="admin-dashboard.php" class="menu-item">Dashboard</a> 
        
        <hr>
    
    ';
}


function showMessage(){
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        $_SESSION['message'] = '';
    }
}


function editComments($username) {
  
}

function redirect($type){
    $header = '';

    switch($type) {
        case 'user':
            $header = 'index.php';
            break;
            
        case 'admin':
            $header = 'admin-dashboard.php';
            break;
    }

   return header('Location:' . $header);
}

function check_credentials($role){
    
    /*/ check if logged in
    if ( if user not logged in ){
        $_SESSION['message'] = '<div class="alert alert-success"> <strong> Please login to access this page. </strong> </div>';
        header('Location: login.php');
    } else {
        if ( $role == 'admin' && !$role == $_SESSION['role']) {
            $_SESSION['message'] = '<div class="alert alert-success"> <strong> Yo do not have the credentials to access this page. </strong> </div>';
            header('Location: index.php');
        } 
    }
        
*/      
}


function is_user_logged(){
    if ( isset($_SESSION['is_logged']) ){
        return true;
    }
}

function is_username_taken($username) {
	
	global $con;
	$query = "SELECT `staff_email` FROM `staff` WHERE `staff_email` = '$email' ";
	$result = mysqli_query($con, $query);

	
	if (mysqli_num_rows($result) < 1) {
		return true;
	}
	
	return false;
}


?>