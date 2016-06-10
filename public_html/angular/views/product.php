<!--<nav class="navbar navbar-default navbar-fixed-top">-->
<!--	<div class="container">-->
<!--		<ul class="nav navbar-nav">-->
<!--			<li>-->
<!--				<p class="navbar-btn">-->
<!--					<a href="#" class="btn btn-default">I'm a link button!</a>-->
<!--				</p>-->
<!--			</li>-->
<!--		</ul>-->
<!--	</div>-->
<!--</nav>-->
<!---->
<!--<div class="navbar navbar-static-top navbar-inverse">-->
<!--	<div class="navbar-inner">-->
<!--		<a class="brand" href="#">Brand</a>-->
<!--		<ul class="nav">-->
<!--			<li class="active"><a href="#">Home</a></li>-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li><a href="#">More</a></li>-->
<!--			<li><a href="#">Options</a></li>-->
<!--		</ul>-->
<!--	</div>-->
<!--</div>-->
<!--<div class="navbar">-->
<!--	<div class="navbar-inner">-->
<!--		<ul class="nav">-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li><a href="#">Link</a></li>-->
<!--			<li><a href="#">Link</a></li>-->
<!--		</ul>-->
<!--	</div>-->
<!--</div>-->
<!---->
<!--<div ng-app="myApp" ng-controller="">-->
<!---->
<!--	<ul>-->
<!--		<li ng-repeat="x in myData">-->
<!--			{{ x.Name + ', ' + x.Country }}-->
<!--		</li>-->
<!--	</ul>-->
<!---->
<!--</div>-->
<!---->
<!--<div class="container">-->
<!--	<div class="row">-->
<!--		<div class="col-md-12">-->
<!--			<div class="btn-group btn-group-justified " role="group" aria-label="...">-->
<!--				<div class="btn-group " role="group">-->
<!--					<button type="button" class="btn categorybar" ng-click="category()">All</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar" ng-click="category(atari)">ATARI</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">NES</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">Super NES</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">N64</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">Sega</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">Gameboy</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">GBA</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">GBA DS</button>-->
<!--				</div>-->
<!--				<div class="btn-group" role="group">-->
<!--					<button type="button" class="btn categorybar">Other</button>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->



<link rel="stylesheet" href="css/style.css" type="text/css">

<p><br></p>

<!--<div class="well homecss">-->
<!--<div class="row">-->
<!--	<div class="col-md-2"><img src="../public_html/image/cartridge/avatar01.jpg" alt="2600"  class="img-responsive img-rounded"></div>-->
<!--	<div class="col-md-1"></div>-->
<!--	<div class="col-md-9">Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description </div>-->
<!--</div>-->
<!--	</div>-->
<!---->
<!---->
<!--<div class="well homecss">-->
<!--<div class="row">-->
<!--	<div class="col-md-2"><img src="../public_html/image/cartridge/avatar02.jpg" alt="2600"  class="img-responsive img-rounded"></div>-->
<!--	<div class="col-md-1"></div>-->
<!--	<div class="col-md-9">Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description </div>-->
<!--</div>-->
<!--</div>-->
<!---->
<!---->
<!---->
<!--	<div class="well homecss">-->
<!--<div class="row">-->
<!--	<div class="col-md-2"><img src="../public_html/image/cartridge/avatar03.jpg" alt="2600"  class="img-responsive img-rounded"></div>-->
<!--	<div class="col-md-1"></div>-->
<!--	<div class="col-md-9">Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description Game Description </div>-->
<!--</div>-->
<!--	</div>-->

<div class="row">
	<table class="table table-bordered table-hover table-responsive table-striped table-word-wrap">
		<tr><th>Product ID</th><th>Title</th><th>Description</th><th>Price</th><th>Shipping</th></tr>
		<tr ng-click="loadProduct(products[$index].productId);" ng-repeat="product in products | filter: search">
			<td>{{ product.productId }}</td>
			<td>{{ product.title }}</td>
			<td>{{ product.description }}</td>
			<td>{{ product.price }}</td>
			<td>{{ product.shipping }}</td>
		</tr>
	</table>
</div>





<!--</div>-->