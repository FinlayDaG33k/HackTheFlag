<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if($_POST['method'] == "login"){
			if(isset($_POST['g-recaptcha-response'])){
				include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php'); 
				$captcha=$_POST['g-recaptcha-response'];
				$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$google_site_key."&response=".$captcha."&remoteip=".$_SERVER["HTTP_CF_CONNECTING_IP"]);
				$responseKeys = json_decode($response,true);
				if(intval($responseKeys["success"]) !== 1) {
					echo 'Er is iets mis gegaan met de captcha. Ga terug en probeer het opnieuw!';
				} else {
					$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}
					$sql = "SELECT * FROM `users` WHERE Username='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."';";
					$sql_output = $conn->query($sql);
					if ($sql_output->num_rows > 0) { 
						$user = $sql_output->fetch_assoc();
						if(password_verify($_POST['inputPassword'],$user['Password']) == true){
							ini_set('session.gc_maxlifetime', 3600);
							session_start();
							session_regenerate_id();
							$SessionID = session_id();
							$sql = "UPDATE users SET SessionID='".mysqli_real_escape_string($conn,$SessionID)."' WHERE Username='".mysqli_real_escape_string($conn,$user['Username'])."';";
							if ($conn->query($sql) === TRUE) {
								$_SESSION['Username'] = $user['Username'];
								$_SESSION['loggedin'] = true;
								header("Location: https://". $_SERVER['HTTP_HOST'] . "?loggedon=success");
							}else{
								header("Location: https://". $_SERVER['HTTP_HOST'] . "?action=inloggen&invalidcredentials=true");
							}
						}else{
							header("Location: https://". $_SERVER['HTTP_HOST'] . "?action=inloggen&invalidcredentials=true");
						}
					}else{
						header("Location: https://". $_SERVER['HTTP_HOST'] . "?action=inloggen&invalidcredentials=true");
					}		
					$conn->close();
				}
			}else{
				echo "Captcha niet aanwezig?";
			}
		}elseif($_POST['method'] == "register"){
			if(isset($_POST['g-recaptcha-response'])){
				include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php'); 
				$captcha=$_POST['g-recaptcha-response'];
				$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$google_site_key."&response=".$captcha."&remoteip=".$_SERVER["HTTP_CF_CONNECTING_IP"]);
				$responseKeys = json_decode($response,true);
				if(intval($responseKeys["success"]) !== 1) {
					echo 'Er is iets mis gegaan met de captcha. Ga terug en probeer het opnieuw!';
				} else {
					if (filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)){
						if($_POST['inputPassword'] == $_POST['inputPasswordConfirmation']){
							if(strlen($_POST['inputUsername']) > 16){
								echo "Gekozen gebruikersnaam is te lang!";
							}else{
								$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
								// Check connection
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
								$sql = "SELECT * FROM `users` WHERE Username='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."' OR Email='".mysqli_real_escape_string($conn,$_POST['inputEmail'])."';";
								$sql_output = $conn->query($sql);
								if ($sql_output->num_rows > 0) { 
									echo "het gekozen gebruikersnaam of email adres is al bezet!";
								}else{
									$sql = "INSERT INTO `users` (`ID`, `Username`, `Password`,`Email`, `SessionID`, `Registered`,`Registration_IP`, `Points`) VALUES (NULL, '".mysqli_real_escape_string($conn,$_POST['inputUsername'])."', '".mysqli_real_escape_string($conn,password_hash($_POST['inputPassword'], PASSWORD_DEFAULT))."', '".mysqli_real_escape_string($conn,$_POST['inputEmail'])."', NULL, '".date("Y-m-d H:i:s")."','".$_SERVER["HTTP_CF_CONNECTING_IP"]."', '0');";
									if ($conn->query($sql) === TRUE) {
										session_start();
										session_regenerate_id();
										$SessionID = session_id();
										$sql = "UPDATE users SET SessionID='".mysqli_real_escape_string($conn,$SessionID)."' WHERE Username='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."';";
										if ($conn->query($sql) === TRUE) {
											$_SESSION['Username'] = $_POST['inputUsername'];
											$_SESSION['loggedin'] = true;
											header("Location: https://". $_SERVER['HTTP_HOST'] . "?registersuccess=true");
										}else{
											header("Location: https://". $_SERVER['HTTP_HOST'] . "?registersuccess=partial");
										}
									}else{
										header("Location: https://". $_SERVER['HTTP_HOST'] . "?registersuccess=false&reason=unknown");
									}
								}		
								$conn->close();
							}
						}else{
							//header("Location: https://". $_SERVER['HTTP_HOST'] . "?registersuccess=false&reason=invalidemail");
							echo "De ingevoerde wachtwoorden komen niet met elkaar overeen!";
						}
					}else{
						//header("Location: https://". $_SERVER['HTTP_HOST'] . "?registersuccess=false&reason=invalidemail");
						echo "Ongeldig email adres!";
					}
				}
			}else{
				echo "Captcha niet aanwezig?";
			}
		}elseif($_POST['method'] == "changepassword"){
			include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php'); 
			$captcha=$_POST['g-recaptcha-response'];
			$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$google_site_key."&response=".$captcha."&remoteip=".$_SERVER["HTTP_CF_CONNECTING_IP"]);
			$responseKeys = json_decode($response,true);
			if(intval($responseKeys["success"]) !== 1) {
				echo 'Er is iets mis gegaan met de captcha. Ga terug en probeer het opnieuw!';
			} else {
				if($_POST['inputNewPassword'] == $_POST['inputNewPasswordConfirmation']){
					include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php');
					session_start();
					$conn = mysqli_connect($sql_servername,$sql_username,$sql_password,$sql_dbname);
				
					if (mysqli_connect_errno()){
						echo "MySQLi Connection was not established: " . mysqli_connect_error();
					}
					
					$sql = "SELECT SessionID FROM `users` WHERE Username='".mysqli_real_escape_string($conn,$_SESSION['Username'])."' AND SessionID='".mysqli_real_escape_string($conn,session_id())."';";
					$sql_output = $conn->query($sql);
					if ($sql_output->num_rows > 0){
						$sql = "SELECT Password FROM `users` WHERE Username='".mysqli_real_escape_string($conn,$_SESSION['Username'])."';";
						$sql_output = $conn->query($sql);
						if ($sql_output->num_rows > 0){
							$row = $sql_output->fetch_assoc();
							if(password_verify($_POST['inputOldPassword'],$row['Password'])){
								$sql = "UPDATE `users` SET `Password`='".password_hash($_POST['inputNewPassword'], PASSWORD_DEFAULT)."' WHERE `Username`='".mysqli_real_escape_string($conn,$_SESSION['Username'])."';";
								if($conn->query($sql) === TRUE){
									echo "Wachtwoord met success veranderd!";
								}else{
									echo "Er is iets mis gegaan, probeer het later nog eens!";
								}
							}else{
								echo "Ongeldig oud wachtwoord!";
							}
						}
					}
				}else{
					echo "Opgegeven nieuwe wachtwoorden komen niet met elkaar overeen!";
				}
			}
		}
	}else{
		if($_GET['action'] == "logout"){
			session_start();
			session_destroy();
			session_regenerate_id();
			header("Location: https://". $_SERVER['HTTP_HOST'] . "/?loggedout=true");
		}
	}
?>