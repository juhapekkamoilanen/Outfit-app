<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

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



  $routes->get('/people', function() {
    PersonController::index();
  });

  $routes->get('/items', function() {
    ItemController::index();
  });





