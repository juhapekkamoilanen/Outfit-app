<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      View::make('home.html');

      //echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //$logged_user = self::get_user_logged_in();
      View::make('helloworld.html');
    }

    public static function item_list(){
      View::make('suunnitelmat/item_list.html');
    }
    public static function item_show(){
      View::make('suunnitelmat/item_show.html');
    }
    public static function item_edit(){
      View::make('suunnitelmat/item_edit.html');
    }
    public static function login(){
      View::make('suunnitelmat/login.html');
    }
  }
