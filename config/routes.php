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
  $routes->get('/login/', function() {
    UserController::login();
  });

    $routes->post('/login/', function() {
    UserController::handle_login();
  });

  // Käyttäjät

  $routes->get('/people/', function() {
    UserController::index();
  });

  $routes->post('/logout/', function(){
    UserController::logout();
  });

  $routes->get('/register/', function(){
    UserController::register();
  });

  $routes->post('/register/', function(){
    UserController::handle_register();
  });

  

  // Vaatteet

  // Vaatteiden indeksisivu
  $routes->get('/items/', function() {
    ItemController::index();
  });

  
  
  // Vaatteen lisäyssivu
  $routes->get('/items/new', function() {
    ItemController::create();
  });

  // Vaatteen esittelysivu
  $routes->get('/items/:item_id', function($item_id){
    ItemController::show($item_id);
  });

  // Vaatteen muokkaussivu - esittäminen
  $routes->get('/items/:item_id/edit', function($item_id){
    ItemController::edit($item_id);
  });

  // Vaatteen muokkaussivu - käsittely
  $routes->post('/items/:item_id/edit', function($item_id){
    ItemController::update($item_id);
  });

  // Vaatteen poisto
  $routes->post('/items/:item_id/destroy', function($item_id){
    ItemController::destroy($item_id);
    //HelloWorldController::sandbox();
  });

  // Store
  $routes->post('/items/', function() {
    ItemController::store();
  });


  // Wardrobes

  // Näytä oma vaatekaappi

  $routes->get('/wardrobe/', function(){
    WardrobeController::show_all_by_person_id();
  });

  $routes->get('/wardrobe/:user_id/', function(){
    WardrobeController::show_all_by_person_id();
  });

  // Lisää uusi vaate omaan vaatekaappiin - näkymä
  $routes->get('/wardrobe/:user_id/newitem/', function(){
    WardrobeController::create_new_item_to_wardrobe();
  });

  // Lisää uusi vaate omaan vaatekaappiin - käsittely
  $routes->post('/wardrobe/:user_id/newitem/', function(){
    WardrobeController::save_new_item_to_wardrobe();
  });

  // Lisää olemassa oleva vaate omaan vaatekaappiin
  $routes->post('/wardrobe/:user_id/add/', function(){
    WardrobeController::save_item_to_wardrobe();
  });

  // Poista vaate omasta vaatekaapista
  $routes->post('/wardrobe/:user_id/remove/', function(){
    WardrobeController::remove_item_from_wardrobe();
  });


  //Outfits

  // Outfits - notimplemented
  $routes->get('/outfits', function(){
    OutfitController::index();
  });

  // Näytä henkilön kaikki
  $routes->get('/outfits/:user_id', function(){
    OutfitController::show_all_by_person_id();
  });

  // Näytä yksi asu
  $routes->get('/outfits/:user_id/:outfit_id', function($outfit_id){
    OutfitController::show_by_outfit_id($outfit_id);
  }); 




  




