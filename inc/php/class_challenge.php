<?php 
if(!empty($_POST['inputFlag']) && !empty($_POST['username'])){
		include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php');
		$conn = mysqli_connect($sql_servername,$sql_username,$sql_password,$sql_dbname);
	
		if (mysqli_connect_errno()){
			echo "MySQLi Connection was not established: " . mysqli_connect_error();
		}
		
		$check_solved = "SELECT * FROM logs WHERE `Username`='".mysqli_real_escape_string($conn,$_POST['username'])."' AND `Challenge`='".$challenge_ID."' AND `Solved`='1'";
		$result = $conn->query($check_solved);
		if($result->num_rows > 0){
			?>
				<div class="alert alert-dismissible alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Hmm...</strong><br />Je hebt deze challenge al opgelost! probeer een andere!
				</div>
			<?php
		}else{
			include('flag.php');
			if($SERVER_FLAG == $_POST['inputFlag']){
				$solved = 1;
			}else{
				$solved = 0;
			}
			$add_log = "INSERT INTO `logs` (`ID`, `Username`,`Challenge`, `Flag`, `Solved`, `Date`) VALUES (NULL, '".mysqli_real_escape_string($conn,$_POST['username'])."','".$challenge_ID."', '".mysqli_real_escape_string($conn,$_POST['inputFlag'])."', '".mysqli_real_escape_string($conn,$solved)."', '".date("Y-m-d H:i:s")."');"; // SQL to get the flag
			$void = $conn->query($add_log);
			
			if($solved == 1){
				$check_points = "SELECT * FROM logs WHERE `Challenge`='".$challenge_ID."' AND `Solved`='1'";
				$result = $conn->query($check_solved);
				if($result->num_rows <= 1){
					$points = 7;
				}elseif($result->num_rows == 2){
					$points = 5;
				}elseif($result->num_rows == 3){
					$points = 3;
				}elseif($result->num_rows >= 4){
					$points = 1;
				}
				
				$award_points = "UPDATE `users` SET `points` = points + ".$points." WHERE `Username` = '".mysqli_real_escape_string($conn,$_POST['username'])."'";
				$void = $conn->query($award_points);
				?>
				<div class="alert alert-dismissible alert-success">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <strong>Well done!</strong><br />Je hebt deze flag met success gekraakt! Je hebt hiervoor <?= $points; ?> punten gekregen!
				</div>
				<?php
			}else{
				?>
					<div class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Incorrect!</strong><br />De Flag die je hebt gestuurd is helaas fout. Probeer het nog eens!
					</div>
				<?php
			}
		}
}
?>