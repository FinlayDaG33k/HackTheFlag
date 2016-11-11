<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">HTF</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="/index.php?action=rules">Regels</a></li>
        <li><a href="https://github.com/FinlayDaG33k/HackTheFlag" target="_new">Github</a></li>
        <li><a href="https://forum.finlaydag33k.nl/forumdisplay.php?fid=87" target="_new">Support</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Doet nii :D">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mijn Account <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php if(!empty($_SESSION['Username'])){
				$sql = "SELECT Points, Username FROM users WHERE `Username`='".mysqli_real_escape_string($conn,$_SESSION['Username'])."';";
				$sql_output = $conn->query($sql);
				if ($sql_output->num_rows > 0) {
					$row = $sql_output->fetch_assoc();
					$points = htmlentities($row['Points']);
				}else{
					$points = "???";
				}
			?>
			
				<li><a href="#">Welkom, <?= htmlentities($_SESSION['Username']); ?></a></li>
				<li class="divider"></li>
				<li><a href="#">Punten: <?= $points; ?></a></li>
				<li><a href="#">Opgeloste Challenges: (TODO)</a></li>
				<li class="divider"></li>
				<li><a href="//<?= $_SERVER[HTTP_HOST]; ?>/?action=changepassword">Wachtwoord Veranderen</a></li>
				<li class="divider"></li>
				<li><a href="//<?= $_SERVER[HTTP_HOST]; ?>/inc/php/login.php?action=logout">Uitloggen</a></li>
			<?php }else{ ?>
				<li><a href="/index.php?action=inloggen">Inloggen</a></li>
				<li><a href="/index.php?action=register">Registreren</a></li>
			<?php } ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>