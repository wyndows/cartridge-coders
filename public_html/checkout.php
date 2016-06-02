<!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<title>Login with PayPal - v3</title>
	</head>
	<body>

<?php


			?>

		<div class="container">
			<div class="col-md-12">
				<div class="well">
					<p><strong>Checkout v1</strong></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="well">
						<p>Name:</p>
						<p>Email:</p>
						<p>UserName:</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="well">
						<p><?php echo $account->getAccountName(); ?></p>
						<p><?php echo $account->getAccountPpEmail(); ?></p>
						<p><?php echo $account->getAccountUserName(); ?></p>
					</div>
				</div>
			</div>
		</div>
		<hr/>
	</body>
</html>
