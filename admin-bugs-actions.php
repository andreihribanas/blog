<?php 

require_once('./includes/config.php');

    if (isset($_GET['bug_id'])) {
    
        
        // Update bug status
       echo $_GET['bug_id'];
        
        
        
        // Mark the bug as solved
        if ($_GET['action'] === 'solve') {
             try {
            $stmt = $con -> prepare('UPDATE bugs_tracking SET bug_status = :status, bug_solved_date = :solved_date WHERE bugID = :bugID');
            $stmt -> execute(array(
                        ':status' => 'solved',
                        ':solved_date' => current_date_format(),
                        ':bugID' => $_GET['bug_id']
                    ));
                         
            header('Location: admin-bugs-tracking.php');
            exit;
        
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        
       
    // Mark the bug as unsolved
        if ($_GET['action'] === 'unsolve') {
             try {
            $stmt = $con -> prepare('UPDATE bugs_tracking SET bug_status = :status, bug_solved_date = :solved_date WHERE bugID = :bugID');
            $stmt -> execute(array(
                        ':status' => 'unsolved',
                        ':solved_date' => '',
                        ':bugID' => $_GET['bug_id']
                    ));
                         
            header('Location: admin-bugs-tracking.php');
            exit;
        
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        
    }


?>