app.constant("PRODUCT_ENDPOINT", "php/apis/product/");
app.service("ProductService", function($http, PRODUCT_ENDPOINT) {
	function getUrl() {
		return(PRODUCT_ENDPOINT);
	}

	function getUrlForId(productId) {
		return(getUrl() + productId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(productId) {
		return($http.get(getUrlForId(productId)));
	};

	this.create = function(product) {
		return($http.post(getUrl(), product));
	};

	this.update = function(productId, product) {
		return($http.put(getUrlForId(productId), product));
	};

	this.destroy = function(productId) {
		return($http.delete(getUrlForId(productId)));
	};
});