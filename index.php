
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
                  <?php   
                    try {

                        $stmt = $con-> query('SELECT * FROM posts ORDER BY postID DESC');

                        while ($row = $stmt -> fetch()) {

                            echo '<div class="container-fluid">';
                                  echo  '<h1 class="post-title"> <strong> ' . $row['post_title'] . ' </strong></h1>
                                    <h5 class="post-date"> '.date('jS M Y H:i:s', strtotime($row['post_date'])).'  Added by: ' .   isset($_SESSION['username']) . ' </h5>
                                    <h5 class="post-description"> '.$row['post_description'].' </h5>
                                    <a href="viewpost.php?id='.htmlspecialchars($row['postID']).'"> Read More </a>
                                    <hr><br>';
                            echo '</div>';
                        }

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                ?>
            </div> 
               
            
            <div class="col-md-4 panel-right">
               
                <div>
                    <p> Latest posts </p>
                    <ul class="align-left">
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                    </ul>
                </div>        
                
                <br>
                
                <div>
                    <p> Popular posts </p>
                    <ul>
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                    </ul>
                </div>
                
                <br>
                
                <div>
                    <p> Useful links </p>
                    <ul>
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                        <li> test </li>
                    </ul>
                
                </div>
                
                <br>
                
                <div>
                    <p> Archive </p>
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

