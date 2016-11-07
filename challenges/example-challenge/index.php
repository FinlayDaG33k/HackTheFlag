<?php 
session_start();
include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php'); 
$challenge_ID = 9;
?>
<head>
	<title>Challenge-<?= $challenge_ID; ?> - HackTheFlag!</title>
	<link rel="stylesheet" href="<?= "//" . $_SERVER[HTTP_HOST]; ?>/inc/css/bootstrap.min.css">
	<script src="<?= "//" . $_SERVER[HTTP_HOST]; ?>/inc/js/jquery-3.1.1.min.js"></script>
	<script src="<?= "//" . $_SERVER[HTTP_HOST]; ?>/inc/js/bootstrap.min.js"></script>
</head>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/inc/php/navbar.php'); ?>
<div class="container">
<?php
if($_SESSION['loggedin'] == false || !isset($_SESSION['loggedin'])){
	echo "Log eerst in om mee te doen!";
}else{
	include($_SERVER['DOCUMENT_ROOT'] . '/inc/php/class_challenge.php'); 
?>

<a href="dl/index.php" target="_blank">Start de Challenge!</a>
<br />
<br />
<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<fieldset>
    <legend>Challenge-<?= $challenge_ID; ?></legend>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Flag</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="inputFlag" placeholder="Voer hier de gevonden flag in!" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
		<input type="hidden" name="username" value="<?= htmlspecialchars($_SESSION['username']); ?>">
	  </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
<?php } ?>
</div>
