<?php

  require_once('./includes/config.php');
  require_once('./includes/header.php');

    if (isset($_POST['submit'])){
        
        try {
            $stmt = $con->prepare('UPDATE posts SET post_title = :postTitle, post_description = :postDesc, post_content = :postCont WHERE postID = :postID');    
            $stmt->execute(array(
                ':postTitle' => $_POST['postTitle'],
                ':postDesc' => $_POST['postDesc'],
                ':postCont' => $_POST['postCont'],
                ':postID' => $_GET['id']
            ));
            
            IF ($_SESSION['role'] === 'admin'){
                header('Location: admin-post-view.php');
            } else {
                header('Location: viewpost.php?id='.$_GET['id']);
            }
            
            
            $_SESSION['message'] = '<div class="alert alert-success"> <strong> The post details were succesfully updated. </strong> </div>';
            exit;
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

?>


   <div class="container">
        
        <div class="col-md-12"> 
            <a href="admin-dashboard.php" class="menu-item"> Admin dashboard </a> <hr>
        </div> <br>
        
        
        <form action='' method='post'>
            
            <?php
            
                $stmt = $con->query('SELECT post_title, post_description, post_content FROM posts WHERE postID ='.$_GET['id']);
                
                while ($row = $stmt->fetch()) {
                    echo '
                        <p><label>Title</label><br>
                        <input type="text" name="postTitle" value="'. $row['post_title'].'"></p>

                        <p><label>Description</label><br>
                        <textarea name="postDesc" cols="60" rows="10"> '.$row['post_description'].' </textarea></p>

                        <p><label>Content</label><br>
                        <textarea name="postCont" cols="60" rows="10"> '.$row['post_content'].' </textarea></p>

                        <p><input type="submit" name="submit" value="Submit"></p>

                        <div> </div>
                    ';
                }

            ?>
            
        </form>
    </div>

        <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
        <script>
                tinymce.init({
                    selector: "textarea",
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                });
        </script>



<?php require_once('./includes/footer.php');  ?>