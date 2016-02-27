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

}