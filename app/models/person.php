<?php

class Person extends BaseModel{
	//Attribuutit
	public $user_id, $username, $password, $email, $full_name, $user_info;
	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
	}
	
	public static function all(){
		//Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM Person');
		//Suoritetaan kysely
		$query->execute();
		//tallennetaan rivit kyselystä
		$rivit = $query->fetchAll();

		Kint::dump($rivit);
		//alustetaan muuttuja vaatteille
		$people = Array();

		//käydään rivit läpi ja lisätään items-taulukkoon
		foreach ($rivit as $rivi) {
			//tallennetaan kyselyn rivi taulukkoon item-oliona
			$people[] = new person(array(
				'user_id' => $rivi['user_id'],
				'username' => $rivi['username'],
				'password' => $rivi['password'],
				'email' => $rivi['email'],
				'full_name' => $rivi['full_name'],
				'user_info' => $rivi['user_info'],
			));
		}

		Kint::dump($people);

		return $people;

	}

	public static function find($id){
		//Haetaan tietokannasta Person-taulusta ne rivit joissa user_id on parametrinä annettu
	    $query = DB::connection()->prepare('SELECT * FROM Person WHERE user_id = :id LIMIT 1');
	    //Suoritetaan kysely
	    $query->execute(array('user_id' => $id));
	    //Tallennetaan kyselyn ensimmäinen (ainoa) rivi
	    $row = $query->fetch();

	    //jos siinä on sisältöä niin luodaan olio ja palautetaan se
	    if($row){
	      	$person = new person(array(
					'user_id' => $rivi['user_id'],
					'username' => $rivi['username'],
					'password' => $rivi['password'],
					'email' => $rivi['email'],
					'full_name' => $rivi['full_name'],
					'user_info' => $rivi['user_info'],
					));

	      	return $person;
	    }

	    return null;
  
  	}

}