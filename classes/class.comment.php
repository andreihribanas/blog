<?php



class Comment {
    private $con;
    
    public function __construct($con){
        $this->con = $con;
    }
    
    
    public function addComment($title, $description, $content){
          try {
                $stmt = $this->con->prepare('INSERT INTO posts VALUES (:post_title, :post_description, :post_content, :post_date)');
                $stmt->execute(array(
                        ':post_title' => $a, 
                        ':post_description' => $a,
                        ':post_content' => $a,
                        ':post_date' => date('Y-m-d H:i:s') 
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
    
    public function deleteComment($id, $page){
        try {
            $stmt = $this->con->prepare('DELETE FROM comments WHERE commentID = :commentID');
            $stmt-> execute(array(':commentID' => $id));
            header('Location: viewpost.php?id='.$page);
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
                    // Make comment active
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
                    // Make comment inactive
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
        
         // Redirect to viewpost page
            header('Location: viewpost.php?id='.$_GET['id']);
            exit;
    }
    
}



?>