<p class="title">Conceptual Model</p>
<br>
<h1>Entities</h1>
<h2>Account</h2>
<ul>
	<li>accountId</li>
	<li>accountName</li>
	<li>accountUserName</li>
	<li>accountPpEmail</li>
	<li>accountAdmin</li>
</ul>
<h2>Category</h2>
<ul>
	<li>categoryId</li>
	<li>categoryName</li>
</ul>
<h2>ProductCategory</h2>
<ul>
	<li>categoryId</li>
	<li>productId</li>
</ul>
<h2>Product</h2>
<ul>
	<li>productId</li>
	<li>accountId</li>
	<li>productDescription</li>
	<li>productPicture</li>
	<li>productTitle</li>
	<li>productPrice</li>
	<li>productShipping</li>
	<li>productAdminFee</li>
</ul>
<h2>Messaging</h2>
<ul>
	<li>messId</li>
	<li>productId</li>
	<li>mailGunId</li>
	<li>messSellerId</li>
	<li>messBuyerId</li>
	<li>messContent</li>
	<li>messSubject</li>
</ul>
<h2>Feedback</h2>
<ul>
	<li>feedId</li>
	<li>feedSellerId</li>
	<li>feedBuyerId</li>
	<li>productId</li>
	<li>feedRating</li>
	<li>feedContent</li>
</ul>
<h2>Image</h2>
<ul>
	<li>accountImageId</li>
	<li>productImageId</li>
</ul>
<h2>Purchase</h2>
<ul>
	<li>purchaseId</li>
	<li>purchaseCreateDate</li>
	<li>purchaseBuyerId</li>
	<li>buyerPayPalId</li>
</ul>
<h2>ProductPurchase</h2>
<ul>
	<li>productId</li>
	<li>purchaseId</li>
	<li>productSold</li>
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