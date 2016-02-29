<?php

class OutfitController extends BaseController{

    //Show aĺl outfits in system
	public static function index(){
        $all_outfits = Outfit::get_all_outfits();
        View::make('outfit/all_index.html', array('outfits' => $all_outfits));
	}

    //Show one item - public view
	public static function show($id){
		$outfit = Outfit::get_one_public($id);
		View::make('outfit/outfit.html', array('outfit' => $outfit));
	}

	//Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id(){
        self::check_logged_in();
        // Haetaan kaikki asut tietokannasta kirjautuneen käyttäjän id:n perusteella
        $persons_outfits = Outfit::find_all_personal($_SESSION['user']);
        View::make('outfit/personal_index.html', array('outfits' => $persons_outfits));
	}

	//Näytä yhden asun yksittäisnäkymä
	public static function show_by_outfit_id($outfit_id){
        self::check_logged_in();
        $persons_outfit = Outfit::find_one_personal($outfit_id, $_SESSION['user']);
        View::make('outfit/outfit.html', array('outfit' => $persons_outfit));
	}

	//Create new - view
	public static function create() {
		self::check_logged_in();
		$persons_items = Wardrobe::find_by_person_id($_SESSION['user']);
        View::make('outfit/new.html', array('items' => $persons_items));
	}
}