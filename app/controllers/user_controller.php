<?php

class UserController extends BaseController{
    
    public static function index(){
	    // Haetaan kaikki henkilöt tietokannasta
	    $people = Person::all();
	    // Renderöidään views/people kansiossa sijaitseva tiedosto index.html muuttujan $people datalla
	    View::make('User/index.html', array('people' => $people));
	}
	//Luontinäkymä
    public static function register() {
        View::make('User/register.html');
    }

    public static function handle_register() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;

        // Alustetaan uusi Person-luokan olion käyttäjän syöttämillä arvoilla
        // Tallennetaan erikseen attribuutit muuttujaan..
        $attributes = array(    'username' => $params['username'],
                                'password' => $params['password'],
                                'email' => $params['email'],
                                'full_name' => $params['full_name'],
                                'user_info' => $params['user_info']
        );
        //..ja luodaan olio attributestaulukon avulla
        $new_user = new Person($attributes);
        
        // kutsutaan item:in metodia errors, joka tarkistaa olivatko
        // attribuutit valideja
        $errors = $new_user->errors();

        if(count($errors) == 0) {
            // Validi item, tallennetaan
            // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
            $new_user->save();

            // Ohjataan käyttäjä rekisteröitymisen jälkeen kirjautumissivulle
            Redirect::to('/login', array('message' => 'Registeration complete! Please login'));
        }else{
            // Invalidi syöte
            // Luodaan uusi näkymä johon välitetään syötetyt arvot
            View::make('User/register.html', array( 
                                'errors' => $errors,
                                'attributes' => $attributes));
        }
    }

    public static function destroy() {
    	$params = $_POST;

    	$user_id = $params['user_id'];

    	$user_to_destroy = Person::find($user_id);
        $user_to_destroy->destroy();
        Redirect::to('/usermanagement', array('message' => 'User removed'));

    	View::make('notimplemented.html');
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

  	//Käsittele ḱirjautuminen
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