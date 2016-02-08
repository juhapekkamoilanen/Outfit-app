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

--Foreignkey naming:
-- fk__thistable__tablereferenced i.e.
-- fk__foreignkeytable__primarykeytable

CREATE TABLE Outfititems(
	fk_outfititems_outfit SERIAL REFERENCES Outfit,
	fk_outfititems_item SERIAL REFERENCES Item,
	PRIMARY KEY (fk_outfititems_outfit, fk_outfititems_item)
);

CREATE TABLE Outfitcollection(
	fk_outfitcollection_person SERIAL REFERENCES Person,
	fk_outfitcollection_outfit SERIAL REFERENCES Outfit,
	rating INTEGER,
	comment varchar(160),
	PRIMARY KEY (fk_outfitcollection_person, fk_outfitcollection_outfit)
);

CREATE TABLE Wardrobe(
	fk_wardrobe_person SERIAL REFERENCES Person,
	fk_wardrobe_item SERIAL REFERENCES Item,
	PRIMARY KEY (fk_wardrobe_person, fk_wardrobe_item)
);

CREATE TABLE Wishlist(
	fk_wishlist_person SERIAL REFERENCES Person,
	fk_wishlist_item SERIAL REFERENCES Item,
	PRIMARY KEY (user_id_wishlist, item_id_wishlist)
);

CREATE TABLE Usehistory(
	fk_usehistory_outfitcollection REFERENCES Outfitcollection
	date_used DATE,
	PRIMARY KEY (fk_usehistory_outfitcollection, date_used)
);