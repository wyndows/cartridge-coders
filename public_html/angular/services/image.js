app.constant("IMAGE_ENDPOINT", "php/apis/image/");
app.service("ImageService", function($http, IMAGE_ENDPOINT) {
	function getUrl() {
		return(IMAGE_ENDPOINT);
	}

	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(imageId) {
		return($http.get(getUrlForId(imageId)));
	};

	this.fetchByProductImageId = function(productImageId) {
		return($http.get(getUrl() + "?productImageId=" + productImageId));
	};

	this.create = function(image) {
		return($http.post(getUrl(), image));
	};

	this.update = function(imageId, image) {
		return($http.put(getUrlForId(imageId), image));
	};

	this.destroy = function(imageId) {
		return($http.delete(getUrlForId(imageId)));
	};
});