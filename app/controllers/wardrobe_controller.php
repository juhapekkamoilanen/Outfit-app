<?php

class WardrobeController extends BaseController{
    
    //Keskeneräisten sivujen näkymä
	public static function kesken(){
        View::make('notimplemented.html');
	}

    //Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id($id){
        self::check_logged_in();
        // Haetaan kaikki vaatteet tietokannasta person_id:n perusteella
        $persons_items = Wardrobe::find_by_person_id($id);
        // Renderöidään views/wardrobe kansiossa sijaitseva tiedosto
        // wardrobe.html muuttujan $persons_items datalla
        View::make('wardrobe/wardrobe.html', array('persons_items' => $persons_items));
	}
        
        //Store - KOPIO item-kontrollerista
        /*
        public static function store(){
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        // Alustetaan uusi Item-luokan olion käyttäjän syöttämillä arvoilla
        // Tallennetaan erikseen attribuutit muuttujaan..
        $attributes = array(    'type' => $params['type'],
                                'brand' => $params['brand'],
                                'color' => $params['color'],
                                'color_2nd' => $params['color_2nd'],
                                'material' => $params['material'],
                                'image' => $params['image']
        );
        //..ja luodaan olio attributestaulukon avulla
        $item = new Item($attributes);
        // kutsutaan item:in metodia errors, joka tarkistaa olivatko
        // attribuutit valideja
        $errors = $item->errors();
        
        if(count($errors) == 0) {
            // Validi item, tallennetaan
            // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
            $item->save();
            // Ohjataan käyttäjä lisäyksen jälkeen vaatteen esittelysivulle
            Redirect::to('/items/' . $item->item_id, array(
                                'message' => 'Vaate lisätty!'));
        }else{
            // Invalidi syöte
            // Luodaan uusi näkymä johon välitetään syötetyt arvot
            View::make('items/new.html', array( 
                                'errors' => $errors,
                                'attributes' => $attributes));
        }
        
         */
}