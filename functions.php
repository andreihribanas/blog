<?php

require_once('./includes/config.php');

// Load menu function
function load_menu(){
    
    echo '
        <a href="index.php" class="menu-item">Home</a>
        <a href="post-add.php" class="menu-item">Create new post</a>
        <a href="user-profile-view.php" class="menu-item" id="btnProfile">Profile</a> 
        <a href="bugs-report.php" class="menu-item" id="btnProfile">Report a bug</a> 
        <a href="logout.php" class="menu-item"> Logout </a>
        <a href="admin-dashboard.php" class="menu-item admin-mode">Admin mode</a>  
    ';
}

function load_admin_dashboard(){
    
    
    echo '
        <br>
        
        <div class="container admin-dashboard">
            <a href="admin-user-view.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-user fa-big" aria-hidden="true"></i> <strong> USERS </strong> </div> </a>
            <a href="admin-post-view.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-comments fa-big" aria-hidden="true"></i> <strong> POSTS </strong> </div> </a>
            <a href="admin-comment-view.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-cogs fa-big" aria-hidden="true"></i> <strong> ACTIVITY PANEL </strong></div> </a>
            <a href="admin-comment-view.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-cogs fa-big" aria-hidden="true"></i> <strong> ADMIN REQUESTS </strong></div> </a>
            <a href="admin-bugs-tracking.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-bug fa-big" aria-hidden="true"></i> <strong> BUGS TRACKING </strong></div> </a>
            <a href="logout.php"> <div class="col-md-6 admin-dash"> <i class="fa fa-sign-out fa-big" aria-hidden="true"></i> <strong> LOGOUT </strong></div> </a>
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
        unset($_SESSION['message']);
    }
}


function editComments($username) {
  
}


function current_date_format(){
    return date('Y-m-d H:i:s');
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


function date_to_display($input){
    return date('d F Y', strtotime($input));
}

function date_to_display_hours($input){

    return date('d F Y H:i:s', strtotime($input));
}


function get_post_author($id, $con){
    
    $stmt=$con->prepare('SELECT post_author FROM posts WHERE postID = :postID');
    $stmt->execute(array(':postID' => $id));
    $row = $stmt->fetch();
    
    return $author = $row['post_author'];
}

function is_user_logged(){
    if ( isset($_SESSION['is_logged']) ){
        return true;
    }
}


function is_username_available($username, $con) {

	$stmt = $con->prepare('SELECT username FROM users WHERE username= :username');
    $stmt->execute(array(':username' => $username));

	
	if ( count($stmt->fetchAll()) > 0) {
		return false;
	} 

    return true;

}

function is_email_available($email, $con) {

	$stmt = $con->prepare('SELECT email FROM users WHERE email= :email');
    $stmt->execute(array(':email' => $email));

	
	if ( count($stmt->fetchAll()) > 0) {
		return false;
	} else {
	
	   return true;
    }
}



function is_available($what, $who, $con) {

	$stmt = $con->prepare('SELECT '.$what.' FROM '.$where.' WHERE '.$what.'= :data');
    $stmt->execute(array(':data' => $what));

	if ( count($stmt->fetchAll()) === 1) {
		return true;
	} 
    
    return false;
}


function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
	$input = filter_var($input, FILTER_SANITIZE_STRING);
	$output = preg_replace($search, '', $input);
	$output = trim($output);
    $output = stripslashes($output);
    $output = htmlspecialchars($output);

    return $output;
}


function sanitize_input($input){
    return preg_replace("([^0-9/])", "", htmlentities($input));
}
function get_output($input){
    
}


?>