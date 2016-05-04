<?php

/**
 * Formulating plan for unit testing of ProductCategory class
 *
 * Class will consist of ProductCategoryCategoryId and ProductCategoryProductId
 * Primary key will be a composite key of ProductCategoryCategoryId and ProductCategoryProductId
 * Foreign Keys:
 * 	ProductCategoryCategoryId
 * 	ProductCategoryProductId
 *
 * Testing will be on insertProductCategory, updateProductCategory, deleteProductCategory, getProductCategoryByProductCategoryCategoryId and getProductCategoryByProductCategoryProductId
 *
 * Testing will consist of the following:
 * test inserting a valid ProductCategory composite key and verify that the actual mySQL data matches
 * test inserting a ProductCategory composite key that already exists
 * test inserting a ProductCategory composite key, editing it, and then updating it
 * test updating a ProductCategory composite key that already exists
 * test creating a ProductCategory composite key and then deleting it
 * test deleting a ProductCategory composite key that does not exist
 * test grabbing a ProductCategory composite key that does not exist
 * test grabbing a ProductCategory composite key by categoryId
 * test grabbing a ProductCategory composite key by productId
 * test grabbing a ProductCategory by categoryId that does not exist
 * test grabbing a ProductCategory by productId that does not exist 
 * test grabbing all composite keys in the table
 *
 * @author Marlan Ball <wyndows@earthlink.net> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */


?>