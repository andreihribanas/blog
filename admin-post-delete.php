<?php

require_once('./includes/config.php');

    $post->deletePost($_GET['id']);
    header('Location: admin-post-view.php');
?>


