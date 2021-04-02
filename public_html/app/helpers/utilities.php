<?php

function createDateTime($input) {
    return DateTime::createFromFormat('Y-n-j H:i:s', $input);
}

   /**
    * Escape the given string
    * @param string $string string to be escaped
    * @return string escaped string
    */
   function escape($string) {
       return htmlspecialchars($string, ENT_QUOTES);
    }