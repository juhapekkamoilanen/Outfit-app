<?php

class WardrobeController extends BaseController{

    //Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id(){
        // Haetaan kaikki vaatteet tietokannasta
        $persons_items = Wardrobe::find_by_person_id();

        // Renderöidään views/item kansiossa sijaitseva tiedosto index.html muuttujan $items datalla
        View::make('items/index.html', array('items' => $items));
	}