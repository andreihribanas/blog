<?php

$conn = new dbPDO;
$date = date("Y-m-d");
$time = date("H:i:s");

	$ip = get_ip();
	$year = date("Y");
	$month = date("m");
	$day = date("d");
	
	
class dbPDO extends PDO {
	
	private $connection;
	
	public function __construct() {
		
		$this->connection = new PDO('mysql:host=localhost;dbname=ss;charset=utf8mb4', 'root', '1234');
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->connection->setAttribute(PDO::ATTR_PERSISTENT, true);
	}	
	
	public function addDocument($name, $type, $frequency) {
		// Define and run query for registering new user
		$this->stmt = $this->connection->prepare("INSERT INTO documents(doc_name, doc_type, doc_frequency) VALUES(:field1,:field2,:field3)");
		$this->stmt->execute(array(':field1' => $name, ':field2' => $type, ':field3' => $frequency));
	}
}  

// Function reused from other source, link https://css-tricks.com/snippets/php/sanitize-database-inputs/
function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
	$input = filter_var($input, FILTER_SANITIZE_STRING);
	$output = preg_replace($search, '', $input);
	$output = trim($output);
    $output = stripslashes($output);
    $output = htmlspecialchars($output);

    return $output;
}

// Function reused from other source, link https://css-tricks.com/snippets/php/sanitize-database-inputs/
function sanitize($input) {
	global $con;
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysqli_real_escape_string($con,$input);
    }
    return $output;
}


// Function reused from an open source, link https://richardathome.wordpress.com/2006/03/28/php-function-to-return-the-number-of-days-between-two-dates/
function dateDiff($start, $end) {
	
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return abs(round($diff / 86400));
}


function displayHeader() {
	
	echo "
	<!DOCTYPE html>
	<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">
    <head>
        <title> EXAMINATION SETTING MANAGEMENT SYSTEM </title>
        <meta charset=\"UTF-8\">
		<meta name=\"HandheldFriendly\" content=\"true\" />
		<meta name=\"viewport\" content=\"width=device-width, height=device-height, user-scalable=no\" >
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css/design.css\">
		<script type=\"text/javascript\" src=\"javascript/js.js\"></script>
   
    </head>
	
		
		 <header class=\"header\">
			<img id=\"logo\" src=\"images/c3.jpg\" width=\"20%\"  alt=\"Not working...\"/>
			". displayLoggedDetails() . "
            <p id=\"title\"> EXAMINATION SETTING MANAGEMENT SYSTEM <br><br> SCHOOL OF MATHEMATICS, COMPUTER SCIENCE & ENGINEERING </p>
        </header>
	
	"; 
	if (isset($_SESSION['staff_role'])) {
		addLinks($_SESSION['staff_role']);
	} 
	"<body>";
}

function displayFooter() {
		
	echo "
		<div class=\"nav_bar\">
			<nav>
					<ul id=\"drop-nav\">
					  <li><a href=\"#\"> ABOUT </a></li>
					  <li><a href=\"#\"> CONTACT </a></li>
					  <li><a href=\"faq.php\"> FAQ & USER MANUAL </a></li>
			</nav>
        </div>
		
        <footer class=\"footer\">
            <h6> &copy; 2015-2016 COPYWRIGHT . ALL RIGHTS RESERVED. </h6>
            <h6> DESIGNED BY ANDREI HRIBANAS </h6>
			
        </footer>
		
	</body>
	</html> ";
}

function displayLoggedDetails() {
	if (isset($_SESSION['name'])  && isset($_SESSION['surname'] )  ) {
		echo "<p id=\"log\"> Logged in as: <label id=\"label_login_name\"><a href=\"logout.php\"><span> " .$_SESSION['name']. " " . $_SESSION['surname']. " (" . ucfirst($_SESSION['staff_role']) .  ")</span></a></li></label><p> ";
	}
}

