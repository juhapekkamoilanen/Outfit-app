-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Person(
	user_id SERIAL PRIMARY KEY,
	username varchar(16), --used to sign in
	password varchar(64) NOT NULL,
	email varchar(64) NOT NULL,
	full_name varchar(64),
	user_info varchar(64)
);

CREATE TABLE Item(
	item_id SERIAL PRIMARY KEY,
	type varchar(32) NOT NULL,
	brand varchar(32) NOT NULL,
	color varchar(32) NOT NULL,
	color_2nd varchar(32),
	material varchar(32),
	image varchar(32)
);

CREATE TABLE Outfit(
	outfit_id SERIAL PRIMARY KEY,
);

CREATE TABLE Outfit_items(
	outfit_id SERIAL REFERENCES Outfit,
	item_id SERIAL REFERENCES Item,
	PRIMARY KEY (outfit_id, item_id)
);

CREATE TABLE Outfit_collection(
	user_id varchar(16) REFERENCES Person,
	outfit_id SERIAL REFERENCES Outfit,
	rating INTEGER,
	comment varchar(160),
	PRIMARY KEY (user_id, outfit_id)
);

CREATE TABLE Wardrobe(
	user_id SERIAL REFERENCES Person,
	item_id SERIAL REFERENCES Item,
	PRIMARY KEY (user_id, item_id)
);

CREATE TABLE Wishlist(
	user_id SERIAL REFERENCES Person,
	item_id SERIAL REFERENCES Item,
	PRIMARY KEY (user_id, item_id)
);

CREATE TABLE Use_history(
	user_id SERIAL REFERENCES Person,
	item_id SERIAL REFERENCES Item,
	date_used DATE,
	PRIMARY KEY (user_id, item_id, date_used)
);