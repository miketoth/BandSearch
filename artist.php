<?php


class Artist{

    public $name; // name of artists
    public $bands = array(); // acts artist is associated with

    public function __construct($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function getBands(){
        return $this->bands;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setBands($bands){
        $this->bands = $bands;
    }

    public function addBand($band){
        array_push($this->bands,  $band);
    }
    public function getBand($i){
        return $this->bands[$i];
    }

}

?>
