<!DOCTYPE html> <!--this is the doctype declaration-->
<html lang="en" xmlns="http://www.w3.org/1999/html"><!--this is to set this page to english-->
	<head>  <!--this is the head tag to start the doc out-->

		<meta charset="utf-8">
		<!--this helps out IE-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<!--going to be used for view port -->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
				integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
				integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Font Awesome -->
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css"
				rel="stylesheet"/>

		<!--customer CSS-->
		<link rel="stylesheet" href="style.css"/>

		<!-- jQuery (needed for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				  integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				  crossorigin="anonymous"></script>
		<title>ROMuLess</title>
	</head>
	<body>
		<div class="sfooter">

			<!-- header -->
			<header class="p-y-4">
				<div class="container">

					<!-- brand and toggle stuff-->
					<nav class="navbar navbar-inverse">
						<div class="container-fluid">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
										  data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand" href="#">ROMuLess</a>
							</div>

							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<form class="navbar-form navbar-left" role="search">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="">
									</div>
									<button type="submit" class="btn btn-default">Search</button>
								</form>
								<ul class="nav navbar-nav navbar-right">
									<li><a
											href="https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?client_id=AWoiHG8w-yaeYyODSBIzJ-awWkLVPo7G9zWJMomAFeMTVw5wyRG_b2pyYxl7a7wB7ByjVLJ0aQ6FdVDj&response_type=code&scope=openid email profile&redirect_uri=https://bootcamp-coders.cnm.edu/~ddeleeuw/cartridge-coders/public_html/return.php"><img
												src="https://www.paypalobjects.com/webstatic/en_US/developer/docs/lipp/loginwithpaypalbutton.png"></a>
									</li>
									<li><a href="../../paypal/expresscheckout.php"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></a></li>
								</ul>
							</div><!-- /.navbar-collapse -->
						</div><!-- /.container-fluid -->
					</nav>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="btn-group btn-group-justified " role="group" aria-label="...">
								<div class="btn-group " role="group">
									<button type="button" class="btn categorybar" ng-click="categoryAll()">All</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar" ng-click="categoryAtari()">ATARI</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">NES</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">Super NES</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">N64</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">Sega</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">Gameboy</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">GBA</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">GBA DS</button>
								</div>
								<div class="btn-group" role="group">
									<button type="button" class="btn categorybar">Other</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<!-- contents -->
			<section id="feature" class="p-y-4">
				<div class="container">
					<div class="row row-flex" </div>
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img src="..." alt="...">
								<div class="caption">
									<h3>Title</h3>
									<p>Discription</p>
									<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
								</div>
							</div>
						</div>
				<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
						<img src="..." alt="...">
						<div class="caption">
							<h3>Title</h3>
							<p>Discription</p>
							<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-4">
					<div class="thumbnail">
						<img src="..." alt="...">
						<div class="caption">
							<h3>Title</h3>
							<p>Discription</p>
							<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
						</div>
					</div>
				</div>
					</div>
		</section>
	</body>
</html>