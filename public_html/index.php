<!DOCTYPE html>
<html>
	<!-- head utils contains the entire <head> tag -->
	<?php require_once("php/partials/head-utils.php"); ?>

	<head>
		<!-- PayPal test header 2.0 begin -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"> <!-- Optional theme -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> <!-- Latest compiled and minified JavaScript -->
		<!-- PayPal test header 2.0 end -->

		<title>ROMuLess</title>
	</head>

	<body class="sfooter">
		<div class="sfooter-content">

			<!-- header partial gets inserted -->
			<?php require_once("php/partials/header.php"); ?>

			<main>
				<div class="container">
					<div class="row">
						<div class="col-md-3">

							<!-- side panel get inserted -->
							<?php require_once("php/partials/side-panel.php"); ?>

						</div>
						<div class="col-md-9">
							<p>main content section - we will use Angular here. </p>
							<br>
							<br>
							<br>
							<br>
							<!-- PayPal test code begin -----------------------------------------------------------------  -->
<!--							<span id='lippButton'></span>-->
<!--							<script src='https://www.paypalobjects.com/js/external/api.js'></script>-->
<!--							<script>-->
<!--								paypal.use(['login'], function(login) {-->
<!--									login.render({-->
<!--										"appid": "AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj",-->
<!--										"authend": "sandbox",-->
<!--										"scopes": "openid profile email",-->
<!--										"containerid": "lippButton",-->
<!--										"locale": "en-us",-->
<!--										"theme": "neutral",-->
<!--										"returnurl": "https://bootcamp-coders.cnm.edu/~ddeleeuw/cartridge-coders/public_html/index.php"-->
<!--									});-->
<!--								});-->
<!--							</script>-->
<!--							<script>-->
<!--								top.close();-->
<!--							</script>-->
							<!-- PayPal test code 2.0 begin -------------------------------------------------------------  -->
							<!-- https://www.sitepoint.com/implement-user-log-paypal/ -----------------------------------  -->
							<br>
							<br>
							<br>
							<br>
							<br>
									<h1>Login with PayPal - v2</h1>
									<p>Welcome! No boring signup here. Just use the following button to login.</p>
									<hr/>

							<span id='lippButton'></span>
							<script src='https://www.paypalobjects.com/js/external/api.js'></script>
							<script>
								paypal.use(['login'], function(login) {
									login.render({
										"appid": "AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj",
										"authend": "sandbox",
										"scopes": "openid profile email",
										"containerid": "lippButton",
										"locale": "en-us",
										"theme": "neutral",
										"returnurl": "https://bootcamp-coders.cnm.edu/~ddeleeuw/cartridge-coders/public_html/results.php"
									});
								});
							</script>



<!-- PayPal test code end -----------------------------------------------------------------  -->
						</div>
					</div>
				</div><!-- ?.container-->
			</main>
		</div> <!--/.sfooter-content-->
		<!--footer get inserted -->
		<?php require_once("php/partials/footer.php"); ?>

	</body>
</html>


