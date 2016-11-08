<?php 
ini_set('session.gc_maxlifetime', 3600);
session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php'); 

include($_SERVER["DOCUMENT_ROOT"] . '/lang/' . $language . ".php"); 

$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT SessionID FROM `users` WHERE Username='".mysqli_real_escape_string($conn,$_SESSION['Username'])."' AND SessionID='".mysqli_real_escape_string($conn,session_id())."';";
$sql_output = $conn->query($sql);
if ($sql_output->num_rows > 0) {}else{
	session_destroy();
}

$disallowed_paths = array('header', 'footer'); 
if (!empty($_GET['action'])) {
	$tmp_action = basename($_GET['action']);
	if (!in_array($tmp_action, $disallowed_paths) && file_exists("pages/{$tmp_action}.php")) {
		$action = $tmp_action;
	} else {
		$action = error;
	}
}else{
    $action = 'home';
}
?>

<head>
	<title>Home - HackTheFlag!</title>
	<link rel="stylesheet" href="//<?= $_SERVER[HTTP_HOST]; ?>/inc/css/bootstrap.min.css">
	<link rel="stylesheet" href="//<?= $_SERVER[HTTP_HOST]; ?>/inc/css/assets.css">
	<script src="//<?= $_SERVER[HTTP_HOST]; ?>/inc/js/jquery-3.1.1.min.js"></script>
	<script src="//<?= $_SERVER[HTTP_HOST]; ?>/inc/js/bootstrap.min.js"></script>
	<script src="//use.fontawesome.com/9c6f3ac0ed.js"></script>
	<script src='//www.google.com/recaptcha/api.js'></script>
</head>

<body>
	<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/inc/php/navbar.php');
	include("pages/$action.php"); 
	$conn->close();
	?>
	<footer>
		<div id="btcAddr"><span id="addr">17f77AYHsQbdsB1Q6BbqPahJ8ZrjFLYH2j</span></div>
	</footer>
</body>

