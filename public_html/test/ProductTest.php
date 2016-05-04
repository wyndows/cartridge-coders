<?php

/**
 * Formulating plan for unit testing of Product class
 *
 * Class will consist of:
 * 	productId
 * 	productAccountId
 * 	productImageId
 * 	productAdminFee
 * 	productDescription
 * 	productPrice
 * 	productShipping
 * 	productSold
 * 	productTitle
 *
 * Primary key will be:
 * 	productId
 *
 * Foreign Keys:
 * 	productAccountId (a mock object will need to be created)
 * 	productImageId (a mock object will need to be created)
 *
 * Testing will be on:
 * 	insertProduct
 * 	updateProduct
 * 	deleteProduct
 * 	getProductByProductId
 * 	getProductByProductAccountId
 * 	getProductByProductImageId
 * 	getProductByProductDescription
 * 	getProductByProductPrice
 * 	getProductByProductSold
 * 	getProductByProductTitle
 * 	getAllProducts
 *
 * Testing will consist of the following:
 * 	test inserting a valid Product key and verify that the actual mySQL data matches
 * 	test inserting a Product that already exists
 * 	test inserting a Product, editing it, and then updating it
 * 	test updating a Product that already exists
 * 	test creating a Product and then deleting it
 * 	test deleting a Product that does not exist
 * 	test grabbing a Product that does not exist
 * 	test grabbing a Product by productId
 * 	test grabbing a Product by productAccountId
 * 	test grabbing a Product by productImageId
 * 	test grabbing a Product by productDescription
 * 	test grabbing a Product by productPrice
 * 	test grabbing a Product by productSold
 * 	test grabbing a Product by productTitle
 * 	test grabbing a Product by productId that does not exist
 * 	test grabbing a Product by productAccountId that does not exist
 * 	test grabbing a Product by productImageId that does not exist
 * 	test grabbing a Product by productDescription that does not exist
 * 	test grabbing a Product by productPrice that does not exist
 * 	test grabbing a Product by productSold that does not exist
 * 	test grabbing a Product by productTitle that does not exist
 * 	test grabbing all Products in the table that does not exist
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */


?>