
<?php

require_once('./includes/config.php');
require_once './libraries/is_email.php';

	//	$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
//		extract($_POST);
//
  //  foreach($_POST as $a){
 ////       echo '<br> ' .$a;
 //   }
//

  //  echo password_hash('123', PASSWORD_DEFAULT, ['cost' => 11]);
            echo '<td><a href="staff_delete.php?id=' . $id . '" onclick="return confirm("Are you sure?")" > Delete  </a></td>';

    add_activity($con, 'sssd', 'dfdfd');

?>


<table class="table table-bordered table-striped">

    <tr>
        <td> first col </td>
        <td> second col </td>
        <td> third col </td>
    </tr>

</table>

