
<?php require_once('./includes/header.php'); ?>

<!----- IMPORT PAGE HEADER ----------------------->

    <div class="container">
        <div class="row">
                <div class="col-md-12"> 
                    <?php load_menu(); ?>
                    <hr>
                </div>
        </div> 
  
        
        <div class="row message">
            <?php showMessage(); ?>
        </div>
    </div>
    
    <div class="container">
     
            <div class="col-md-8 panel-left">
                <hr>
                
                
           <!--     <div class="container-fluid post-layout">
                    <div class="col-md-2 post-layout-col">
                        <img src="sdfs" alt="The image could not be loaded.">
                    </div>
                    
                    <div class="col-md-8 post-layout-col">
                        <div class="row">
                            <a href="viewpost.php?id='.htmlspecialchars($row['postID']).'"> <h1 class="post-title"> <strong> ' . $row['post_title'] . ' </strong></h1></a>
                        </div>         
                        
                        <div class="row">
                            <h5 class="post-description"> '.$row['post_description'].' </h5>
                        </div>         
                        
                        <div class="row">
                            <h5 class="post-date"> Created on:  '.date('jS M Y H:i:s', strtotime($row['post_date'])).' | Last updated </h5>
                        </div>
                    </div>
                    
                    <div class="col-md-2 post-layout-col">
                        
                        <div class="row">
                            <p> <a href=""> Last comment </a></p>
                        </div>
                        
                        <div class="row">
                            <p> posted by</p>
                        </div>
                    </div>          
                </div>
                -->
                
                
                  <?php   
                    try {

                        $stmt = $con-> query('SELECT * FROM posts ORDER BY post_class DESC, postID DESC');

                        while ($row = $stmt -> fetch()) {
                            
                            // Show only active posts to users and all to admin
                            if ( $row['post_active'] || $_SESSION['role'] === 'admin'){
                            
                                    echo '<div class="container-fluid">';
                                          echo  '<h1 class="post-title"> <strong> '. check_sticky($row['post_class']) . $row['post_title'] . ' </strong></h1>
                                                <h5 class="post-description text-muted"> '.$row['post_description'].' </h5>
                                                <h6 class="post-date"> <strong> Author: </strong>' .   get_post_author($row['postID'], $con) . ' </h6>
                                                <h6 class="post-date"> <strong> Created on:  </strong>'.date_to_display($row['post_date']).' | Last updated: '.date_to_display($row['post_last_updated']).' </h6>
                                                <a href="viewpost.php?id='.htmlspecialchars($row['postID']).'" class="btn btn-primary"> Read More </a>
                                            <hr><br>';
                                    echo '</div>';
                                
                            }
                            
                        }

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                ?>
            </div> 
               
            
            <div class="col-md-4 panel-right">
               
                <div class="container panel-right-module">
                    <h3> <strong> Latest posts </strong> </h3> <br>
                    <ul class="align-left">
                        <?php
                            try {
                                $latestPosts = $con-> prepare('SELECT postID, post_title FROM posts ORDER BY post_date DESC LIMIT 5'); 
                                $latestPosts -> execute();
                                while($row3 = $latestPosts -> fetch()){
                                    echo '<li> <a href="viewpost.php?id='.$row3['postID'].'"> '.$row3['post_title'].' </a> </li> ';
                                }
                            } catch (PDOException $e) {
                                echo $e;
                            }
                        ?>
                    </ul>
                </div>   
                
                
                <br>
                
                <div class="container panel-right-module">
                    <h3> <strong> Hottest posts </strong> </h3><br>
                    <ul class="align-left">
                         <?php
                            try {
                                $latestPosts = $con-> prepare('SELECT postID, post_title, post_replies FROM posts WHERE post_replies > 0 ORDER BY post_replies DESC LIMIT 10'); 
                                $latestPosts -> execute();
                                while($row3 = $latestPosts -> fetch()){
                                    echo '<li> <a href="viewpost.php?id='.$row3['postID'].'"> '.$row3['post_title'].' (replies: '.$row3['post_replies'].') </a> </li> ';
                                }
                            } catch (PDOException $e) {
                                echo $e;
                            }
                        ?>
                    </ul>
                
                </div>
                
                <br>
                
                <div class="container panel-right-module">
                    <h3> <strong> Most viewed </strong></h3><br>
                    <ul class="align-left">
                       <?php
                        try {
                            $latestPosts = $con-> prepare('SELECT postID, post_title, post_views FROM posts WHERE post_views > 0 ORDER BY post_views DESC LIMIT 10'); 
                            $latestPosts -> execute();
                            while($row3 = $latestPosts -> fetch()){
                                echo '<li> <a href="viewpost.php?id='.$row3['postID'].'"> '.$row3['post_title'].' (views: '.$row3['post_views'].') </a> </li> ';
                            }
                        } catch (PDOException $e) {
                            echo $e;
                        }
                    ?>
                    </ul>
                </div>
                
                <br>
                   
                <div class="container panel-right-module">
                    <h3> <strong> Top commenters </strong> </h3><br>
                    <ul class="align-left">
                        <?php
                            try {
                                $mostComments = $con-> prepare('SELECT username, comments_number FROM users WHERE comments_number > 0 ORDER BY comments_number DESC LIMIT 10'); 
                                $mostComments -> execute();
                                while($row4 = $mostComments -> fetch()){
                                    echo '<li> '.$row4['username'].': '.$row4['comments_number'].' (comments) </li> ';
                                }
                            } catch (PDOException $e) {
                                echo $e;
                            }
                        ?>
                    </ul>
                </div>
                
                 <br>
                
                <div class="container panel-right-module">
                    <h3> <strong> Archive </strong> </h3><br>
                    <ul class="align-left">
                        <li> <a href="archive-december"> January 2017 </a> </li>
                        <li> <a href="archive-december"> December 2016 </a> </li>
                        <li> <a href="archive-december"> November 2016 </a> </li>
                        <li> <a href="archive-december"> October 2016 </a> </li>
                        <li> <a href="archive-december"> September 2016 </a> </li>
                    </ul>
                </div>
                
               
                
            </div>
  

    </div>
        
         <div class="row"> <br> </div>

<!------     IMPORT THE PAGE FOOTER ------>
<?php require_once('./includes/footer.php'); ?>


    <script type="text/javascript">
            
           $(document).ready(function() {
            $("#btnLogin").click(function(e){
                e.preventDefault();
                
                if ($(".login").css("display") == "none") {
                    $(".login").css("display", "block");
                } else {
                    $(".login").css("display", "none");
                }
            }); 
        });
                
            
    </script>

