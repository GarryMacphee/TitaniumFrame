<?php
// Get the title to display at the top of the page
$query_string = explode('=', basename($_SERVER['QUERY_STRING'])); 
$title = strtolower(end($query_string));

