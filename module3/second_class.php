<?php

use Animal as GlobalAnimal;
use Employee as GlobalEmployee;

interface Feedable{
    

    function getFood();
}

trait CanBeCaged{
    private Cage $cage;

    function getCage(){
        return $this->cage;
    }

    function setCage(Cage $cage){
        $this->cage = $cage;
    }



}

trait CanBeVaccinated{
    private $is_vaccinated = false;
    private $vaccinated_date = '';

    public function getVacStatus(){
        if($this->is_vaccinated)return $this->vaccinated_date;
        return false;
    }

    public function setVacStatus($status = false, $date = ''){
        $date = date("D.m.Y");
        $this->is_vaccinated = $status;
        $this->vaccinated_date = $date;
    }
}

abstract class Animal implements Feedable{
    use CanBeCaged;
    public string $name = 'Meout';
    protected int $age = 1;
    protected string $type = 'predator';
    protected $available_types = ["predator", 'herbivore', 'omnivore'];
    
    

    function __construct($aName, $aAge, $aType){
        $this->name = $aName;
        if(is_numeric($aAge) && $aAge > 0 && $aAge < 200)$this->age = $aAge;
        if(in_array($aType, $this->available_types)) $this->type = $aType;
    }

    public function getAge(){
        return $this->age;
    }

    public function getType(){
        return $this->type;
    }

    public function eat(){
        return "I eat";
    }

    public abstract function makeSound();

    function getFood(){

    }
}

class Dog extends Animal{
    use CanBeVaccinated;
   public $breed;

   function __construct($aName, $aAge, $aType, $aBreed){
        parent::__construct($aName, $aAge, $aType);
        $this->breed = $aBreed;
   }

   function makeSound()
   {
    return "Raw Raw";
   }
}
class Cat extends Animal{
    use CanBeVaccinated;
    public $breed;

   function __construct($aName, $aAge, $aType, $aBreed){
        parent::__construct($aName, $aAge, $aType);
        $this->breed = $aBreed;
   }
   function makeSound()
   {
    return "Meow Meow";
   }
}
class Bird extends Animal{
    use CanBeVaccinated;
    public $can_fly;

    function __construct($aName, $aAge, $aType, $aCanFly){
        parent::__construct($aName, $aAge, $aType);
        $this->can_fly = $aCanFly;
   }
   function makeSound()
   {
    return "Sing";
   }
}
class Fish extends Animal{
    public $arial;

    function __construct($aName, $aAge, $aType, $aArial){
        parent::__construct($aName, $aAge, $aType);
        $this->arial = $aArial;
   }
   function makeSound()
   {
    return "Blob blob";
   }
}

class Employee{
    public $fname;
    public $mname;
    public $lname;
    public $birthday;

    function __construct($aFname, $aLname, $aBirthday ,$aMname = ''){
        $this->fname = $aFname;
        $this->lname = $aLname;
        $this->birthday = $aBirthday;
        $this->mname = $aMname;
    }
}

class Vet extends Employee{
    public $degree;
   
    function __construct($aFname, $aLname, $aBirthday , $aDegree, $aMname = ''){
         parent::__construct($aFname, $aLname, $aBirthday ,$aMname = '');
        
        $this->degree = $aDegree;
    }

    function checkAnimal($animal)
    {
        if(get_parent_class($animal) == "Animal"){
        if(method_exists($animal, 'setVacStatus')){ 
            $animal->setVacStatus(true, date("d.m.y")); 
            return $animal->getVacStatus();    
            }
        return "Animal cant be vaccinated</br>";
        } 
        return "only Animals</br>";
    }   
}

class Cage{
    public $id;
    public $type;
    public $width;
    public $height;
    public $depth;
    public $weight;
    public $max_weight;

    public Animal $animal;

    function __construct($aId, $aType){
        $this->id = $aId;
        $this->type = $aType;
    }
        
}

//Abstract class object
// $cat = new Animal("Mur", 2, "predator");
// echo "Animal"."</br>";
// echo 'Name of object: '.$cat->name .'</br>';
// echo "Age of object: ".$cat->getAge()."</br>";
// echo 'Type of object: '.$cat->getType()."</br>";
// echo 'Make sound: '.$cat->makeSound();

$limbo = new Dog("limbo", 3, "omnivore", "Mops");
$gar = new Cat("Garfield", 3, "preadator", "siam");
$nemo = new Fish("Nemo", 1, 'omnivore', "ocean");
$tweet = new Bird("Tweety", 1, "herbivore", true);

echo "Gar: ".$gar->makeSound()."</br>";
echo "Limbo: ".$limbo->makeSound()."</br>";
echo "Nemo: ".$nemo->makeSound()."</br>";
echo "Tweet: ".$tweet->makeSound()."</br>";


echo "</br></br></br>";

// $alt = new Employee("Johny", "Silverhand", "01.22");
 echo "Employee" ."</br>";
// echo "Name of object: " .$alt->fname ."</br>";
// echo "Last name of object: " .$alt->lname ."</br>";
// echo "Birthday of object: " .$alt->birthday ."</br>";



$tink = new Vet("Furry", "Silvehand", "01.21", "UIB");
echo "Vet: " .$tink->fname ."</br>";
echo $tink->checkAnimal($limbo) ."</br>";
echo $tink->checkAnimal($gar); 
echo "</br>";
                  
     

echo "</br></br>";

$cage1 = new Cage(1, "House");
echo "Cages" ."</br>"; 
$cage1->animal = $gar;
echo "Id of object: " .$cage1->id ."</br>";
echo "Type of object: " . $cage1->type ."</br>";
echo "Animal in cage: " . $cage1->animal->name ."</br>";

?>