<?php

class WardrobeController extends BaseController{
    
    //Keskeneräisten sivujen näkymä
	public static function kesken(){
        View::make('notimplemented.html');
	}

    //Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id(){
        self::check_logged_in();
        // Haetaan kaikki vaatteet tietokannasta kirjautuneen käyttäjän id:n perusteella
        $persons_items = Wardrobe::find_by_person_id($_SESSION['user']);
        // Renderöidään views/wardrobe kansiossa sijaitseva tiedosto
        // wardrobe.html muuttujan $persons_items datalla
        View::make('wardrobe/wardrobe.html', array('persons_items' => $persons_items));
	}

    //tallenna vaate vaatekaappiin kirjautuneen user_id:n ja _POST item_id:n perusteella
    //tätä metodi kutsutaan "All items"näkymästä "Add"-painikkeella
    public static function save_item_to_wardrobe(){
        self::check_logged_in();
        $params = $_POST;
        Wardrobe::add_item_for_person($params['item_id'], $_SESSION['user']);
        Redirect::to('/items/', array('message' => 'Vaate lisätty!'));
    }

    //luo uuden vaatteen luontinäkymä
    public static function create_new_item_to_wardrobe(){
        self::check_logged_in();
        View::make('wardrobe/new_item.html');
    }

    //tallenna uusi item järjestelmään ja vaatekaappiin
    public static function save_new_item_to_wardrobe(){
        self::check_logged_in();
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
            //tallennetaan mys käyttäjän vaatekaappiin
            Wardrobe::add_item_for_person($item->item_id, $_SESSION['user']);
            // Ohjataan käyttäjä lisäyksen jälkeen vaatteen esittelysivulle
            Redirect::to('/wardrobe/wardrobe.html', array('message' => 'Vaate lisätty!'));
        }else{
            // Invalidi syöte
            // Luodaan uusi näkymä johon välitetään syötetyt arvot
            View::make('wardrobe/new_item.html', array( 
                                'errors' => $errors,
                                'attributes' => $attributes
            ));
        }
        
    }

        
        
}