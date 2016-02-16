<?php

  class BaseController{

    public static function get_user_logged_in(){
      //katsotaan onko session-globaaliin tallennettu 'user'-avainta
      if(isset($_SESSION['user'])){
        //jos on niin niin poimitaan sen arvo
        $user_id = $_SESSION['user'];
        //ja luodaan olio user-luokan find-metodilla
        $user_object = Person::find($user_id);

        return $user_object;
      }
      //ei löytynyt eli käyttäjä ei ole kirjautunut
      return null;  
    }

    public static function check_logged_in(){
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
