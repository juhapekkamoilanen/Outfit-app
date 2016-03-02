<?php

class Outfit extends BaseModel{
	//Attributes
	public $outfit_id; //int
	public $items; //array (objects)
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

  	public static function remove_from_collection($person_id, $item_id) {
		Outfit::remove_from_collection_db($person_id, $item_id);
	}

  	/**
  	* Create new outfit to system and current users collection
  	* Method makes databaseoperations to 3 tables:
  	* 1) new outfit_id (outfit table)
  	* 2) items to outfit (outfititems table)
  	* 3) outfit to personal collection (outfitcollection)
  	* @param $person_id - controllers gets it from $_SESSION['user']
 	* @return 
  	*/
  	public function save_to_db($person_id) {
  		//db operation 1)
  		$new_outfit_id = $this->create_new_outfit_id();
  		
  		//modify this objects id: null -> $new_outfit_id
  		$this->outfit_id = $new_outfit_id;
  		
  		//dp operation 2)
  		foreach ($this->items as $item) {
  			//$item type is (object)
  			$this->add_item_to_outfit($new_outfit_id, $item->item_id);
  		}

  		//dp operation 3)
  		$this->add_to_collection($person_id);
  	}

  	//PRIVATE METHODS - database access

  	/**
  	* Insert a new default outfit_id to database
  	* outfit-table has only 1 column: outfit_id
  	* @param
 	* @return created id (int)
  	*/
  	private function create_new_outfit_id() {
  		//initialize query
  		$creation_query = DB::connection()
  			->prepare('INSERT INTO Outfit
  				VALUES (DEFAULT)
  				RETURNING outfit_id'
  		);
  		//execute query
  		$creation_query
  			->execute();
  		//collect results
  		$id = $creation_query->fetch();

  		//$id = array => return only integer
  		return $id[0];
  	}

  	/**
  	* Add item to a existing outfit in db (outfititems table)
  	* @param outfit_id, item_id
 	* @return
  	*/
  	private function add_item_to_outfit($outfit_id, $item_id) {
  		//initialize query
  		$insertion_query = DB::connection()
  			->prepare('INSERT INTO Outfititems (fk_outfititems_outfit, fk_outfititems_item)
  				VALUES (:fk_outfit_id, :fk_item_id)'
  		);
		//execute query
		$insertion_query->execute(array(
			'fk_outfit_id' => $outfit_id,
			'fk_item_id' => $item_id
		));
		
  	}

  	/**
  	* Add item to a users collection
  	* $this outfit must have outfit_id!
  	* user 
  	* @param $owner_id = $person_id of the collection owner 
 	* @return
  	*/
  	private function add_to_collection($owner_id) {
  		//check that this object has outfit_id
  		//and owner_id not null
  		if ($this->outfit_id && $owner_id) {
  			//initialize query
  			$collection_insert_query = DB::connection()
  				->prepare('INSERT INTO outfitcollection (
  					fk_outfitcollection_person, fk_outfitcollection_outfit,
  					rating, comment)
  					VALUES (:person_id, :outfit_id, :rating, :comment)'
  			);
  			//execute query
  			$collection_insert_query->execute(array(
  				'person_id' => $owner_id,
  				'outfit_id' => $this->outfit_id,
  				'rating' => $this->rating,
  				'comment' => $this->comment
  			));
  		}
  		

  	}

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

	private static function remove_from_collection_db($person_id, $outfit_id) {
		$remove_query = DB::connection()
			->prepare(' DELETE FROM outfitcollection
				WHERE fk_outfitcollection_person = :person_id
				AND fk_outfitcollection_outfit = :outfit_id'
		);
		$remove_query->execute(array(
			'person_id' => $person_id,
			'outfit_id' => $outfit_id
		));
	}




}