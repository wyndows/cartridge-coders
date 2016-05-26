
<!DOCTYPE html>
<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<title>Login with PayPal - v2</title>


	</head>
	<body>

		<h1>Login with PayPal - v2</h1>
		<p>Great! Now you are a member of our site.</p>

		<hr/>

		<h2>Your Data</h2>
		<p><b>Name:</b> <?php echo htmlspecialchars_decode($userinfo->name); ?></p>
		<p><b>Email:</b> <?php echo htmlspecialchars_decode($userinfo->email); ?></p>

		<hr/>

		<p><button class="btn btn-success form-control" type="button" onclick="window.close()">Ok, done.</button></p>
	</body>
</html>
