<?php

/**
 * Formulating plan for unit testing of ProductPurchase class
 *
 * Class will consist of two foreign keys only, primary will be a compost of the two
 * 
 * Foreign keys:
 * ProductPurchaseProductId
 * ProductPurchasePurchaseId
 *
 * Testing will be on;
 * insert on productPurchase
 * update on productPurchase
 * delete on product Purchase
 * get of productPurchase by productId
 * get of productPurchase by purchaseId
 *
 * Testing will consist of;
 * test inserting a valid ImageFileName and verify that the actual mySQL data matches
 * test inserting a ImageFileName that already exists
 * test inserting a ImageFileName, editing it, and then updating it
 * test updating a ImageFileName that already exists
 * test creating a ImageFileName and then deleting it
 * test deleting a ImageFileName that does not exist
 * test grabbing a ImageFileName that does not exist
 * test grabbing a ImageFileName by ImageFileName name
 * test grabbing a ImageFileName by ImageFileName name that does not exist
 * test grabbing all ImageFileNames in the table
 *
 * @author Donald DeLeeuw <donald.deleeuw@gmail.com> based on code by Dylan McDonald <dmcdonald21@cnm.edu>
 */

namespace Edu\Cnm\CartridgeCoders\Test;

use Edu\Cnm\CartridgeCoders\Image;
