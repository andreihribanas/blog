<?php 
require_once('./includes/header.php');


    // Execute query to retrieve the post details
    $stmt = $con->prepare('SELECT * FROM posts WHERE postID = :postID');
    $stmt->execute(array(':postID' => $_GET['id']));
    $row = $stmt->fetch();



    
    
    // Check if the post exists, otherwise redirect user to home page
    if($row['postID'] == ''){
        header('Location: ./');
        exit;
    }

    // Display the post in full
            echo '
            <div class="container">
            
                <div class="col-md-12"> 
                    <a href="index.php" class="menu-item"> Home </a> <hr>
                </div> <br>
            
                <div class="container-fluid">
                    <div class="row-fluid text-center">
                        <h1>'.$row['post_title'].'</h1>
                        <p>Posted on '.date('jS M Y', strtotime($row['post_date'])).'</p>
                        <p> '.$row['post_content'].' </p>
                    </div>

                </div>
            </div>
            
            ';

   
     // Add a new comment
    echo '
    <form action="add-comment.php" method="post">
        <div class="container c">
            <input type="hidden" name="postID" value="'.$_GET['id'].'">
             
             <hr>
            <div class="row">
                <div class="col-md-12">
                    <h3> <strong> Reply area </strong> </h3>
                </div>
            </div>
        
            <div class="row">
            
                <div class="col-md-8">
                    <textarea class="form-control" name="comment"> </textarea>
                </div>
            </div>  
            
            <br>

            <div class="row">
                <div class="col-md-4">
                    <input type="submit" name="submit" class="btn-primary" value="Post quick reply">
                </div>
            </div>
        </div>
        </form>
        ';


    // Display existing comments 
    $stmt2 = $con->prepare('SELECT * FROM comments WHERE postID = :postID ORDER BY comment_date DESC');
    $stmt2->execute(array(':postID' => $_GET['id']));

    while ($row2 = $stmt2->fetch()){
        
        echo '
            <div class="container">
                <hr>
                
                
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-2 outline">
                            <p> '. $row2['comment_author'] .' </p>
                        </div>

                        <div class="col-md-1"> </div>

                        <div class="col-md-9 outline">
                          <a href="#"> Edit comment | </a> 
                           <a href="#"> Delete comment </a> 
                            <p> Content: '.$row2['comment_content'].'</p>
                        </div>
                    </div>

                </div>
                <hr>

            </div> ';
       
    }


require_once('./includes/footer.php');
?>


    