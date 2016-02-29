<?php

class Outfit extends BaseModel{
	//Attributes
	public $outfit_id; //int
	public $items; //array
	public $rating; //int
	public $comment; //str

	//Constructor
	public function __construct($attributes) {
		parent::__construct($attributes);
	}

	/**
  	* Get all outfits (objects)
  	* rating and comment will be null for non-personal outfits
  	* @param
 	* @return array of outfit objects
  	*/
  	public static function get_all_outfits() {
  		//Get all outfit_ids from db
		$all_outfit_ids = Outfit::get_all_outfits_from_db();

		//if empty return null
		if (!$all_outfit_ids) {
			return null;
		}

		//Array for outfits
		$all_outfits = Array();

		//Create outfit object for every id
		foreach ($all_outfit_ids as $id) {
			//Get items (objects, array) in outfit
			$items_in_outfit = Outfit::get_item_objects_in_outfit($id[0]);
			//add new outfit object to array
			$all_outfits[] = new Outfit(array(
				'outfit_id' => $id[0],
				'items' => $items_in_outfit,
				'rating' => null,
				'comment' => null
			));
		}
		return $all_outfits;
  	}

  	public static function get_one_public($outfit_id) {
  		//array for items
		$items_in_outfit = Outfit::get_item_objects_in_outfit($outfit_id);

		//if empty return null
		if (!$items_in_outfit) {
			return null;
		}
			
		//create new outfit object
		$outfit = new Outfit(array(
			'outfit_id' => $outfit_id,
			'items' => $items_in_outfit,
			'rating' => null,
			'comment' => null
		));

		return $outfit;
  	}

  	/**
  	* Get all outfits from a persons collection
  	* @param person_id / user_id
 	* @return array of outfit objects
  	*/
  	public static function find_one_personal($outfit_id, $person_id) {
  		//Get outfit that person has in their collection
  		$outfit_in_collection = Outfit::get_personal_collection_row($outfit_id, $person_id);

  		//if empty return null
  		if (!$outfit_in_collection) {
  			return null;
  		}

		//outfit_id of collection row
		$outfit_id = $outfit_in_collection['fk_outfitcollection_outfit'];
		//rating of collection row
		$rating = $outfit_in_collection['rating'];
		//comment of collection row
		$comment = $outfit_in_collection['comment'];
			
		//array for items
		$items_in_outfit = Outfit::get_item_objects_in_outfit($outfit_id);
			
		//create new outfit object
		$outfit = new Outfit(array(
			'outfit_id' => $outfit_id,
			'items' => $items_in_outfit,
			'rating' => $rating,
			'comment' => $comment
		));
		return $outfit;
  	}

  	/**
  	* Get all outfits (objects) from a persons outfitcollection
  	* @param person_id / user_id
 	* @return array of outfit objects
  	*/
  	public static function find_all_personal($person_id) {
  		//Get outfits that person has in their collection
  		$collection = Outfit::get_personal_collection_rows($person_id);

  		//Variable for outfit-objects
		$outfits = Array();

		//Iterate though collection
		foreach ($collection as $row) {
			//outfit_id of collection row
			$outfit_id = $row['fk_outfitcollection_outfit'];
			
			//array for items
			$items_in_outfit = Outfit::get_item_objects_in_outfit($outfit_id);
			
			//add new outfit object to array
			$outfits[] = new Outfit(array(
				'outfit_id' => $outfit_id,
				'items' => $items_in_outfit,
				'rating' => $row['rating'],
				'comment' => $row['comment']
			));
		}
		return $outfits;
  	}

  	//PRIVATE METHODS - database access

  	/**
  	* Get every outfit in from database - non-personal
  	* @param
 	* @return array of ids
  	*/
  	private static function get_all_outfits_from_db() {
  		//initialize query
		$outfit_query = DB::connection()
			->prepare(' SELECT * FROM Outfit');

		//execute query
		$outfit_query->execute(array());

		//collect results
		$ids = $outfit_query->fetchAll();

		if ($ids) {
			return $ids;
		} else {
			return null;
		}
  	}

  	/**
  	* Get spesific outfit from a persons collection database
  	* @param person_id / user_id
 	* @return collection row array (person_id, outfit_id, rating, comment)
  	*/
  	private static function get_personal_collection_row($outfit_id, $person_id) {
  		//initialize query
		$outfit_query = DB::connection()
			->prepare(' SELECT * FROM Outfitcollection
						WHERE fk_outfitcollection_person = :person_id
						AND fk_outfitcollection_outfit = :outfit_id
						LIMIT 1'
		);

		//execute query
		$outfit_query
			->execute(array('person_id' => $person_id, 'outfit_id' => $outfit_id
		));

		//collect results
		$row = $outfit_query->fetch();
		
		//return if not empty
		if ($row) {
			return $row;
		} else {
			return null;
		}
  	}

  	/**
  	* Get a persons collection (array of arrays) from database
  	* @param person_id / user_id
 	* @return array of collection rows (person_id, outfit_it, rating, comment)
  	*/
  	private static function get_personal_collection_rows($person_id) {
  		//initialize query
		$outfit_query = DB::connection()
			->prepare(' SELECT * FROM Outfitcollection
						WHERE fk_outfitcollection_person = :person_id'
		);

		//execute query
		$outfit_query
			->execute(array('person_id' => $person_id
		));

		//collect results
		$rows = $outfit_query->fetchAll();
		
		//return if not empty
		if ($rows) {
			return $rows;
		} else {
			return null;
		}
  	}

  	/**
  	* Get items (objects) in given outfit
   	* @param outfit_id
 	* @return array of items (objects) in this outfit
  	*/
  	private static function get_item_objects_in_outfit($outfit_id) {
  		//array for items
		$item_ids_in_outfit = Array();

		//DB query
  		$item_ids_in_outfit_query = DB::connection()
				->prepare(' SELECT fk_outfititems_item FROM Outfititems
							WHERE fk_outfititems_outfit = :outfit_id'
		);
		$item_ids_in_outfit_query
			->execute(array('outfit_id' => $outfit_id));
		$item_ids_in_outfit = $item_ids_in_outfit_query->fetchAll(); // = (id, id, id, ...)
		
		//array for item_objects
		$item_objects = Array();

		//iterate through outfit_ids, creating item_objects, adding to array
		foreach ($item_ids_in_outfit as $item_id) {
			$item_objects[] = Item::find($item_id[0]); //@item_id is array with 1 node
		}
		//return objects or null
		if ($item_objects) {
			return $item_objects;
		} else {
			return null;
		}
	}


}