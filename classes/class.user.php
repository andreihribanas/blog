<?php

class User{
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }


    public function is_logged_in(){
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }
    }

    public function create_hash($value){
        return $hash = crypt($value, '$2a$12.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22)');
    }
    
    
    private function verify_hash($password, $hash) {
        return $hash == crypt($password, $hash);
    }
    
    private function get_user_hash($username){

        try {
            $stmt = $this->con->prepare('SELECT username, password FROM users WHERE username = :username');
            $stmt->execute(array('username' => $username));

            $row = $stmt->fetch();
            return $row['password'];

        } catch (PDOException $e) {
            echo '<p class="alert alert-danger"> <strong> '. $e->getMessage() .' </strong> </p>';
        }
    }
    

    public function login($username, $password){
        $hashed = $this->get_user_hash($username);

        if ($this->password_verify($password, $hashed) ==1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            return true;
            
        }
    }
    
    public function logout(){
        session_destroy();
       
        session_start();
        
        $_SESSION['message'] = '<p class="alert alert-warning"> <strong> You have been logged out.  </strong> ' .$errorMessage. '  </p>';
        header('Location: index.php');
        exit;
        
    }
 
    
    public function addUser(){
        
    }
    
    public function updateUser(){
        
    }
    
    
    public function deleteUser($id){
        try {
            $stmt = $this->con->prepare('DELETE FROM users WHERE userID= :userID');
            $stmt-> execute(array(':userID' => $id));
    
            $_SESSION['message'] = '<div class="alert alert-success"> <strong> The user was deleted. </strong> </div>';
                
        } catch (PDOException $e) {
                $e->getMessage();
            }
    }

}















?>