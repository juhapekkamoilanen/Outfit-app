<?php

class ItemController extends BaseController{

	public static function index(){
    // Haetaan kaikki vaatteet tietokannasta
    $items = Item::all();

    // Renderöidään views/item kansiossa sijaitseva tiedosto index.html muuttujan $items datalla
    View::make('items/index.html', array('items' => $items));
	}

	public static function show($id){
    // Haetaan tietokannasta vaate, jonka id parametrina
    $item = Item::find($id);

    // Renderöidään views/items kansiossa sijaitseva tiedosto item.html muuttujan $item datalla
    View::make('items/item.html', array('item' => $item));
	}
}