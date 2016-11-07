<div class="container-fluid">
	<?php if($_GET['loggedon'] == "success" && !empty($_SESSION['Username']) && $_SESSION['loggedin'] == true){ ?>
		<div class="alert alert-dismissible alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Geslaagd!</strong> Je bent met success ingelogged!
		</div>
	<?php }elseif($_GET['loggedout'] == "true"){ ?>
		<div class="alert alert-dismissible alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Geslaagd!</strong> Je bent met success Uitgelogged!
		</div>
	<?php }elseif($_GET['registersuccess'] == "true"){ ?>
		<div class="alert alert-dismissible alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Geslaagd!</strong> Je bent met success Geregistreerd! Veel plezier!
		</div>
	<?php }elseif($_GET['registersuccess'] == "partial"){ ?>
		<div class="alert alert-dismissible alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<h4>Ehm... hoe leg ik dit uit...</h4>
			<p>De registratie is geslaagd, maar je moet zelf nog handmatig <a href="?action=inloggen" class="alert-link">inloggen</a>.</p>
		</div>
	<?php } ?>

	<!-- Panel Template
		<div class="col-md-2">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Panel danger</h3>
				</div>
				<div class="panel-body">
					Panel content
				</div>
			</div>
		</div>
	-->
	<div class="row">
		<div class="col-md-2">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Challenges</h3>
				</div>
				<div class="panel-body">
					<ul>
						<li><a href="challenges/challenge-1/index.php">Challenge-1</a></li>
						<li><a href="challenges/challenge-2/index.php">Challenge-2</a></li>
						<li><a href="challenges/challenge-3/index.php">Challenge-3</a></li>
						<li><a href="challenges/challenge-4/index.php">Challenge-4</a></li>
						<li><a href="challenges/challenge-5/index.php">Challenge-5</a></li>
						<li><a href="challenges/challenge-6/index.php">Challenge-6</a></li>
						<li><a href="challenges/challenge-7/index.php">Challenge-7</a></li>
						<li><a href="challenges/challenge-8/index.php">Challenge-8</a></li>
						<li><a href="challenges/challenge-9/index.php">Challenge-9</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title"><?= LANG_LEADERBOARD; ?></h3>
				</div>
				<div class="panel-body">
					<?php
					$sql = "SELECT Points, Username FROM users WHERE `Points` > 0;";
					$sql_output = $conn->query($sql);
					if ($sql_output->num_rows > 0) {
						?>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
									  <th><?= LANG_RANK; ?></th>
									  <th><?= LANG_PLAYER; ?></th>
									  <th><?= LANG_POINTS; ?></th>
									</tr>
								</thead>
								<tbody>
						<?php
								$current_rank = 0;
								while($row = $sql_output->fetch_assoc()){
									$current_rank++;
									?>
									<tr>
										<td><?= $current_rank;?></td>
										<td><?= htmlentities($row['Username']); ?></td>
										<td><?= htmlentities($row['Points']);?></td>
									</tr>
									<?php
								}
						?>
								</tbody>
								</table>
						<?php
						
					}else{
						echo LANG_NO_STATISTISCS_AVAILABLE;
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title"><?= LANG_LAST_ATTEMPTS; ?></h3>
				</div>
				<div class="panel-body">
					<?php
					$sql = "SELECT * FROM logs ORDER BY Date DESC LIMIT 10;";
					$sql_output = $conn->query($sql);
					if ($sql_output->num_rows > 0) {
						?>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
									  <th><?= LANG_PLAYER; ?></th>
									  <th>Challenge</th>
									  <th>Status</th>
									  <th><?= LANG_DATE; ?></th>
									</tr>
								</thead>
								<tbody>
						<?php
								while($row = $sql_output->fetch_assoc()){
									?>
									<tr>
										<td><?= htmlentities($row['Username']); ?></td>
										<td>Challenge-<?= htmlentities($row['Challenge']); ?></td>
										<td><?php if($row['Solved'] == true){ ?><i class="fa fa-unlock" aria-hidden="true"></i> <?= LANG_LEADERBOARD_SOLVED; ?><?php }else{?><i class="fa fa-lock" aria-hidden="true"></i> <?= LANG_LEADERBOARD_NOT_SOLVED; ?><?php } ?></td>
										<td><?= htmlentities($row['Date']); ?></td>
									</tr>
									<?php
								}
						?>
								</tbody>
								</table>
						<?php
						
					}else{
						echo LANG_NO_STATISTISCS_AVAILABLE;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>