<?php

class Item extends BaseModel{
	//Attribuutit
	public $item_id, $type, $brand, $color, $color_2nd, $material, $image;
	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
	}


	
	public static function all(){
		//Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM Item');
		//Suoritetaan kysely
		$query->execute();
		//tallennetaan rivit kyselystä
		$rivit = $query->fetchAll();

		//alustetaan muuttuja vaatteille
		$items = Array();

		//käydään rivit läpi ja lisätään items-taulukkoon
		foreach ($rivit as $rivi) {
			//tallennetaan kyselyn rivi taulukkoon item-oliona
			$items[] = new Item(array(
				'item_id' => $rivi['item_id'],
				'type' => $rivi['type'],
				'brand' => $rivi['brand'],
				'color' => $rivi['color'],
				'color_2nd' => $rivi['color_2nd'],
				'material' => $rivi['material'],
				'image' => $rivi['image'],
			));
		}


		return $items;

	}

	public static function find($id){
		//Haetaan tietokannasta Item-taulusta ne rivit joissa item_id on parametrinä annettu
	    $query = DB::connection()->prepare('SELECT * FROM Item WHERE item_id = :id LIMIT 1');
	    //Suoritetaan kysely
	    $query->execute(array('item_id' => $id));
	    //Tallennetaan kyselyn ensimmäinen (ainoa) rivi
	    $row = $query->fetch();

	    //jos siinä on sisältöä niin luodaan olio ja palautetaan se
	    if($row){
	      	$item = new person(array(
					'item_id' => $rivi['item_id'],
					'type' => $rivi['type'],
					'brand' => $rivi['brand'],
					'color' => $rivi['color'],
					'color_2nd' => $rivi['color_2nd'],
					'material' => $rivi['material'],
					'image' => $rivi['image'],
					));

	      	return $item;
	    }

	    return null;
  
  	}

}