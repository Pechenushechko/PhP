<?php

class DataBase{
    private $sqli;

    function __construct($aSqli)
    {
        $this->sqli = $aSqli;
    }

    function getAnimals(){
        $animals = [];

    $animals_from_db = $this->sqli->query("SELECT * FROM `animals`")->fetch_all(MYSQLI_ASSOC);
    foreach($animals_from_db as $animal){
        $obj = null;

        if($animal['sub_class'] == 'dog'){
            $obj = New Dog($animal['name'], $animal['age'], $animal['type'], 'unknown');
            $obj->id = $animal['id'];
            $obj->setStatus($animal['status']);
        }
        if($animal['sub_class'] == 'cat'){
            $obj = New Cat($animal['name'], $animal['age'], $animal['type'], 'unknown');
            $obj->id = $animal['id'];
            $obj->setStatus($animal['status']);
        }
        if($animal['sub_class'] == 'fish'){
            $obj = new Fish($animal['name'], $animal['age'], $animal['type'], 'неизвестна');
            $obj->id = $animal['id'];
            $obj->setStatus($animal['status']);
        }
        if($obj != null){
            $animals[] = $obj;
        }
    }
        return $animals;
    }

    function updateAnimal($animal, $param, $value)
    {
        if($param == 'status'){
            $animal->setStatus($value);
            $this->sqli->query("UPDATE `animals` SET `status` = '".$value."' WHERE `id` = '".$animal->id."'");
        }
        return;
    }

}


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
    public $id;

    public string $name = 'Meout';
    protected int $age = 1;
    protected string $type = 'predator';
    protected $available_types = ["predator", 'herbivore', 'omnivore'];
    protected $status;
    
    

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

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($aStatus){
        $this->status = $aStatus;
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

abstract class Employee{
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

    public function changeAnimalStatus($animal, $db, $status = '2'){

            return $db->updateAnimal($animal, 'status', $status);
            //$animal->setStatus($status);
    }
}

class Trainer extends Employee{
}

class Courier extends Employee{
}

class Cleaner extends Employee{
}

class Receptionist extends Employee{
        function registAnimal($animal){

        }
}

class Accountant extends Employee{
}

class Boss extends Employee{
        public $email;
        public $phone;
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

$db = new DataBase($sqli = new mysqli('localhost', 'root', '', 'zoostore'));
$animals = $db->getAnimals();



echo "Employee" ."</br>";
$tink = new Vet("Furry", "Silvehand", "01.21", "UIB");
echo "Vet: " .$tink->fname ."</br>";

echo $animals[0]->getStatus()."</br>";

$tink->changeAnimalStatus($animals[0], $db);

echo $animals[0]->name."</br>";
echo $animals[0]->id."</br>";
echo "id: ".$animals[0]->getStatus()."</br>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
        <select name="" id="">
            <?php foreach($animals as $animal){ ?>
             <option value='<?= $animal->id ?>'><?= $animal->name ?></option>
            <?php }?>
        </select>
    </form>
</body>
</html>