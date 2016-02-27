<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();
      //Kint::dump('errors()');
      //Kint::dump($errors);

      foreach($this->validators as $validator){
        // Kutsutaan validointimetodia, jonka nimi on validator-muuttujassa
        // palautusarvo (taulukko) lisätään errors-taulukkoon
        $validator_errors = $this->{$validator}();
        //Kint::dump('lisattava:');
        //Kint::dump($validator_errors);
        $errors = array_merge($errors, $validator_errors);
        //Kint::dump($errors);

      }
      
      //Kint::dump($errors);
      //Kint::dump('errors()end');

      return $errors;
    }

    public function validate_string_length($desc, $input, $length) {
      $errors = array();
      //ei saa olla tyhja, null tai whitespacea alussa tai lopussa
      if($input == '' || $input == null || $input != trim($input)) {
        $errors[] = "Please insert $desc";
      }
      if (strlen($input) <= $length) {
        $errors[] = "$desc must be longer than $length characters";
      }
      return $errors;
    }


  }
