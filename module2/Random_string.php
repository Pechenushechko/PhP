<?php
    function random_string( $length ) : string
    {
        $symbols = array("=","+","_","-","%","$","@");
        $charachters = array_merge(range("a","z"), range("A", "Z"), range(0,9), $symbols);
        $string = '';
        for($i = 0; $i < $length; $i++){
            shuffle($charachters);
             $string .= $charachters[$i];
        }

        return $string;
    }

    echo random_string(12);
?>