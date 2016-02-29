# Tietokantasovelluksen esittelysivu

username: Maija
password: 12345678

Yleisiä linkkejä:

* [Katso käynnistysopas](https://github.com/juhapekkamoilanen/Tsoha-Bootstrap/tree/master/doc/Kaynnistysopas1.pdf)

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

- [x] 4.2 Poiston viesti näkyviin
- [x] 4.3 Kirjautuminen (session luonti)
- [x] 4.3.1 Session käyttäminen - oma vaatekaappi linkki
- [x] 4.X Kirjautumisohje
- [x] outfit model 
- [x] outfit model - find all by person id
- [x] outfit controller - show all by person id
- [x] views: outfits/:person_id
- [ ] all outfit view

- [x] /User/new.html
- [ ] /User/edit.html
- [x] Item listaus näkymän napilla vaatekaappiin lisäys
- [x] Wardrobe-näkymässä "lisää vaate"-nappi toimittava niin että lisää samalla henkilön vaatekaappiin
- [ ] saman vaatteen vaatekaappiin lisäysvirhe
- [ ] itemin poisto (vaikka viittauksia)
- [ ] Muuta toistuvat painikkeet yms makroiksi

- [ ] viestien ja virheiden näyttäminen basemalliin?
- [x] Tyhjät virheilmoitukset pois näkyvistä (vihreä loota)
- [x] Testidataa laitettava lisää - asuja ei vielä yhtään tietokannassa!
- [ ] Dokumentaation kaaviot päivitettävä
- [ ] Muokkaa-napin (Your wardrobe - näkymässä) ei saa muuttaa muiden lisäämiä samoja vaatteita
