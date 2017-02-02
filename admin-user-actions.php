<?php

require_once('./includes/header.php');
    
    
    if (isset($_GET['action']) && isset($_GET['id'])){
        $id = (int)$_GET['id'];

        // CHANGE USER ROLE
        if ($_GET['action'] === 'change_role'){
            
            if (isset($_POST['role_change'])) {
                $user -> changeUserRole($id, $_POST['user-role']);
            }
            
            
            echo '
                <div class="container">
                    <h1> <strong> CHANGE USER ROLE </strong></h1> <br>

                
                    <form method="POST">
                        <div class="row form-group">
                            <label class="form-label"> </strong> Select an user role: </strong> </label>
                            <select class="form-control" name="user-role">
                                <option value="user"> User </option>
                                <option value="moderator"> Moderator </option>
                                <option value="admin"> Administrator </option>
                            </select>
                        </div>
                        
                        <br>
                        
                        <div class="row form-group align-center">
                            <input type="submit" name="role_change" value="Update user role" class="btn btn-primary">
                        </div>
                        
                    </form>
                </div>
            ';
        }


        //DISABLE or ENABLE USER
        if ($_GET['action'] === 'status'){
            //$user -> disableUser($id);
            $user -> toggleUserStatus($id);
        }


        //DELETE USER
        if ($_GET['action'] === 'delete'){
            $user->deleteUser($id);
            header('Location: admin-user-view.php');
        }
    }













require_once('./includes/footer.php');
?>


