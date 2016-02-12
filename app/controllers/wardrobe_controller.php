<?php

class WardrobeController extends BaseController{
    
    //Keskeneräisten sivujen näkymä
	public static function kesken(){
        View::make('notimplemented.html');
	}

    //Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id($id){
        // Haetaan kaikki vaatteet tietokannasta person_id:n perusteella
        $persons_items = Wardrobe::find_by_person_id($id);
        
        
        Kint::dump($persons_items);

        
        // Renderöidään views/wardrobe kansiossa sijaitseva tiedosto
        // wardrobe.html muuttujan $persons_items datalla
        View::make('wardrobe/wardrobe.html', array('persons_items' => $persons_items));
	}
}