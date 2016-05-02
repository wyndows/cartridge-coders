DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS productCategory;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS productPurchase;

CREATE TABLE account (
	accountId      		INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accountImageId  		INT UNSIGNED,
	accountAdmin 			INT TINYINT NOT NULL,
	accountName 			VARCHAR(50) NOT NULL,
	accountPpEmail    	VARCHAR(75) NOT NULL,
	accountUserName   	VARCHAR(15) NOT NULL,
	UNIQUE(accountUserName),
	UNIQUE(accountPpEmail),
	FOREIGN KEY(accountImageId) REFERENCES image(imageId),
	PRIMARY KEY (accountId)
);

CREATE TABLE category (
	categoryId      		INT UNSIGNED AUTO_INCREMENT NOT NULL,
	categoryName  			VARCHAR(20) NOT NULL,
	PRIMARY KEY (categoryId)
);

CREATE TABLE productCategory (
	productCategoryCategoryId     INT UNSIGNED,
	productCategoryProductId  		INT UNSIGNED,
	FOREIGN KEY(productCategoryCategoryId) REFERENCES category(categoryId),
	FOREIGN KEY(productCategoryProductId) REFERENCES product(productId)
);

CREATE TABLE product (
	productId      		INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productAccountId  	INT UNSIGNED NOT NULL,
	productImageId 		INT UNSIGNED,
	productAdminFee 		FLOAT UNSIGNED NOT NULL,
	productDescription   VARCHAR(255) NOT NULL,
	productPrice			FLOAT UNSIGNED NOT NULL,
	productShipping   	FLOAT UNSIGNED NOT NULL,
	productSold				INT TINYINT NOT NULL,
	productTitle			VARCHAR(50) NOT NULL,
	FOREIGN KEY(productAccountId) REFERENCES account(accountId),
	FOREIGN KEY(productImageId) REFERENCES image(imageId),
	PRIMARY KEY (productId)
);

CREATE TABLE message (
	messageId      		INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messageBuyerId  		INT UNSIGNED NOT NULL,
	messageProductId 		INT UNSIGNED NOT NULL,
	messageSellerId   	INT UNSIGNED NOT NULL,
	messageContent			VARCHAR(255) NOT NULL,
	messageMailGunId 		INT UNSIGNED NOT NULL,
	messageSubject   		VARCHAR(50) NOT NULL,
	FOREIGN KEY(messageBuyerId) REFERENCES account(accountId),
	FOREIGN KEY(messageProductId) REFERENCES product(productId),
	FOREIGN KEY(messageSellerId) REFERENCES account(accountId),
	PRIMARY KEY (messageId)
);