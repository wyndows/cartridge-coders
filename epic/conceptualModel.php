<p class="title">Conceptual Model</p>
<h1>Entities</h1>
<h2>Account</h2>
<ul>
	<li>accountId</li>
	<li>accountImageId</li>
	<li>accountAdmin</li>
	<li>accountName</li>
	<li>accountPpEmail</li>
	<li>accountUserName</li>

</ul>
<h2>Category</h2>
<ul>
	<li>categoryId</li>
	<li>categoryName</li>
</ul>
<h2>ProductCategory</h2>
<ul>
	<li>productCategoryCategoryId</li>
	<li>productCategoryProductId</li>
</ul>
<h2>Product</h2>
<ul>
	<li>productId</li>
	<li>productAccountId</li>
	<li>productImageId</li>
	<li>productAdminFee</li>
	<li>productDescription</li>
	<li>productPrice</li>
	<li>productShipping</li>
	<li>productSold</li>
	<li>productTitle</li>
</ul>
<h2>Message</h2>
<ul>
	<li>messageId</li>
	<li>messageBuyerId</li>
	<li>messageMailGunId</li>
	<li>messageProductId</li>
	<li>messageSellerId</li>
	<li>messageContent</li>
	<li>messageSubject</li>
</ul>
<h2>Feedback</h2>
<ul>
	<li>feedbackId</li>
	<li>feedbackBuyerId</li>
	<li>feedbackProductId</li>
	<li>feedbackSellerId</li>
	<li>feedbackContent</li>
	<li>feedbackRating</li>
</ul>
<h2>Image</h2>
<ul>
	<li>imageId</li>
	<li>imageFileName</li>
	<li>imageType</li>
</ul>
<h2>Purchase</h2>
<ul>
	<li>purchaseId</li>
	<li>purchaseBuyerId</li>
	<li>purchasePayPalTransactionId</li>
	<li>purchaseCreateDate</li>
</ul>
<h2>ProductPurchase</h2>
<ul>
	<li>productPurchaseProductId</li>
	<li>productPurchasePurchaseId</li>
</ul>
<h2>ModelRelationships</h2>
<ul>
	<li><em>one</em> <strong>account</strong> can list <em>many</em> <strong>products</strong></li>
	<li><em>one</em> <strong>account</strong> can give feedback on <em>many</em> <strong>products</strong></li>
	<li><em>one</em> <strong>account</strong> can give feedback on <em>many</em> <strong>accounts</strong></li>
	<li><em>many</em> <strong>accounts</strong> can purchase <em>many</em> <strong>products</strong></li>
	<li><em>one</em> <strong>account</strong> can have <em>onc</em> <strong>accountImageId</strong></li>
	<li><em>one</em> <strong>account</strong> can message <em>many</em> <strong>account</strong></li>
	<li><em>many</em> <strong>account</strong> can make <em>many</em> <strong>productPurchases</strong></li>
	<li><em>one</em> <strong>product</strong> can have <em>many</em> <strong>productCategories</strong></li>
	<li><em>one</em> <strong>product</strong> can have <em>one</em> <strong>productImageId</strong></li>
</ul>