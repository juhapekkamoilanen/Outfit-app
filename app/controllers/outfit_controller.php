<?php

class OutfitController extends BaseController{

    //Keskeneräisten sivujen näkymä
	public static function index(){
        View::make('notimplemented.html');
	}

    //Yksittäisnäkymä asulle
	public static function show($id){
	}

	//Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id(){
        self::check_logged_in();
        // Haetaan kaikki vaatteet tietokannasta kirjautuneen käyttäjän id:n perusteella
        $persons_outfits = Outfit::find_all_by_person_id($_SESSION['user']);
        // Renderöidään views/wardrobe kansiossa sijaitseva tiedosto
        // wardrobe.html muuttujan $persons_items datalla
        Kint::dump($persons_outfits);
        View::make('notimplemented.html');
        //View::make('outfit/index.html', array('outfits' => $persons_outfits));
	}
}