<?php

use Animal as GlobalAnimal;

class Animal{
    public string $name = 'Meout';
    private int $age = 2;
    private string $type = 'predator';
    protected $available_types = ["predator", 'herbivore', 'omnivore'];

    public Cage $cage;

    public function setAge(int $aAge){
        if(!is_numeric($aAge)){
            return "its not a number"."</br>";
        }
        if($aAge < 0 ){
            return ' Age cant be less than 0'."</br>";
        }
        if($aAge > 200) return;
        
        $this->age = $aAge;
    }

    public function getAge(){
        return $this->age;
    }

    public function setType(string $aType){
        if(!in_array($aType, $this->available_types)) return "Type unavailable"."</br>";
        
        $this->type = $aType;
    }

    public function getType(){
        return $this->type;
    }

    public function makeSound(){
            return 'Meow';
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

class Cage{
    public $id;
    public $type;
    public $width;
    public $height;
    public $depth;
    public $weight;
    public $max_weight;

    public Animal $animal;
}

$cat = new Animal();
echo "Animal"."</br>";
echo 'Name of object: '.$cat->name .'</br>';

//echo 'Age of object: '.$cat->age .'</br>'; //not working
echo "Age of object: ".$cat->getAge()."</br>";
echo $cat->setAge(-1);
$cat->setAge(3);
echo "Age of object: ".$cat->getAge()."</br>";

//echo 'Type of object: '.$cat->type .'</br>'; //not working
echo 'Type of object: '.$cat->getType()."</br>";
echo $cat->setType("ada");
$cat->setType("omnivore");
echo 'Type of object: '.$cat->getType()."</br>";

//echo 'Available types of object :'.$cat->available_types .'</br>'; //not working

// $cat->name = 'Hypnomeout';
// echo 'New name of object: '.$cat->name .'</br>';

echo 'Make sound: '.$cat->makeSound();

echo "</br></br></br>";

$alt = new Employee("Johny", "Silverhand", "01.22");
echo "Employee" ."</br>";
echo "Name of object: " .$alt->fname ."</br>";
echo "Last name of object: " .$alt->lname ."</br>";
echo "Birthday of object: " .$alt->birthday ."</br>";

echo "</br></br></br>";

$cage1 = new Cage();
echo "Cages" ."</br>"; 
$cage1->id = 1;
$cage1->type = "house";
$cage1->animal = $cat;
echo "Id of object: " .$cage1->id ."</br>";
echo "Type of object: " . $cage1->type ."</br>";
echo "Animal in cage: " . $cage1->animal->name ."</br>";

?>