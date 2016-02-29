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
        // Haetaan kaikki asut tietokannasta kirjautuneen käyttäjän id:n perusteella
        $persons_outfits = Outfit::find_all_personal($_SESSION['user']);
        View::make('outfit/index.html', array('outfits' => $persons_outfits));
	}

	//Näytä yhden asun yksittäisnäkymä
	public static function show_by_outfit_id($outfit_id){
        self::check_logged_in();
        $persons_outfit = Outfit::find_one_personal($outfit_id, $_SESSION['user']);
        View::make('outfit/outfit.html', array('outfit' => $persons_outfit));
	}
}