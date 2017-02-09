<?php
if(isset($_POST['g-recaptcha-response'])){
    include($_SERVER["DOCUMENT_ROOT"] . '/config.inc.php');
    $captcha=$_POST['g-recaptcha-response'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$google_site_key."&response=".$captcha."&remoteip=".$_SERVER["HTTP_CF_CONNECTING_IP"]);
    $responseKeys = json_decode($response,true);
	if(intval($responseKeys["success"]) !== 1) {
		echo 'Er is iets mis gegaan met de captcha. Ga terug en probeer het opnieuw!';
	} else {
        if($_POST['method'] == "resetpasswd"){
            $conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM `users` WHERE `Username`='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."' AND `Email`='".mysqli_real_escape_string($conn,$_POST['inputEmail'])."';";
            $sql_output = $conn->query($sql);
            if ($sql_output->num_rows > 0){
                
                require ('PHPMailerAutoload.php');
                require ('class.htf.php');
                $hacktheflag = new HackTheFlag();
                $row = $sql_output->fetch_assoc();
                $token = $hacktheflag->generateRandomString(32);
                $sql = "UPDATE `users` SET `reset_hash` = '".mysqli_real_escape_string($conn,$token)."' WHERE `Username`='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."' AND `Email`='".mysqli_real_escape_string($conn,$_POST['inputEmail'])."';";
                if ($conn->query($sql) === TRUE) {
                    //Create a new PHPMailer instance
                    $mail = new PHPMailer;
                    //Tell PHPMailer to use SMTP
                    $mail->isSMTP();
                    //Enable SMTP debugging
                    // 0 = off (for production use)
                    // 1 = client messages
                    // 2 = client and server messages
                    $mail->SMTPDebug = 0;
                    //Ask for HTML-friendly debug output
                    $mail->Debugoutput = 'html';
                    //Set the hostname of the mail server
                    $mail->Host = 'tls://mail.gmail.com:587';

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    // use
                    // $mail->Host = gethostbyname('smtp.gmail.com');
                    // if your network does not support SMTP over IPv6
                    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                    $mail->Port = 587;
                    //Set the encryption system to use - ssl (deprecated) or tls
                    $mail->SMTPSecure = 'tls';
                    //Whether to use SMTP authentication
                    $mail->SMTPAuth = true;
                    //Username to use for SMTP authentication - use full email address for gmail
                    $mail->Username = "JFK@G0T360N0SC0P3D.MLG";
                    //Password to use for SMTP authentication
                    $mail->Password = "I360N0SC0P3DJFK";
                    //Set who the message is to be sent from
                    $mail->setFrom('noreply@finlaydag33k.nl', 'FinlayDaG33k NoReply');
                    //Set an alternative reply-to address
                    $mail->addReplyTo('contact@finlaydag33k.nl', 'HackTheFlag Contact');
                    //Set who the message is to be sent to
                    $mail->addAddress(htmlentities($row['Email']), htmlentities($_POST['inputUsername']));
                    //Set the subject line
                    $mail->Subject = 'HackTheFlag Wachtwoord Reset';
                    //Read an HTML message body from an external file, convert referenced images to embedded,
                    //convert HTML into a basic plain-text alternative body
                    $resetlink = "https://" . $_SERVER['SERVER_NAME'] . "/?action=forgotpassword&username=" . $_POST['inputUsername'] . "&token=" .$token;
                    $mail->msgHTML("Beste " . $_POST['inputUsername'] . ",<br /> Hier is het linkje om je wachtwoord van HackTheFlag opnieuw in te stellen: <br /> <a href=\"".$resetlink."\">".$resetlink."</a> <br /><br /><br />Mvg, FinlayDaG33k", dirname(__FILE__));
                    //Replace the plain text body with one created manually
                    $mail->AltBody = 'Wachtwoord vergeten';
                    //send the message, check for errors
                    if (!$mail->send()) {
                        //echo "Mailer Error: " . $mail->ErrorInfo;
                        echo "Er iets mis gegaan! probeer het later opnieuw";
                    } else {
                        echo "Gelukt! Binnen 5 minuten ontvang je een link om je wachtwoord te resetten!";
                    }
                }else{
                    echo "Er iets mis gegaan! probeer het later opnieuw";
                }
            }else{
                echo "Gebruikersnaam/email combinatie niet gevonden!";
            }
        }elseif($_POST['method'] == "changepasswd"){
            if($_POST['inputPassword'] == $_POST['inputPasswordConfirm']){
                $conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM `users` WHERE `Username`='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."' AND `reset_token`='".mysqli_real_escape_string($conn,$_POST['inputToken'])."';";
                $sql_output = $conn->query($sql);
                if ($sql_output->num_rows > 0){
                    $sql = "UPDATE `users` SET `Password` = '".password_hash($_POST['inputPassword'],PASSWORD_DEFAULT)."', `reset_token`='' WHERE `Username`='".mysqli_real_escape_string($conn,$_POST['inputUsername'])."' AND `reset_token`='".mysqli_real_escape_string($conn,$_POST['inputToken'])."';";
                    if ($conn->query($sql) === TRUE) {
                        echo "Wachtwoord met success opnieuw ingesteld!";
                    }else{
                        echo "Er iets mis gegaan! probeer het later opnieuw";
                    }
                }else{
                    echo "Ingevoerde gebruikersnaam en token komen niet overeen!";
                }
            }else{
                echo "ingevoerde wachtwoorden komen niet overeen!";
            }
        }
    }
}else{
    echo "Captcha niet aanwezig?";
}
?>