<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="../css/style.css">
		<title>Conceptual Model</title>
	</head>
	<body>
		<header class="header">Cartridge Coders</header>
		<p class="title">Conceptual Model</p>
		<br>
		<h1>Entities</h1>
			<h2>Account</h2>
				<ul>
					<li>profileId</li>
					<li>name</li>
					<li>userName</li>
					<li>avatar</li>
					<li>paypalEmail</li>
					<li>password</li>
					<li>userSalt</li>
					<li>userHash</li >
				</ul>
			<h2>Admin</h2>
				<ul>
					<li>adminName</li>
					<li>adminProfileId(PK)</li>
					<li>adminEmail</li>
					<li>adminPhoneNumber</li>
					<li>adminAccessLevel</li>
					<li>AdminPassword</li>
					<li></li>
				</ul>
		<h2>Product</h2>
		<ul>
			<li>productId</li>
			<li>categoryOne</li>
			<li>categoryTwo</li>
			<li>categoryThr</li>
			<li>title</li>
			<li>price</li>
				<li>shipping</li>
				<li>adminFee</li>
				<li>state</li>
				<li>description</li>
				<li>picture</li>
		</ul>
		<h2>Watch</h2>
		<ul>
			<li>watchId</li>
			<li>profileId</li>
			<li>contentId</li>
		</ul>
			<h2>Feedback</h2>
			<ul>
				<li>feedbackId</li>
				<li>profileId</li>
				<li>contentId</li>
				<li>review</li>

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
	</body>
</html>