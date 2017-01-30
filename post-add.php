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
        
        $error = '';
        
        if ($postTitle == ''){
            $error .= 'Please enter the title.' ;
        }
        
        if ($postDesc == ''){
            $error .= 'Please enter the description.' ;
        }
        if ($postCont == ''){
            $error .= 'Please enter the content.' ;
        }

            $post->addPost($postTitle, $postDesc, $postCont);
    }


?>

<?php require_once('./includes/header.php');?>

    <div class="container">
        
        <div class="col-md-12"> 
            <a href="index.php" class="menu-item"> Home </a> <hr>
        </div> <br>
        
        
        <form action='' method='post'>

            <p><label>Title</label><br />
            <input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

            <p><label>Description</label><br />
            <textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

            <p><label>Content</label><br />
            <textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

            <p><input type='submit' name='submit' value='Submit'></p>
            
            <div> </div>
            
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