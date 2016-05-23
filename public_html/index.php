<html>
<!-- head utils contains the entire <head> tag -->
<?php require_once("php/partials/head-utils.php");?>

<body class="sfooter">
	<div class="sfooter-content">

		<!-- header partial gets inserted -->
		<?php require_once("php/partials/header.php");?>

		<main>
			<div class="container">
				<div class="row">
					<div class="col-md-3">

						<!-- side panel get inserted -->
						<?php require_once("php/partials/side-panel.php");?>

					</div>
					<div class="col-md-9">
						main content section - we will use Angular here.
					</div>
				</div>
			</div><!-- ?.container-->
		</main>
	</div> <!--/.sfooter-content-->
	<!--footer get inserted -->
	<?php require_once("php/partials/footer.php");?>

</body>
</html>


