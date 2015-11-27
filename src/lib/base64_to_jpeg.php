<?php


function base64_to_jpeg($base64_string) {
    $data = explode(',', $base64_string);
    return base64_decode($data[1]); 
}

?>