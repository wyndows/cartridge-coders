
<p class="title">Conceptual Model</p>
<br>
<h1>Entities</h1>
<h2>Account</h2>
<ul>
	<li>accountId</li>
	<li>accountName</li>
	<li>accountUserName</li>
	<li>accountAvatar</li>
	<li>acccountPpEmail</li>
	<li>accountSalt</li>
	<li>accountHash</li>
	<li>accountAdmin</li>
	<li>accountState</li>
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
	<li>productState</li>
</ul>
<h2>Messaging</h2>
<ul>
	<li>messId</li>
	<li>productId</li>
	<li>messSellerId</li>
	<li>messBuyerId</li>
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
<h2>ModelRelationships</h2>
<ul>
	<li>one account can have one profileId</li>
	<li>one account can have only one email</li>
	<li>many accounts can have many purchase histories</li>
	<li>one account can have one access level</li>
	<li>one account can have one avatar</li>
	<li>many content can have many ad pictures</li>
	<li>many accounts can create many contents</li>
	<li>one account can write many reviews</li>
	<li>one account can have one paypalAccount</li>
	<li>one account can have only one password</li>
	<li>one content can have one contentId</li>
	<li>one account can have one name</li>
	<li>one content can have item discription</li>
	<li>many reviews can be written on many content</li>
	<li>many content can have one title</li>
	<li>one content can have one adprice</li>
	<li>many content can have one admin price</li>
</ul>