DROP TABLE IF EXISTS productPurchase;
DROP TABLE IF EXISTS productCategory;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS purchase;
DROP TABLE IF EXISTS account;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS category;

CREATE TABLE category (
	categoryId   INT UNSIGNED AUTO_INCREMENT NOT NULL,
	categoryName VARCHAR(50)                 NOT NULL,
	INDEX (categoryName),
	PRIMARY KEY (categoryId)
);

CREATE TABLE image (
	imageId       INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imageFileName VARCHAR(128)                NOT NULL,
	imageType     VARCHAR(10)                 NOT NULL,
	UNIQUE (imageFileName),
	PRIMARY KEY (imageId)
);

CREATE TABLE account (
	accountId       INT UNSIGNED AUTO_INCREMENT NOT NULL,
	accountImageId  INT UNSIGNED                NOT NULL,
	accountActive   TINYINT UNSIGNED DEFAULT 1  NOT NULL,
	accountAdmin    TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	accountName     VARCHAR(50)                 NOT NULL,
	accountPpEmail  VARCHAR(75)                 NOT NULL,
	accountUserName VARCHAR(25)                 NOT NULL,
	UNIQUE (accountUserName),
	UNIQUE (accountPpEmail),
	INDEX (accountImageId),
	FOREIGN KEY (accountImageId) REFERENCES image (imageId),
	PRIMARY KEY (accountId)
);

CREATE TABLE purchase (
	purchaseId                  INT UNSIGNED AUTO_INCREMENT NOT NULL,
	purchaseAccountId           INT UNSIGNED                NOT NULL,
	purchasePayPalTransactionId CHAR(28)                    NOT NULL,
	purchaseCreateDate          DATETIME                    NOT NULL,
	INDEX (purchaseAccountId),
	FOREIGN KEY (purchaseAccountId) REFERENCES account (accountId),
	PRIMARY KEY (purchaseId)
);

CREATE TABLE product (
	productId          INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productAccountId   INT UNSIGNED                NOT NULL,
	productImageId     INT UNSIGNED                NOT NULL,
	productAdminFee    DECIMAL(5, 2) UNSIGNED      NOT NULL,
	productDescription VARCHAR(255)                NOT NULL,
	productPrice       DECIMAL(7, 2) UNSIGNED      NOT NULL,
	productShipping    DECIMAL(5, 2) UNSIGNED      NOT NULL,
	productSold        TINYINT UNSIGNED DEFAULT 0  NOT NULL,
	productTitle       VARCHAR(64)                 NOT NULL,
	INDEX (productAccountId),
	INDEX (productImageId),
	FOREIGN KEY (productAccountId) REFERENCES account (accountId),
	FOREIGN KEY (productImageId) REFERENCES image (imageId),
	PRIMARY KEY (productId)
);

CREATE TABLE feedback (
	feedbackId        INT UNSIGNED AUTO_INCREMENT NOT NULL,
	feedbackSenderId   INT UNSIGNED                NOT NULL,
	feedbackProductId INT UNSIGNED                NOT NULL,
	feedbackRecipientId  INT UNSIGNED                NOT NULL,
	feedbackContent   VARCHAR(255)                NOT NULL,
	feedbackRating    TINYINT UNSIGNED            NOT NULL,
	INDEX (feedbackSenderId),
	INDEX (feedbackProductId),
	INDEX (feedbackRecipientId),
	FOREIGN KEY (feedbackSenderId) REFERENCES account (accountId),
	FOREIGN KEY (feedbackProductId) REFERENCES product (productId),
	FOREIGN KEY (feedbackRecipientId) REFERENCES account (accountId),
	PRIMARY KEY (feedbackId)
);

CREATE TABLE message (
	messageId        INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messageSenderId   INT UNSIGNED                NOT NULL,
	messageProductId INT UNSIGNED                NOT NULL,
	messageRecipientId  INT UNSIGNED                NOT NULL,
	messageContent   VARCHAR(255)                NOT NULL,
	messageMailGunId VARCHAR(40)                    NOT NULL,
	messageSubject   VARCHAR(128)                NOT NULL,
	INDEX (messageSenderId),
	INDEX (messageProductId),
	INDEX (messageRecipientId),
	FOREIGN KEY (messageSenderId) REFERENCES account (accountId),
	FOREIGN KEY (messageProductId) REFERENCES product (productId),
	FOREIGN KEY (messageRecipientId) REFERENCES account (accountId),
	PRIMARY KEY (messageId)
);

CREATE TABLE productCategory (
	productCategoryCategoryId INT UNSIGNED NOT NULL,
	productCategoryProductId  INT UNSIGNED NOT NULL,
	INDEX (productCategoryCategoryId),
	INDEX (productCategoryProductId),
	FOREIGN KEY (productCategoryCategoryId) REFERENCES category (categoryId),
	FOREIGN KEY (productCategoryProductId) REFERENCES product (productId),
	PRIMARY KEY (productCategoryProductId, productCategoryCategoryId)
);

CREATE TABLE productPurchase (
	productPurchaseProductId  INT UNSIGNED NOT NULL,
	productPurchasePurchaseId INT UNSIGNED NOT NULL,
	INDEX (productPurchaseProductId),
	INDEX (productPurchasePurchaseId),
	FOREIGN KEY (productPurchaseProductId) REFERENCES product (productId),
	FOREIGN KEY (productPurchasePurchaseId) REFERENCES purchase (purchaseId),
	PRIMARY KEY (productPurchasePurchaseId, productPurchaseProductId)
);



