<?php

class ItemController extends BaseController{

	public static function index(){
    // Haetaan kaikki henkilöt tietokannasta
    $items = Item::all();

    // Renderöidään views/item kansiossa sijaitseva tiedosto index.html muuttujan $items datalla
    View::make('items/index.html', array('items' => $items));
	}
}