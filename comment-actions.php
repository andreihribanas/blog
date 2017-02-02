<?php

require_once('./includes/header.php');


    if (isset($_GET['update'])){
        echo "update that biatch: " . $_GET['update'];
        
        
        if (isset($_POST['update-comment'])) {
            echo 'ypdate comment requested: id= '.$_POST['post_id'];
            
            try {
                $stmt = $con -> prepare('UPDATE comments SET comment_content = :content, comment_last_updated = :date WHERE commentID = :commentID');
                $stmt -> execute(array(
                    ':content' => $_POST['comment'],
                    ':date' => current_date_format(),
                    ':commentID' => $_GET['update']
                ));
                
                $_SESSION['message'] = '<p class="alert alert-success container"> <strong> The comment was updated.  </strong>  </p>'; 
                header('Location: viewpost.php?id='.$_GET['id']);
                exit;
            } catch (PDOException $e) {
                echo $e -> getMessage();
            }
        }
        
        
        echo '
        
            <div class="container">
                <h3 class="align-center"> <strong> EDIT COMMENT </strong> </h3>

                <br>

                <form method="POST">
                    <div class="container">
                        
                        <input type="hidden" name="post_id" value="'.$_GET['id'].'"> 
                    
                        <div class="row form-group">
                            <label class="form-label"> Comment </label>
                            <textarea class="form-control" name="comment" cols="60" rows="10"> '. $_GET['content'].' </textarea>
                        </div>

                        <div class="row form-group">
                            <input type="submit" name="update-comment" class="btn btn-primary" value="Edit comment">
                        </div>
                    </div>
                </form>
            </div>
        ';
        
        // update the last entry date
        
    }   


    // Toggle the comments from show / hide
    if (isset($_GET['action'])){
        $comment -> toggleCommentStatus($_GET['comm_id']);
    }



    // Delete comments
    if (isset($_GET['delete'])){
        $stmt = $con->prepare('DELETE FROM comments WHERE commentID = :commentID');
        $stmt->execute(array(':commentID' => $_GET['delete']));
        
        header('Location: viewpost.php?id='.$_GET['id']);
        $_SESSION['message'] = '<p class="alert alert-success container"> <strong> The comment was deleted.  </strong> </p>'; 
        exit;
    }



require_once('./includes/footer.php');
?>

