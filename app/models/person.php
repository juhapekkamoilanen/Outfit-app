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
	    $query = DB::connection()->prepare('SELECT * FROM Person WHERE user_id = :user_id LIMIT 1');
	    //Suoritetaan kysely
	    $query->execute(array('user_id' => $id));
	    //Tallennetaan kyselyn ensimmäinen (ainoa) rivi
	    $row = $query->fetch();

	    //jos siinä on sisältöä niin luodaan olio ja palautetaan se
	    if($row){
	      	$person = new Person(array(
					'user_id' => $row['user_id'],
					'username' => $row['username'],
					'password' => $row['password'],
					'email' => $row['email'],
					'full_name' => $row['full_name'],
					'user_info' => $row['user_info'],
					));

	      	return $person;
	    }

	    return null;
  	}

  	public static function authenticate($username, $password) {
  		$query = DB::connection()->prepare('SELECT * FROM Person
  											WHERE username = :username
  											AND password = :password
  											LIMIT 1');
  		//Suoritetaan kysely
	    $query->execute(array('username' => $username, 'password' => $password));
	    //Tallennetaan kyselyn ensimmäinen (ainoa) rivi
	    $row = $query->fetch();
  		//jos siinä on sisältöä niin luodaan olio ja palautetaan se
	    return self::create_object($row);

  	}

  	private static function create_object($db_row) {
  		if($db_row){
	      	$person = new Person(array(
					'user_id' => $db_row['user_id'],
					'username' => $db_row['username'],
					'password' => $db_row['password'],
					'email' => $db_row['email'],
					'full_name' => $db_row['full_name'],
					'user_info' => $db_row['user_info'],
					));

	      	return $person;
	    }

	    return null;
  	} 



}