<?php
   function double_number( $n = 5 )
   {
       return $n * 2;
   }

   $int1 = 2;

   echo 'ante int: '.$int1;
   echo "<br/>";
   echo 'dn func: '.double_number($int1);
   echo "<br/>";
   echo 'dn func without input: '.double_number();
   echo "<br/>";
   echo 'post int: '.$int1;

   function only_int($in) : int //типизированное возвращение 
   {
        return $in * 2.5;
   }

    echo "<br/>";
    echo "Только целые: " .only_int(5);

exit();
?>