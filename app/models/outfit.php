<?php

class Outfit extends BaseModel{
	//Attribuutit
	public $outfit_id, $items, $rating, $comment; //int, array, int, str
	
	//Konstruktori
	public function __construct($attributes) {
		parent::__construct($attributes);
	}

	public static function find_all_by_person_id($person_id) {
		//alustetaan kysely
		$outfit_query = DB::connection()
			->prepare(' SELECT * FROM Outfitcollection
						WHERE fk_outfitcollection_person = :current_person'
		);
		//suoritetaan kysely
		$outfit_query
			->execute(array('current_person' => $person_id
		));
		//kerätään tulokset
		$rows = $outfit_query->fetchAll();
		//muuttuja asuille
		$outfits = Array(); //sisältää outfit-olioita

		//käydään läpi rivi (asu) kerrallaan
		foreach ($rows as $row) {
			//row = (Fk_outfitcollection_person, Fk_outfitcollection_outfit, Rating, Comment)

			$outfit_id = $row['fk_outfitcollection_outfit'];
			//muuttuja itemeille
			$items_in_outfit = Array();
			//haetaan 
			$items_in_outfit_query = DB::connection()
				->prepare(' SELECT * FROM Outfititems
							WHERE fk_outfititems_outfit = :outfit_id'
			);
			$items_in_outfit_query
				->execute(array('outfit_id' => $outfit_id));
			$items_in_outfit = $items_in_outfit_query->fetchAll(); // = (id, id, id, ...)
			$outfits[] = new Outfit(array(
				'outfit_id' => $outfit_id,
				'items' => $items_in_outfit,
				'rating' => $row['rating'],
				'comment' => $row['comment']
			));
		}
		return $outfits;
	}

	public static function find($outfit_id){
		//tietokantahaku, alustus
		$items_in_outfit_query = DB::connection()
			->prepare(' SELECT * FROM Outfititems
						WHERE fk_outfititems_outfit = :outfit_id'
		);
		//tietokantahaku, suoritus
		$items_in_outfit_query
			->execute(array('outfit_id' => $outfit_id));

		//tulokset taĺteen
		$item_ids_in_outfit = Array();
		$item_ids_in_outfit = $items_in_outfit_query->fetchAll();

		//item olioille taulukko
		$item_objects_in_wardrobe = Array();

		//items_in_outfit sisältää pelkät outfit_id:t ja item_id:t
		foreach ($item_ids_in_outfit as $item_in_outfit) {
	    	//haetaan niitä vastaavat Itemit DB:stä
	    	$item_query = DB::connection()
	    		->prepare('	SELECT * FROM Item 
	    					WHERE item_id = :item_id 
	    					LIMIT 1'
	    	);
	    	
	    	$item_query->execute(array('item_id' => $item_in_outfit['fk_outfititems_item']));
	    	$one_item = $item_query->fetch();

	    	//tallennetaan haettu itemi taulukkoon 
	    	$item_objects_in_wardrobe[] = new Item(array(
					'item_id' => $one_item['item_id'],
					'type' => $one_item['type'],
					'brand' => $one_item['brand'],
					'color' => $one_item['color'],
					'color_2nd' => $one_item['color_2nd'],
					'material' => $one_item['material'],
					'image' => $one_item['image']
					));  	
	    }
		return $item_objects_in_wardrobe;
	    
  	}



}