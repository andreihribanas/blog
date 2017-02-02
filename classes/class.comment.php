<?php



class Comment {
    private $con;
    
    public function __construct($con){
        $this->con = $con;
    }
    
    
    public function addComment($title, $description, $content){
          try {
                $stmt = $this->con->prepare('INSERT INTO posts () VALUES (:, :, :, :)');
                $stmt->execute(array(
                        ':postTitle' => $a, 
                        ':postDesc' => $a,
                        ':postCont' => $a,
                        ':postDate' => date('Y-m-d H:i:s') 
                ));
                exit;
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
       
    }
    
    public function updateComment(){
        try {
            
        } catch (PDOException $e){
            
        }
    }
    
    public function deleteComment($id){
        try {
            $stmt = $this->con->prepare('DELETE FROM comments WHERE commentID= :commentID');
            $stmt-> execute(array(':commentID' => $id));
            header('Location: admin-dashboard.php');
            exit;  
            
        } catch (PDOException $e) {
                $e->getMessage();
            }
       
    }
    
    public function toggleCommentStatus($comment_id) {
        
        try { 
            $stmt = $this->con -> prepare('SELECT commentID, comment_active FROM comments WHERE commentID = :comment_id');
            $stmt -> execute(array(':comment_id' => $comment_id));
            $row = $stmt -> fetch();
            
            if ($row['comment_active'] === 0) {
                 try { 
                    // Disable comment status (not visible)
                   $stmt2 = $this->con ->prepare('UPDATE comments SET comment_active = :comment_active WHERE commentID = :comment_id');
                    $stmt2->execute(array(
                        'comment_active' => 1,
                        'comment_id' => $comment_id,
                    ));

               } catch (PDOException $e) {
                    echo $e -> getMessage();
                }

            } else {
                try{
                    // Disable comment status (not visible)
                    $stmt2 = $this->con ->prepare('UPDATE comments SET comment_active = :comment_active WHERE commentID = :comment_id');
                    $stmt2 ->execute(array(
                        'comment_active' => 0,
                        'comment_id' => $comment_id,
                    ));

                } catch (PDOException $e) {
                    echo $e -> getMessage();
                } 

            }
            
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
        
         // Redirect to comments page
            header('Location: viewpost.php?id='.$_GET['id']);
            exit;
    }
    
}
















?>