# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:



* [Sovellukseni kirjautumissivu](http://juhapekm.users.cs.helsinki.fi/vaatekaappi/login)
* [Sovellukseni "items"-sivu](http://juhapekm.users.cs.helsinki.fi/vaatekaappi/items)
* [Sovellukseni "item"-sivu](http://juhapekm.users.cs.helsinki.fi/vaatekaappi/items/1)
* [Sovellukseni "item_edit"-sivu](http://juhapekm.users.cs.helsinki.fi/vaatekaappi/items/1/edit)
* [Linkki dokumentaatiooni](https://github.com/juhapekkamoilanen/Tsoha-Bootstrap)
* [Linkki tietokantasivulle](http://juhapekm.users.cs.helsinki.fi/vaatekaappi/tietokantayhteys)
* [Linkki dokumentaatioon](https://github.com/juhapekkamoilanen/Tsoha-Bootstrap/blob/master/doc/Dokumentaatio.pdf)



## Työn aihe

Vaatekaappi-sovellus

Sovelluksen avulla käyttäjät voivat pitää kirjaa vaatteistaan ja niistä koostuvista asuyhdistelmistä.

Järjestelmän tarkoituksena on helpottaa vaatteiden valitsemista valmiiksi tallennettujen asukokonaisuuksien avulla. Vaatteista tallennetaan niiden tyyppi (housu, paita, jne), väri, materiaali ym. ominaisuuksia sekä mahdollisesti kuva. Käyttäjä voi koostaa järjestelmään tallennetuista vaatteista mieleisiään asuja, jotka tallennetaan järjestelmään käyttäjän antaman hyvyysarvon kera.


## TODO

- [x] Viikko 3 kesken, save-funktio puuttuu
- [x] Lisäyslomakkeet puuttuu
- [x] Linkitykset (napit yms.) aivan vaiheessa
- [x] Validatori item:lle
- [x] Virheilmoitus kun liian lyhyt syöte new-kenttään
- [x] item/new.html kenttiin attribuuttien välitys
- [x] 4.2 Muokkaus ja poisto itemille
- [ ] Muuta toistuvat painikkeet yms makroiksi
- [ ] 4.2 Poiston viesti näkyviin
- [x] 4.3 Kirjautuminen (session luonti)
- [x] 4.3.1 Session käyttäminen - oma vaatekaappi linkki
- [ ] 4.X Kirjautumisohje
- [ ] Wardrobe-näkymässä "lisää vaate"-nappi toimittava niin että lisää samalla henkilön vaatekaappiin


- [ ] /User/new.html
- [ ] /User/edit.html

- [ ] viestien ja virheiden näyttäminen basemalliin?
- [x] Tyhjät virheilmoitukset pois näkyvistä (vihreä loota)
- [ ] Testidataa laitettava lisää - asuja ei vielä yhtään tietokannassa!
- [ ] Dokumentaation kaaviot päivitettävä
- [ ] Controllereita, malleja, näkymiä tehtävä lisää ja kuntoon (nyt vasta olemassa ensimmäiset testiversiot: vaatekaappi/people, vaatekaappi/items, vaatekaappi/items/1)
- [ ] SQL kyselyt mietittävä - mitä toimintoja tarvii?
- [ ] Muokkaa-napin (Your wardrobe - näkymässä) ei saa muuttaa muiden lisäämiä samoja vaatteita