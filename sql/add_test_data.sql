-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Person (username, password, email, full_name, user_info)
VALUES ('Maija', '12345678', 'maija@posti.fi', 'Maija Mallikas', 'Klassinen');

INSERT INTO Person (username, password, email, full_name, user_info)
VALUES ('Mr. Smith', '12345678', 'mr@smith.fi', 'Mr. Smith', 'Suit');

INSERT INTO Person (username, password, email, full_name, user_info)
VALUES ('Mia', '12345678', 'mia@posti.fi', 'Mia M', 'Hipsteri');

INSERT INTO Person (username, password, email, full_name, user_info)
VALUES ('Marja', '12345678', 'marja@posti.fi', 'Marja M', 'Klassinen');

INSERT INTO Item (type, brand, color, material, image)
VALUES ('Kauluspaita', 'Gant', 'Vaaleansininen', 'Puuvilla', 'gant_vsin_kaulus.png');

INSERT INTO Item (type, brand, color, material, image)
VALUES ('Farkut', 'Cubus', 'Musta', 'Puuvilla', 'mustat_farkut_cubus.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Kengät', 'Converse', 'Valkoinen', 'conssit.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Paita', 'None', 'Valkoinen', 'paita.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Paita', 'None', 'Musta', 'paita.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Neule', 'None', 'Harmaa', 'neule.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Housut', 'Levis', 'Musta', 'levikset.png');

INSERT INTO Item (type, brand, color, material, image)
VALUES ('Farkut', 'Levis', 'Sininen', 'denim', '501.png');

INSERT INTO Item (type, brand, color, material, image)
VALUES ('Bleiseri', 'Armani', 'Musta', 'villa', 'armani_takki.png');

INSERT INTO Item (type, brand, color, material, image)
VALUES ('Housut', 'Armani', 'Musta', 'villa', 'armani_housut.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Kauluspaita', 'Selected', 'Valkoinen', 'juhlapaita.png');

INSERT INTO Item (type, brand, color, image)
VALUES ('Paita', 'None', 'Valkoinen', 'paita.png');

INSERT INTO Wardrobe (fk_wardrobe_person, fk_wardrobe_item)
VALUES ('1', '1');

INSERT INTO Wardrobe (fk_wardrobe_person, fk_wardrobe_item)
VALUES ('1', '2');

INSERT INTO Wardrobe (fk_wardrobe_person, fk_wardrobe_item)
VALUES ('2', '2');

INSERT INTO Wardrobe (fk_wardrobe_person, fk_wardrobe_item)
VALUES ('3', '3');

INSERT INTO Outfit VALUES(default);
-- fk_wardrobe_person = 1 AND fk_wardrobe_item = 1 LIMIT 1;