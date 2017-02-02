<?php

require_once('./functions.php');

class Post {
    private $con;
    
    public function __construct($con){
        $this->con = $con;
    }
    
    
    public function addPost($title, $description, $content, $username){
          try {
                $stmt = $this->con->prepare('INSERT INTO posts (post_title, post_description, post_content, post_date, post_author, post_active, post_last_updated, post_class, post_visible_to) 
                    VALUES (:post_title, :post_description, :post_content, :post_date, :post_author, :post_active, :post_last_updated, :post_class, :post_visible_to)');
                $stmt->execute(array(
                        ':post_title' => $title, 
                        ':post_description' => $description,
                        ':post_content' => $content,
                        ':post_date' => date('Y-m-d H:i:s'),
                        ':post_author' => $username,
                        ':post_active' => 1,
                        ':post_last_updated' => date('Y-m-d H:i:s'),
                        ':post_class' => 'normal',
                        ':post_visible_to' => 'all'
                ));
              
                $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post was created. </strong> </div>';
                add_activity($this->con, $_SESSION['username'], 'Created a new post '. $title);
                header('Location: index.php');
                exit;
                
            } catch (PDOException $e) {
               echo $e->getMessage();
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
    
            $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post was deleted. </strong> </div>';
            add_activity($this->con, $_SESSION['username'], 'Deleted a post');
            header('Location: admin-post-view.php');
            exit;
        } catch (PDOException $e) {
                $e->getMessage();
            }
    }
    
    public function incrementPostViews($id){
        
            $stmt = $this->con->prepare( 'UPDATE posts SET post_views = post_views + 1 WHERE postID = :postID');
            $stmt -> execute(array(':postID' => $id));
    }    
    
    public function incrementPostReplies($id){
        
            $stmt = $this->con->prepare( 'UPDATE posts SET post_replies = post_replies + 1 WHERE postID = :postID');
            $stmt -> execute(array(':postID' => $id));
    }
    
    
        public function togglePostStatus($id) {
        
        try { 
            $stmt = $this->con -> prepare('SELECT postID, post_active FROM posts WHERE postID = :postID');
            $stmt -> execute(array(':postID' => $id));
            $row = $stmt -> fetch();
            
            if ($row['post_active'] === 0) {
                 try { 
                    // Enable post status (not visible)
                    $stmt2 = $this->con ->prepare('UPDATE posts SET post_active = :post_active WHERE postID = :postID');
                    $stmt2->execute(array(
                        'post_active' => 1,
                        'postID' => $id,
                    ));

                    $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post was enabled. </strong> </div>';
                     
               } catch (PDOException $e) {
                    echo $e -> getMessage();
                }

            } else {
                try{
                    // Disable post status (not visible)
                    $stmt2 = $this->con ->prepare('UPDATE posts SET post_active = :post_active WHERE postID = :postID');
                    $stmt2 ->execute(array(
                        'post_active' => 0,
                        'postID' => $id,
                    ));
                    
                    $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post was disabled. </strong> </div>';
                    
                } catch (PDOException $e) {
                    echo $e -> getMessage();
                } 

            }
            
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
        
         // Redirect to comments page
            header('Location: admin-post-view.php');
            exit;
    }
    
}















?>