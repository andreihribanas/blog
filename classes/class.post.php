<?php

require_once('./functions.php');

class Post {
    private $con;
    
    public function __construct($con){
        $this->con = $con;
    }
    
    
    public function addPost($title, $description, $content){
          try {
                $stmt = $this->con->prepare('INSERT INTO posts (post_title, post_description, post_content, post_date) VALUES (:postTitle, :postDesc, :postCont, :postDate)');
                $stmt->execute(array(
                        ':postTitle' => $title, 
                        ':postDesc' => $description,
                        ':postCont' => $content,
                        ':postDate' => date('Y-m-d H:i:s') 
                ));
                
              redirect($_GET['type']);
                
            } catch (PDOException $e) {
                $e->getMessage();
            }
       
    }
    
    public function updatePost(){
        try {
            
        } catch (PDOException $e){
            
        }
    }
    
    public function deletePost($id){
        try {
            $stmt = $this->con->prepare('DELETE FROM posts WHERE postID= :postID');
            $stmt-> execute(array(':postID' => $id));
    
        } catch (PDOException $e) {
                $e->getMessage();
            }
    }
    
}















?>