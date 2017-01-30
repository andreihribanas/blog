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
    
}
















?>