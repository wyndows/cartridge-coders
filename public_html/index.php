<html>
	<!-- head utils contains the entire <head> tag -->
	<?php require_once("php/partials/head-utils.php"); ?>

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
							main content section - we will use Angular here.
							<br>
							<br>
							<br>
							<br>
							
							<br>
							<br>
							<br>
							<br>
							<span id='lippButton'></span>
							<script src='https://www.paypalobjects.com/js/external/api.js'></script>
							<script>
								paypal.use( ['login'], function (login) {
									login.render ({
										"appid":"AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj",
										"authend":"sandbox",
										"scopes":"openid",
										"containerid":"lippButton",
										"locale":"en-us",
										"theme":"neutral",
										"returnurl":"https://bootcamp-coders.cnm.edu/~ddeleeuw/cartridge-coders/public_html/index.php"
									});
								});
							</script>
						</div>
					</div>
				</div><!-- ?.container-->
			</main>
		</div> <!--/.sfooter-content-->
		<!--footer get inserted -->
		<?php require_once("php/partials/footer.php"); ?>

	</body>
</html>


