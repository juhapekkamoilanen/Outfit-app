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
		//tallennetaan rowt kyselystä
		$rowt = $query->fetchAll();

		//alustetaan muuttuja vaatteille
		$items = Array();

		//käydään rowt läpi ja lisätään items-taulukkoon
		foreach ($rowt as $row) {
			//tallennetaan kyselyn row taulukkoon item-oliona
			$items[] = new Item(array(
				'item_id' => $row['item_id'],
				'type' => $row['type'],
				'brand' => $row['brand'],
				'color' => $row['color'],
				'color_2nd' => $row['color_2nd'],
				'material' => $row['material'],
				'image' => $row['image'],
			));
		}


		return $items;

	}

	public static function find($item_id){
		//Haetaan tietokannasta Item-taulusta ne rowt joissa item_id on parametrinä annettu
	    $query = DB::connection()->prepare('SELECT * FROM Item WHERE item_id = :item_id LIMIT 1');
	    //Suoritetaan kysely
	    $query->execute(array('item_id' => $item_id));
	    //Tallennetaan kyselyn ensimmäinen (ainoa) row
	    $row = $query->fetch();

	    //jos siinä on sisältöä niin luodaan olio ja palautetaan se
	    if($row){
	      	$item = new Item(array(
					'item_id' => $row['item_id'],
					'type' => $row['type'],
					'brand' => $row['brand'],
					'color' => $row['color'],
					'color_2nd' => $row['color_2nd'],
					'material' => $row['material'],
					'image' => $row['image'],
					));

	      	return $item;
	    }

	    return null;
  
  	}

  	public function save(){
	    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
	    $query = DB::connection()
	    	->prepare('	INSERT INTO Item 	(type, brand, color, color_2nd, material, image) 
	    				VALUES 				(:type, :brand, :color, :color_2nd, :material, :image) 
	    									RETURNING item_id'
	    );
	    $query->execute(array(	'type' => $this->type, 
	    						'brand' => $this->brand, 
	    						'color' => $this->color,
	    						'color_2nd' => $this->color_2nd,
	    						'material' => $this->material,
	    						'image' => $this->image
	    ));
	    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
	    $row = $query->fetch();
	    Kint::trace();
  		Kint::dump($row);
	    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
	    $this->item_id = $row['item_id'];

	    return $this->item_id;
  	}
}
