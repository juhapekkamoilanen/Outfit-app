<?php

/*Vaatekaappiluokka

Vaatekaappi sql-taulu on käytännössä yksi suuri taulukko, jossa
rivillä on Henkilon ja Vaatteen ID:t. Taulua voi kuvitella
jättimäisenä vaatekaappina, josta kukin näkee omat vaatteensa.
"Hengareissa" ei oikeasti riipu heidän vaatteitaan vaan pelkät
viitteet vaatteisiin, jotka sijaitsevat varastossa. Kutakin vaatetta on
varastossa vain yksi kappale vaikka se kuuluisi monen henkilön
vaatekaappiin.

Vaatekaappi-luokka on taulukon yksi rivi!
*/
class Wardrobe extends BaseModel{
	//Attribuutit
	public $fk_wardrobe_person, $fk_wardrobe_item;
	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
	}
	/*
	fk_wardrobe_person SERIAL REFERENCES Person,
	fk_wardrobe_item SERIAL REFERENCES Item,
	*/

	public static function all(){
		//Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM Wardrobe');
		//Suoritetaan kysely
		$query->execute();
		//tallennetaan rowt kyselystä
		$rows = $query->fetchAll();

		//alustetaan muuttuja vaatteille
		$items_in_wardrobe = Array();

		//käydään rowt läpi ja lisätään items_in_wardrobe-taulukkoon
		foreach ($rows as $row) {
			//tallennetaan kyselyn row taulukkoon Wardrobe-oliona
			$items_in_wardrobe[] = new Wardrobe(array(
				'fk_wardrobe_person' => $row['fk_wardrobe_person'],
				'fk_wardrobe_item' => $row['fk_wardrobe_item'],
			));
		}
		return $items_in_wardrobe;
	}
	/* Hae yhden henkilön vaatekaapin sisältö
	Haetaan tietokannasta Wardrobe-taulusta ne rowt joissa 
	person_id vastaa parametrina annettua.
	*/ 
	public static function find_by_person_id($person_id){
		//Haetaan wardrobe liitostaulusta person_id:tä vastaavat rivit
	    $wr_query = DB::connection()
	    	->prepare('	SELECT * FROM Wardrobe 
	    				WHERE fk_wardrobe_person = :person_id');
	    //Suoritetaan kysely
	    $wr_query->execute(array('person_id' => $person_id)); //Mihin 'person_id' viittaa?!
	    //keltaisella merkityt kunhan on samat niin ok?

	    //Tallennetaan rivit
	    $rows = $wr_query->fetchAll();


	    //alustetaan muuttuja vaatekaapin vaatteille
		$persons_items_in_wardrobe = Array();

		//TODO virheentarkistus jos ei tuloksia

	    //haetaan vielä vaatevarastosta eli items-taulusta
	    //henkilön vaatteiden tiedot wardrobe-liitostaulusta saatujen viitteiden perusteella
	    
	    //käydään viitteet läpi ja
	    foreach ($rows as $row) {
	    	//haetaan niitä vastaavat Itemit DB:stä
	    	$item_query = DB::connection()
	    		->prepare('	SELECT * FROM Item 
	    					WHERE item_id = :item_id_wr 
	    					LIMIT 1'
	    	);
	    	//VÄÄRIN: $item_query->execute(array('item_id' => $row['item_id']));
	    	//wardrobe-taulussa ei ole item_id saraketta, joten $row['item_id']:tä ei ole olemassa
	    	$item_query->execute(array('item_id_wr' => $row['fk_wardrobe_item']));
	    	$one_item = $item_query->fetch();

	    	//tallennetaan haettu itemi taulukkoon 
	    	$persons_items_in_wardrobe[] = new Item(array(
					'item_id' => $one_item['item_id'],
					'type' => $one_item['type'],
					'brand' => $one_item['brand'],
					'color' => $one_item['color'],
					'color_2nd' => $one_item['color_2nd'],
					'material' => $one_item['material'],
					'image' => $one_item['image']
					));  	
	    }
	    return $persons_items_in_wardrobe;
  
  	}
	/*
	Tämä saattaa olla tarpeeton metodi
	Tärkeämpi on etsiä wardrobe-taulusta tietyn henkilön vaatteet

	public static function find($person_id, $item_id){
		//Haetaan tietokannasta Wardrobe-taulusta ne rowt joissa 
		//person_id ja item_id vastaavat parametreina annettuja
	    $query = DB::connection()
	    	->prepare('	SELECT * FROM Wardrobe 
	    				WHERE fk_wardrobe_person = :person_id
	    				AND fk_wardrobe_item = :item_id
	    				LIMIT 1');
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
  	*/
}
/*
SELECT * FROM Wardrobe WHERE fk_wardrobe_person = 1 AND fk_wardrobe_item = 1 LIMIT 1;
*/