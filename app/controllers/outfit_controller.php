<?php

class OutfitController extends BaseController{

    //Show aĺl outfits in system
	public static function index(){
        $all_outfits = Outfit::get_all_outfits();
        View::make('outfit/all_index.html', array('outfits' => $all_outfits));
	}

    //Show one item - public view
	public static function show($id){
		$outfit = Outfit::get_one_public($id);
		View::make('outfit/outfit_public.html', array('outfit' => $outfit));
	}

	//Näytä tietyn henkilön kaikki vaatteet
	public static function show_all_by_person_id(){
        self::check_logged_in();
        // Haetaan kaikki asut tietokannasta kirjautuneen käyttäjän id:n perusteella
        $persons_outfits = Outfit::find_all_personal($_SESSION['user']);
        View::make('outfit/personal_index.html', array('outfits' => $persons_outfits));
	}

	//Näytä yhden asun yksittäisnäkymä
	public static function show_by_outfit_id($outfit_id){
        self::check_logged_in();
        $persons_outfit = Outfit::find_one_personal($outfit_id, $_SESSION['user']);
        View::make('outfit/outfit.html', array('outfit' => $persons_outfit));
	}

	//Create new - view
	public static function create() {
		self::check_logged_in();
		$persons_items = Wardrobe::find_by_person_id($_SESSION['user']);
        View::make('outfit/new.html', array('items' => $persons_items));
	}

	//Store
    public static function store(){
    	self::check_logged_in();
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST; //array of item_ids (string)
        //View::make('notimplemented.html');
        $user_id = $_SESSION['user'];
        
        if(!$params) {
        	//Redirect::to('/outfits/' . $user_id . 'new/', array('message' => 'Please select items!'));
        }

        $items_in_outfit = Array();

        foreach ($params as $key => $value) {
        	if (strlen($key) == 1) {
        		$items_in_outfit[] = Item::find($value);
        	} else if ($key == 'rating') {
        		$rating = $value;
        	} else if ($key == 'comment') {
        		$comment = $value;
        	}
        }

        $outfit_object = new Outfit(array(
			'outfit_id' => null,
			'items' => $items_in_outfit,
			'rating' => $rating,
			'comment' => $comment
		));


        $outfit_object->save_to_db($user_id);
        
        Redirect::to('/outfits/' . $user_id, array('message' => 'Outfit created!'));
        
    }

	public static function remove_from_collection() {
		$params = $_POST;
		
		$outfit_to_remove = $params['outfit_id'];
		$user_id = $_SESSION['user'];
		
		Outfit::remove_from_collection($user_id, $outfit_to_remove);
		
		Redirect::to('/outfits/' . $user_id, array('message' => 'Outfit removed from collection!'));
		

   	}

    public static function destroy() {
        $params = $_POST;
        
        $outfit_to_remove = $params['outfit_id'];
        $user_id = $_SESSION['user'];
        
        Outfit::destroy_outfit($outfit_to_remove);
        
        Redirect::to('/outfits/', array('message' => 'Outfit removed from system!'));
    }
}