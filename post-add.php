<?php  

require_once('./includes/config.php');

    if ( !$_SESSION['is_logged'] ){      
        $_SESSION['message'] = '<div class="alert alert-danger row-fluid"> <strong> You need to login to see this page. </strong> </div>';
        header('Location: index.php');
        exit; 
    }


    if (isset($_POST['submit'])){
        
        $_POST = array_map('stripslashes', $_POST);
        extract($_POST);

        $post_title = filter_var($_POST['post_title'], FILTER_SANITIZE_STRING);
        $post_description = filter_var($_POST['post_description'], FILTER_SANITIZE_STRING);
        $post_content = $_POST['post_content'];
        
        if (empty($post_title) || strlen($post_title) < 2){
            $_SESSION['message'] .= 'Please enter a title at least 2 characters long.' ;
        }
        
        if (empty($post_description)){
            $_SESSION['message'] .= 'Please enter the description.' ;
        }
        if (empty($post_content)) {
            $_SESSION['message'] .= 'Please enter the content.' ;
        }
        
        $post->addPost($post_title, $post_description, $post_content, $_SESSION['username']);
       
    }


?>

<?php require_once('./includes/header.php');?>

    <div class="container">
        
        <div class="col-md-12"> 
            <a href="index.php" class="menu-item"> Home </a> <hr>
        </div> <br>
        
        
        <form method="POST">

            <div class="form-group">
                <div class="row-fluid">
                    <label class="form-label"><strong> Title </strong></label>
                </div>
                
                <div class="row-fluid">
                    <input type="text" name="post_title" class="form-control" value=""> 
                </div>  
            </div>

            <br>
            
            <div class="form-group>">
                <div class="row-fluid">
                    <label class="form-label"><strong> Description </strong></label>
                </div>           
                
                <div class="row-fluid">
                    <textarea name="post_description" cols="60" rows="2" class="form-control">  </textarea>
                </div>
            </div>
           
            <br>
             
            <div class="form-group>">
                <div class="row-fluid">
                    <label class="form-label"><strong> Content </strong></label>
                </div>           
                
                <div class="row-fluid">
                    <textarea name="post_content" cols="60" rows="10" class="form-control"> </textarea>
                </div>
            </div>
            
            <br>
            
            <div class="form-group>">        
                <div class="row-fluid align-center">
                    <input type="submit" name="submit" value="Add post" class="btn btn-primary btn-lg">
                </div>
            </div>

            
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





<?php  require_once('./includes/footer.php');?>