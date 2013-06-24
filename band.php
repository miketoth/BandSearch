
<?php


class Band{

    private $name; // name of artists
    private $member; // acts artist is associated with

    public function __construct($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function getMember(){
        return $this->member;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function setMember($member){
        $this->member = $member;
    }

    public function addMember($member){
        $member[] = $member;
    }

}

?>
