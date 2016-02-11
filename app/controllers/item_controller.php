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
}