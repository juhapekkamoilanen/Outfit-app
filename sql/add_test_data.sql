-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Person (username, password, email, full_name, user_info)
VALUES ('Maija', '12345678', 'maija@posti.fi', 'Maija M', 'Klassinen');

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