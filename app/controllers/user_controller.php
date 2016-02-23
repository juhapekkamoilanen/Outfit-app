<?php

class UserController extends BaseController{
    
    public static function index(){
	    // Haetaan kaikki henkilöt tietokannasta
	    $people = Person::all();
	    // Renderöidään views/people kansiossa sijaitseva tiedosto index.html muuttujan $people datalla
	    View::make('User/index.html', array('people' => $people));
	}

    //Keskeneräisten sivujen näkymä
	public static function kesken(){
        View::make('notimplemented.html');
	}

	public static function login(){
		View::make('User/login.html');
	}

	public static function logout(){
    	$_SESSION['user'] = null;
    	Redirect::to('/login', array('message' => 'You have logget out!'));
  	}

	public static function handle_login(){
		//_POST parametrit (superglobaali)
		//sisältää key-value taulukon, jossa key:t ovat html-lomakkeen ruuduille (form-group)
		//annetut nimet (esim. name = "username") ja valuet ovat käyttäjän niihin syöttämät arvot
		$params = $_POST;

		//haetaan tietokannasta käyttäjä joka vastaa parametrejä
		$user = Person::authenticate($params['username'], $params['password']);

		//jos ei löydy (ja palautui null)
		if (!$user) {
			//luodaan kirjautumissivu uudelleen ja näytetään virheviesti ja välitetään jo
			//kerran käyttäjän syöttämä käyttäjätunnus html-lomakkeelle.
			//Parametrit välitetään html-sivulle yhtenä key-value taulukkona, josta
			//html-sivu käsittelee ne avaimien perusteella eli html-sivun osattava
			//etsiä taulukosta avainta 'error' ja avainta 'username'
			View::make('User/login.html', array(	'error' => 'Wrong username or password', 
													'username' => $params['username']));
		} else {
			//jos kirjautuminen onnistui niin alustetaan sessio
			//eli _SESSION globaaliin lisätään 'user'-avaimen arvoksi löytyneen käyttäjän user_id
			$_SESSION['user'] = $user->user_id;
			//ohjataan aloitussivulle
			if(!$user->full_name) {
				//jos käyttäjälle ei ole koko nimeä tallennettuna
				Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '!'));
			} else {
				//jos on koko nimi tallennettuna
				Redirect::to('/', array('message' => 'Welcome back ' . $user->full_name . '!'));
			}
		}
			
	}
}