// Display tabs accordingly to user credentials
function addLinks($role) {

	$administrator = array('examination papers area' => array('upload_form' => 'upload examination paper', 'upload_display_files' => 'view uploaded documents', 
							'feedback_view' => 'view examination papers feedback', 'papers_satisfaction' => 'Rate examination papers') ,
						
						'reports' => array('reports_login_history' => 'View login history',
									'reports_papers_progress' => 'View examination papers progress',
									'reports_late_papers' => 'View late examination papers',
									'reports_papers_satisfaction' => 'View examination papers satisfaction'),
									
						'administration' => array('admin_dashboard' => 'Administration dashboard',
											'staff_dashboard' => 'Staff dashboard',
											'module_dashboard' => 'Modules dashboard',
											'papers_dashboard' => 'Examination papers dashboard',
											'deadlines_scheduler' => 'Deadlines scheduler',
											'announcement_post' => 'Post announcement',
											'db_maintenance' => 'Database maintenance')
						);
	
	$module_leader = array('examination papers area' => array('upload_form' => 'upload examination paper', 'upload_display_files' => 'view uploaded documents', 'feedback_view' => 'view examination papers feedback', 'papers_satisfaction' => 'Rate examination papers') );
	$external_examiner = array('examination papers area' => array('upload_display_files' => 'view uploaded documents', 'feedback_view' => 'view examination papers feedback', 'papers_satisfaction' => 'Rate examination papers') );
	$moderator = array('examination papers area' => array('upload_display_files' => 'view uploaded documents', 'feedback_view' => 'view examination papers feedback', 'papers_satisfaction' => 'Rate examination papers') );

	$it = array( 'reports' => array('reports_login_history' => 'View login history'));
	$qaa = array ('reports' => array('reports_papers_satisfaction' => 'View examination papers satisfaction'));
	
	echo "
			<div class=\"nav_bar\">
					<nav>
						<ul id=\"drop-nav\">";

	switch($role) {
		
		case $role:
			echo "<li><a href=\"main.php\"> HOME </a> </li>";
			foreach ($$role as $ai => $ais) {
				echo "<li><a href=\"#\"> ".htmlentities(strtoupper($ai))." </a> <ul>";
						foreach ($ais as $key => $val) {
							echo "<li><a href=\" ".htmlentities($key.".php"). " \"> " . ucfirst($val) . " </a>  ";
						}
				echo " </ul></li> ";		
			}
		break;
	}	
		echo "</ul>
				</nav>
			</div> ";
}


// Get client IP address, function reused from other source, link http://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
function get_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function get_ip2() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

// Record each loggin attempt, either succesful or failed; useful to track hacking attempts
function recordLoginHistory($type) {

	// Database connection details
	global $con;

	$date = date("Y-m-d");
	$time = date("H:i:s");
	$ip = get_ip();
	$year = date("Y");
	$month = date("m");
	$day = date("d");
	
	$query = "INSERT INTO login_history (login_name, login_ip, date, time, type) 
		VALUES ('$_POST[email]', '$ip', '$date', '$time', '$type' )";

	if ($con->query($query) != TRUE) {
		echo "Error: " . $sql . "<br>" . $con->error;
	}

}

// Record every attempt of login in the application, especially the failed attempt which will be used to disable the account temporarily 
// in case of numerous failed attempts (protect against brute force attacks)
function displayLoginHistory() {

	global $con;

	$query = "SELECT *	FROM login_history ";
	$result=  mysqli_query($con, $query);
	
	echo "<h1 id=\"pp\"> LOGIN ATTEMPTS HISTORY </h1>";
	
	echo "<table>";
	echo "<th id=\"table_header\"> Entry no </th id=\"table_header\"> <th id=\"table_header\"> Login name </th id=\"table_header\"> <th id=\"table_header\"> Login IP </th> <th id=\"table_header\"> Date attempt </th> 
			<th id=\"table_header\"> Time attempt </th>
			<th id=\"table_header\"> Login type </th>  ";
	
		while ($row = mysqli_fetch_array($result)) {
			$entry_id = $row['ID'];
			$login_name = $row['login_name'];
			$login_ip = $row['login_ip'];
			$date = $row['date'];
			$time = $row['time'];
			$type = $row['type'];
			
			echo "<tr>";
			echo "<td> $entry_id </td>";
			echo "<td> $login_name </td>";
			echo "<td> $login_ip </td>";
			echo "<td> $date </td>";
			echo "<td> $time </td>";
			echo "<td> $type </td>";
			echo "</tr>";
		} 
	echo "</table>";
}


// Toggle the error message content to display if it is set
function showErrorMsg() {
	if (isset($_SESSION['error']) ){
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
}


?>