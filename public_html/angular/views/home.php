
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
		<tr><th>Image</th><th>Product ID</th><th>Title</th><th>Description</th><th>Price</th><th>Shipping</th></tr>
		<tr ng-repeat="product in products">
<!--			<td>{{ images }}</td>-->
			<td><img ng-src="../public_html/image/cartridge/{{ images[product.productId].imageFileName }}"></td>
			<td>{{ product.productId }}</td>
			<td>{{ product.productTitle }}</td>
			<td>{{ product.productDescription }}</td>
			<td>{{ product.productPrice }}</td>
			<td>{{ product.productShipping }}</td>
		</tr>
	</table>
</div>
<!--ng-click="loadProduct(products[$index].productId);"-->




<!--</div>-->