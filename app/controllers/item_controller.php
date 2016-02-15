<?php

class ItemController extends BaseController{


    //Kaikkien vaatteiden listausnäkymä
	public static function index(){
        // Haetaan kaikki vaatteet tietokannasta
        $items = Item::all();

        // Renderöidään views/item kansiossa sijaitseva tiedosto index.html muuttujan $items datalla
        View::make('items/index.html', array('items' => $items));
	}


    //Yksittäisnäkymä vaatteelle
	public static function show($id){
        // Haetaan tietokannasta vaate, jonka id parametrina
        $item = Item::find($id);

        // Renderöidään views/items kansiossa sijaitseva tiedosto item.html muuttujan $item datalla
        View::make('items/item.html', array('item' => $item));
	}


    //Luontinäkymä
    public static function create() {
        View::make('items/new.html');
    }


    //Muokkaus - lomakkeen luonti
    public static function edit($item_id) {
        //haetaan tietokannasta kysytyn id:n item-olio
        $item = Item::find($item_id);
        //luodaan näkymä editointi varten
        View::make('items/edit.html', array('attributes' => $item));
    }


    //Muokkaus - lomakkeen käsittely
    public static function update($item_id) {
        $params = $_POST;

        $attributes = array(
            'item_id' => $item_id,
            'type' => $params['type'],
            'brand' => $params['brand'],
            'color' => $params['color'],
            'color_2nd' => $params['color_2nd'],
            'material' => $params['material'],
            'image' => $params['image'] 
            );

        $edited_item = new Item($attributes);
        $errors = $edited_item->errors();

        if (count($errors) > 0) {
            //luodaan editointinäkymä uudelleen virheilmoitusten kanssa
            View::make('items/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            //kutsutaan luodun olion update-metodia
            $edited_item->update(); 
            //Ohjataan käyttäjä luodun vaatteen sivulle viestin kanssa
            Redirect::to('/items/' . $edited_item->item_id, array('message' => 'Item successfully edited'));

        }
    }


    //Poisto
    public static function destroy($item_id) {
        Kint::dump('destroymetodissa');
        Kint::dump($item_id);
        
        $item_to_destroy = Item::find($item_id);
        Kint::dump();
        $item_to_destroy->destroy();
        //Alustetaan uusi item-olio annetulla id:llä
        //$item_to_destroy = new Item($item_id);
        //Kutsutaan luodun olion destroy-metodia, jonka avulla saadaan haluttu item poistettua
        //$item_to_destroy->destroy();
        //Ohjataan käyttäjä vaatteiden listaussivulle viestin kanssa
        Redirect::to('/items', array('message' => 'Item successfully deleted'));
        

    }



 

    //Store
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


    }
}
