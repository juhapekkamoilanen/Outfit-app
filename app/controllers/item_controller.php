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

    //Store
    public static function store(){
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        // Alustetaan uusi Item-luokan olion käyttäjän syöttämillä arvoilla
        $item = new Item(array( 'type' => $params['type'],
                                'brand' => $params['brand'],
                                'color' => $params['color'],
                                'color_2nd' => $params['color_2nd'],
                                'material' => $params['material'],
                                'image' => $params['image']
        ));


        //Pitää ehkä lisätä vielä erilliset metodit järjestelmään lisäämiseksi
        //ja järjestelmään+omaan vaatekaappiin lisäämiseksi

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $item->save();

        // Ohjataan käyttäjä lisäyksen jälkeen vaatteen esittelysivulle
        Redirect::to('/items/' . $item->item_id, array('message' => 'Vaate lisätty!'));
  }
}

/*
        $query->execute(array(  'item_id' => $params['item_id'],
                                'type' => $params['type'],
                                'brand' => $params['brand'],
                                'color' => $params['color'],
                                'color_2nd' => $params['color_2nd'],
                                'material' => $params['material'],
                                'image' => $params['image']
*/