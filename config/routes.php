<?php

  /*
  MUISTA:
  Slim valitsee määrittämistäsi reiteistä ensimmäisen,
  joka vastaa pyynnön polkua.
  Tällöin esimerkiksi pyyntö sovelluksen polkuun
  item/new saattaa mennä sekasin reitin item/:item_id-kanssa. 
  Ongelman ratkaisu on määrittää reitti game/new ennen reittiä game/:id.
  */

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  //Staattiset testisivut

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/login', function() {
    HelloWorldController::login();
  });

    $routes->get('/login', function() {
    HelloWorldController::login();
  });

  // Käyttäjät

  $routes->get('/people', function() {
    PersonController::index();
  });


  // Vaatteet

  // Vaatteiden indeksisivu
  $routes->get('/items', function() {
    ItemController::index();
  });

  // Store
  $routes->post('/items', function() {
    ItemController::store();
  });
  
  // Vaatteen lisäyssivu
  $routes->get('/items/new', function() {
    ItemController::create();
  });

  // Vaatteen esittelysivu
  $routes->get('/items/:item_id', function($item_id){
    ItemController::show($item_id);
  });

  // Wardrobes

  // Yleiskuva - notimplemented
  $routes->get('/wardrobe', function(){
    WardrobeController::kesken();
  });  

  // Lisää vaate omaan kaappiin
  // person_id sessiosta!
  $routes->get('/wardrobe/add', function(){
    WardrobeController::kesken();
  });  

  // Vaatekaappi - yksittäisen kaapin listanäkymä
  $routes->get('/wardrobe/:person_id', function($person_id){
    WardrobeController::show_all_by_person_id($person_id);
  });


  //Outfits

  // Outfits - notimplemented
  $routes->get('/outfits', function(){
    OutfitController::index();
  });  




  




