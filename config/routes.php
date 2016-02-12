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



  $routes->get('/items/1', function() {
    HelloWorldController::item_show();
  });

  $routes->get('/items/1/edit', function() {
    HelloWorldController::item_edit();
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
  




