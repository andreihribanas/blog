<?php

    require_once('./includes/config.php');

    if (isset($_POST['submit'])) {
        $username = $_SESSION['username'];
        $comment = $_POST['comment'];
        $postID = $_POST['postID'];

         try {
                $stmt = $con->prepare('INSERT INTO comments (comment_content, postID, comment_author, comment_date) VALUES (:comment_content, :postID, :comment_author, :date)');
                $stmt->execute(array(
                    ':comment_content' => $comment,
                    ':postID' => $postID,
                    ':comment_author' => $username,
                    ':date' => date('Y-m-d H:i:s')
                ));

                header('Location:viewpost.php?id='.$postID);
                exit;

            } catch (PDOException $e) {
                 $e-> getMessage();
            }
    
}

?>
