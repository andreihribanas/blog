<?php

require_once('./includes/config.php');

    $user->deleteUser($_GET['id']);
    header('Location: admin-user-view.php');
?>


