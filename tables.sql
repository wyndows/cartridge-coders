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
	accountAdmin 			BOOLEAN NOT NULL,
	accountName 			VARCHAR(50) NOT NULL,
	accountPpEmail    	VARCHAR(75) NOT NULL,
	accountUserName   	VARCHAR(15) NOT NULL,
	UNIQUE(accountUserName),
	UNIQUE(accountPpEmail),
	FOREIGN KEY(accountImageId) REFERENCES image(imageId),
	PRIMARY KEY (accountId)
);