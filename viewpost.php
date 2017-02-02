<?php 
require_once('./includes/header.php');


    if ( !isset($_SESSION['is_logged']) ){     
        $_SESSION['message'] = '<p class="alert alert-warning"> <strong> You need to log in to leave a comment to this post. </strong></p>';
    }

    // Add comment if button pressed
    if (isset($_POST['submit'])) {
        
            $username = $_SESSION['username'];
            $comment = stripslashes($_POST['comment']);
            $postID = $_POST['postID'];

             try {
                    $stmt = $con->prepare('INSERT INTO comments (comment_content, postID, comment_author, comment_date, comment_last_updated, comment_active) VALUES (:comment_content, :postID, :comment_author, :date, :last_updated, :active)');
                    $stmt->execute(array(
                        ':comment_content' => $comment,
                        ':postID' => $postID,
                        ':comment_author' => $username,
                        ':date' => date('Y-m-d H:i:s'),
                        ':last_updated' => date('Y-m-d H:i:s'),
                        ':active' => 1
                    ));
                 
                    $_SESSION['message'] = '<p class="alert alert-success"> <strong> You added a comment. </strong> </p>';
                    $post -> incrementPostReplies($_GET['id']);
                    $user -> incrementUserComments($_SESSION['username']);
                    header('Location:viewpost.php?id='.$postID);
                  
            } catch (PDOException $e) {
                     $e-> getMessage();
            }

        }       


    // Execute query to retrieve the post details
    $stmt = $con->prepare('SELECT * FROM posts WHERE postID = :postID');
    $stmt->execute(array(':postID' => $_GET['id']));
    $row = $stmt->fetch();
    
    // Increment post views
    $post -> incrementPostViews($_GET['id'], $con);

    // Display the post in full
        echo '
            <div class="container">
            
                <div class="col-md-12"> 
                    <a href="index.php" class="menu-item"> Home </a> <hr>
                </div> <br>
            
                <div class="container-fluid">
                    <div class="row-fluid text-center">
                        <p>Posted on <strong> '.date_to_display($row['post_date'], $con).' </strong> | Post author <strong>'.$row['post_author'].'</strong> </p>
                        <h1> '.htmlentities($row['post_title']).'  </h1> ';
                        
                            if ( (isset($_SESSION['username']) && $_SESSION['username'] === $row['post_author']) ||  (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) {
                                echo '   <a href="admin-post-edit.php?id='.$row['postID'].'"> <i class="fa fa-pencil fa-fw"></i> Edit </a>   
                                         <a href=""> <i class="fa fa-trash-o fa-fw"></i> Delete </a>  ';
                            }
                        
                        
                    echo '
                        <p> '.$row['post_content'].' </p>
                    </div>

                </div>
            </div>    

        ';

   
     // Add a new comment layout elements
        
        if ( isset($_SESSION['is_logged']) ){     
            echo '
                <form  method="post">
                    <div class="container reply-area">
                        <div class="row-fluid form-group">

                        <input type="hidden" name="postID" class="form-control" value="'.$_GET['id'].'">
                        <br>
                        <hr>
                                                                      
                        <div class="row-fluid">
                            <div class="col-md-12">
                                <h3 class="align-center"> <strong> COMMENTS SECTION </strong> </h3> <br>
                            </div>
                        </div>                    

                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" rows="2" name="comment"> </textarea>
                            </div>
                        </div>  

                        <br>

                        <div class="row form-group">
                            <div class="align-center">
                                <input type="submit" name="submit" class="btn btn-primary" value="Post quick reply">
                            </div>
                            
                            '.showMessage().' 
                            
                        </div>
                        
                         <hr>
                        </div>
                    </div>
                </form>
            ';
        }

    // Display existing comments 
    $stmt2 = $con->prepare('SELECT * FROM comments WHERE postID = :postID ORDER BY comment_date DESC');
    $stmt2->execute(array(':postID' => $_GET['id']));

    while ($row2 = $stmt2->fetch()){
        if ( ($row2['comment_active'] === 1) || ($row2['comment_active'] === 0 && isset($_SESSION['role'])  && $_SESSION['role'] === 'admin') ) {
            echo '
                <div class="container">

                    <table class="table  table-striped table-info">

                        <tr>
                            <td class="col-md-3"> 
                                <div class="row-fluid">
                                    <strong>  '. htmlspecialchars($row2['comment_author']) .' </strong>
                                </div><br>

                                <div class="row-fluid avatar-container align-center">
                                    <img src="'. $user->get_user_avatar($row2['comment_author']) .' " alt="The image does not exist." class="avatar-image">  
                                </div>

                                <div class="row-fluid">
                                    '. htmlspecialchars($_SESSION['role']) .'
                                </div>

                                <div class="row-fluid">
                                    Created: '. htmlspecialchars(date_to_display($row2['comment_date'])) .'
                                </div>
                            </td>

                            <td class="col-md-9"> 

                                <div class="row-fluid"> ';
                                    if ( (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') || (isset($_SESSION['username']) && $_SESSION['username'] === $row2['comment_author'])){
                                        echo '
                                        <a href="comment-actions.php?id='.$_GET['id'].'&update='.$row2['commentID'].'&content='.$row2['comment_content'].'" class="a-button"> <i class="fa fa-pencil fa-fw"></i> Edit  </a> 
                                        <a href="comment-actions.php?id='.$_GET['id'].'&flag='.$row2['commentID'].'&content='.$row2['comment_content'].'" class="a-button"> <i class="fa fa-flag fa-fw"></i> Flag  </a> 
                                        <a href="comment-actions.php?id='.$_GET['id'].'&delete='.$row2['commentID'].'" class="a-button" onclick=\'return confirm("Are you sure you want to delete this comment?")\' "> <i class="fa fa-trash-o fa-fw"></i> Delete  </a> ';

                                        
                                        
                                        if ($_SESSION['role'] === 'admin') {
                                            if ($row2['comment_active'] === 0) {
                                                  echo '<a href="comment-actions.php?action=show&id='.$_GET['id'].'&comm_id='.$row2['commentID'].'" class="a-button"> <i class="fa fa-eye fa-fw"></i> Show </a> ';
                                            } else {
                                                 echo '<a href="comment-actions.php?action=hide&id='.$_GET['id'].'&comm_id='.$row2['commentID'].'" class="a-button"> <i class="fa fa-ban fa-fw"></i> Hide </a> ';
                                            }
                                        }
                                    } 

                        echo '  </div><br>

                                <div class="row-fluid">
                                <div name="comment-updated">    '.$row2['comment_content'].'  </div>
                                </div>

                                <div class="row-fluid">
                                    <br><hr> Last updated: '.date_to_display_hours($row2['comment_last_updated']).'
                                </div>
                            </td> 

                        </tr>

                    </table>

                </div>
               ';
        }
    }


require_once('./includes/footer.php');
?>

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

