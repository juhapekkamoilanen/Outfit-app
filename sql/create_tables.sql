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
	outfit_id SERIAL PRIMARY KEY
);

--Foreignkey naming:
-- fk__thistable__tablereferenced i.e.
-- fk__foreignkeytable__primarykeytable

CREATE TABLE Outfititems(
	fk_outfititems_outfit SERIAL REFERENCES Outfit ON DELETE CASCADE,
	fk_outfititems_item SERIAL REFERENCES Item ON DELETE CASCADE,
	PRIMARY KEY (fk_outfititems_outfit, fk_outfititems_item)
);

CREATE TABLE Outfitcollection(
	fk_outfitcollection_person SERIAL REFERENCES Person ON DELETE CASCADE,
	fk_outfitcollection_outfit SERIAL REFERENCES Outfit ON DELETE CASCADE,
	rating INTEGER,
	comment varchar(160),
	PRIMARY KEY (fk_outfitcollection_person, fk_outfitcollection_outfit)
);

CREATE TABLE Wardrobe(
	fk_wardrobe_person SERIAL REFERENCES Person ON DELETE CASCADE,
	fk_wardrobe_item SERIAL REFERENCES Item ON DELETE CASCADE,
	PRIMARY KEY (fk_wardrobe_person, fk_wardrobe_item)
);