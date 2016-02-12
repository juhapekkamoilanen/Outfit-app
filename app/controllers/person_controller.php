<?php

class PersonController extends BaseController{
	
	public static function index(){
	    // Haetaan kaikki henkilöt tietokannasta
	    $people = Person::all();
	    // Renderöidään views/people kansiossa sijaitseva tiedosto index.html muuttujan $people datalla
	    View::make('people/index.html', array('people' => $people));
	}
}