<?php

/**
* Takes an input and sanitizes it and places it back in input array
*
*
*/

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,true);
