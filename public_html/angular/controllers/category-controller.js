app.controller("categoryController", function($scope) {

$scope.categoryAtari = function() {
// setup an AJAX call to submit the form without reloading
	submitHandler: function(button) {
		$("#sign-up-form").ajaxSubmit({
// GET or POST
			type: "POST",
// where to submit data
			url: $("#sign-up-form").attr("action"),
// this sends the XSRF token along with the form data
			headers: {
				"X-XSRF-TOKEN": Cookies.get("XSRF-TOKEN")
			},
// success is an event that happens when the server replies
			success: function(ajaxOutput) {
// clear the output area's formatting
				$("#outputArea").css("display", "");
// write the server's reply to the output area
				$("#outputArea").html(ajaxOutput);
			}
		}}}}

	<div ng-app="myApp" ng-controller="myCtrl">

	<button ng-click="myFunction()">Click me!</button>

<p>{{ count }}</p>

</div>
<script>
var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope) {
	$scope.count = 0;
	$scope.myFunction = function() {
		$scope.count++;
	}
});
</script>