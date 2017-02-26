<?php 

require_once('./includes/config.php');


?>

<!DOCTYPE HTML>
<html lang="en">
    
    <head>
        <title> BLOG </title>
         <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=yes, user-scalable=yes">
        <meta http-equiv="x-ua-compatible" content="ie=edge, chrome=1">
		<meta name="HandheldFriendly" content="true">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="./includes/style.css">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
		<script type="text/javascript" src="scripts/script.js"></script>
    </head>
  
	
	
    <body >
    
         <header id="header">
            <div class="jumbotron jumbotron-border jumbotron-inversed">
                <div class="container  jumbotron-top">
                    <div class="row">
                        <div class="col-lg-12 text-center">  

                            <h1> <strong> BLOG SAMPLE </strong> </h1> <br>
                            <h3> <strong> CONSTANTIN ANDREI HRIBANAS </strong> </h3>
                            <br>
                            <p> <strong> Logged in as: </strong> <?php 
                                    if (isset($_SESSION['username'])){
                                        echo '<a href="user-profile-view.php"> '.$_SESSION['username'].' ('. $_SESSION['role'] .' ) <a href="logout.php"> <strong> Logout </strong> </a>  </a>';
                                    } else {
                                        echo '<a href="login.php"> Not logged in. </a>';
                                    }
                                ?> </p>
                        </div>
                    </div>
                </div>
            </div>   
        </header>
        
       