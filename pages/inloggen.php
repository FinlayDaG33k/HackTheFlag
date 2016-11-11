<div class="container-fluid">
	<?php if($_GET['invalidcredentials'] == "true"){ ?>
		<div class="alert alert-dismissible alert-danger">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Mislukt!</strong> Ongeldige Gebruikersnaam/Wachtwoord combinatie. Probeer het nog eens!
		</div>
	<?php } ?>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title"><?= LANG_LOGIN_LOGIN; ?></h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" action="//<?= $_SERVER[HTTP_HOST]; ?>/inc/php/login.php" method="POST">
						<fieldset>
							<div class="form-group">
								<label for="inputEmail" class="col-lg-2 control-label"><?= LANG_LOGIN_USERNAME; ?></label>
								<div class="col-lg-10">
									<input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="<?= LANG_LOGIN_USERNAME; ?>" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="col-lg-2 control-label"><?= LANG_LOGIN_PASSWORD; ?></label>
								<div class="col-lg-10">
									<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="<?= LANG_LOGIN_PASSWORD; ?>" autocomplete="off" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember"> <?= LANG_LOGIN_REMEMBERME; ?> (TODO)
										</label>
									</div>
									<br /><div class="g-recaptcha" data-sitekey="6LecLAsUAAAAAD4J6GtP5n9k_wKz_qKQvB4ZJFlW"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<input type="hidden" name="method" value="login">
									<button type="reset" class="btn btn-default"><?= LANG_LOGIN_CANCEL; ?></button>
									<button type="submit" class="btn btn-primary"><?= LANG_LOGIN_SUBMIT; ?></button><br /><br />
									<a href="#"><?= LANG_LOGIN_FORGOTPASSWORD; ?> (TODO)</a>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>